<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();

        if (! ($user instanceof User)) {
            abort(403);
        }

        $hasCv = filled($user->jobSeekerProfile?->cv_path);

        $totalApplications = $user->applications()->count();

        $openJobs = JobPosting::query()
            ->whereRaw('LOWER(status) = ?', ['open']);

        $openJobsCount = (clone $openJobs)->count();

        $latestJobs = (clone $openJobs)
            ->select(['id', 'company_id', 'title', 'location', 'employment_type'])
            ->with('company:id,company_name')
            ->latest()
            ->take(4)
            ->get();

        $recentApplications = $user->applications()
            ->select(['id', 'job_id', 'user_id', 'status', 'created_at'])
            ->with([
                'job:id,company_id,title',
                'job.company:id,company_name',
            ])
            ->latest()
            ->take(3)
            ->get();

        return view('job-seeker.dashboard', compact(
            'hasCv',
            'totalApplications',
            'openJobsCount',
            'latestJobs',
            'recentApplications'
        ));
    }

    public function lowongan(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $location = trim((string) $request->query('location', ''));

        $locations = JobPosting::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        $jobs = JobPosting::query()
            ->select([
                'id',
                'company_id',
                'title',
                'location',
                'employment_type',
                'description',
            ])
            ->with('company:id,company_name')
            ->when($search !== '', function ($query) use ($search) {
                $keyword = '%'.addcslashes($search, '%_\\').'%';

                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', $keyword)
                        ->orWhere('description', 'like', $keyword)
                        ->orWhereHas('company', function ($company) use ($keyword) {
                            $company->where('company_name', 'like', $keyword);
                        });
                });
            })
            ->when($location !== '', fn ($query) => $query->where('location', $location))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('job-seeker.lowongan', compact(
            'jobs',
            'locations',
            'search',
            'location'
        ));
    }

    public function riwayat(): View
    {
        $user = Auth::user();

        if (! ($user instanceof User)) {
            abort(403);
        }

        $applications = $user->applications()
            ->select(['id', 'job_id', 'user_id', 'status', 'created_at'])
            ->with([
                'job:id,company_id,title,location',
                'job.company:id,company_name',
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('job-seeker.riwayat', compact('applications'));
    }

    public function detailLowongan(JobPosting $job): View
    {
        $job->load('company');

        $user = Auth::user();

        if (! ($user instanceof User)) {
            abort(403);
        }

        $hasApplied = $user->applications()
            ->where('job_id', $job->getKey())
            ->exists();

        return view(
            'job-seeker.detail-lowongan',
            compact('job', 'hasApplied')
        );
    }

    public function apply(Request $request, JobPosting $job): RedirectResponse
    {
        $user = Auth::user();

        if (! ($user instanceof User)) {
            abort(403);
        }

        if (strtolower($job->status) !== 'open') {
            return redirect()
                ->route('job-seeker.lowongan.detail', $job)
                ->with('status', 'Lowongan sudah ditutup dan tidak dapat dilamar.');
        }

        $validated = $request->validate([
            'cover_letter' => ['required', 'string', 'min:30', 'max:5000'],
        ], [
            'cover_letter.required' => 'Cover letter wajib diisi.',
            'cover_letter.min' => 'Cover letter minimal 30 karakter.',
            'cover_letter.max' => 'Cover letter maksimal 5000 karakter.',
        ]);

        $application = $user->applications()->firstOrCreate(
            ['job_id' => $job->getKey()],
            ['cover_letter' => $validated['cover_letter']]
        );

        if (! $application->wasRecentlyCreated) {
            return redirect()
                ->route('job-seeker.riwayat')
                ->with('status', 'Kamu sudah melamar lowongan ini.');
        }

        return redirect()
            ->route('job-seeker.riwayat')
            ->with('status', 'Lamaran berhasil dikirim.');
    }

    public function formLamaran(Request $request, JobPosting $job)
    {
        $user = $request->user();

        $profile = $user->jobSeekerProfile;

        if (! $profile?->cv_path) {
            return redirect()
                ->route('job-seeker.profile')
                ->with('error', 'Silakan upload CV terlebih dahulu sebelum melamar pekerjaan.');
        }

        $hasApplied = Application::where('job_id', $job->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($hasApplied) {
            return redirect()
                ->route('job-seeker.lowongan.detail', $job->id)
                ->with('error', 'Anda sudah melamar pekerjaan ini.');
        }

        $job->load('company');

        return view('job-seeker.lamaran', [
            'job' => $job,
            'profile' => $profile,
        ]);
    }
}
