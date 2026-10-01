<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use App\Models\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class JobSeekerController extends Controller
{
    public function dashboard(): View
    {
        return view('job-seeker.dashboard');
    }

    public function lowongan(): View
    {
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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('job-seeker.lowongan', compact('jobs'));
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

    public function apply(JobPosting $job): RedirectResponse
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

        $application = $user->applications()->firstOrCreate([
            'job_id' => $job->getKey(),
        ]);

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
