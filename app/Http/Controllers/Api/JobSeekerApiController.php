<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobSeekerApiController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        $openJobs = JobPosting::query()->whereRaw('LOWER(status) = ?', ['open']);

        return response()->json([
            'data' => [
                'has_cv' => filled($user->jobSeekerProfile?->cv_path),
                'total_applications' => $user->applications()->count(),
                'open_jobs_count' => (clone $openJobs)->count(),
                'latest_jobs' => (clone $openJobs)
                    ->with('company:id,company_name')
                    ->latest()
                    ->take(4)
                    ->get(),
                'recent_applications' => $user->applications()
                    ->with(['job:id,company_id,title', 'job.company:id,company_name'])
                    ->latest()
                    ->take(3)
                    ->get(),
            ],
        ]);
    }

    public function jobs(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $location = trim((string) ($validated['location'] ?? ''));
        $keyword = '%'.addcslashes($search, '%_\\').'%';

        $jobs = JobPosting::query()
            ->whereRaw('LOWER(status) = ?', ['open'])
            ->with('company:id,company_name')
            ->when($search !== '', function ($query) use ($keyword): void {
                $query->where(function ($query) use ($keyword): void {
                    $query->where('title', 'like', $keyword)
                        ->orWhere('description', 'like', $keyword)
                        ->orWhereHas('company', function ($company) use ($keyword): void {
                            $company->where('company_name', 'like', $keyword);
                        });
                });
            })
            ->when($location !== '', fn ($query) => $query->where('location', $location))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $locations = JobPosting::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        return response()->json([
            'data' => $jobs,
            'meta' => [
                'locations' => $locations,
                'search' => $search,
                'location' => $location,
            ],
        ]);
    }

    public function applications(Request $request): JsonResponse
    {
        $applications = $request->user()->applications()
            ->with(['job:id,company_id,title,location', 'job.company:id,company_name'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json(['data' => $applications]);
    }

    public function showJob(Request $request, JobPosting $job): JsonResponse
    {
        $job->load('company');

        return response()->json([
            'data' => [
                'job' => $job,
                'has_applied' => $request->user()->applications()
                    ->where('job_id', $job->getKey())
                    ->exists(),
            ],
        ]);
    }

    public function applicationForm(Request $request, JobPosting $job): JsonResponse
    {
        $user = $request->user();
        $profile = $user->jobSeekerProfile;

        if (! $profile?->cv_path) {
            return response()->json([
                'message' => 'Please upload your CV before applying for a job.',
            ], 422);
        }

        if ($user->applications()->where('job_id', $job->id)->exists()) {
            return response()->json([
                'message' => 'You have already applied for this job.',
            ], 409);
        }

        return response()->json([
            'data' => [
                'job' => $job->load('company'),
                'can_apply' => strtolower($job->status) === 'open',
            ],
        ]);
    }

    public function apply(Request $request, JobPosting $job): JsonResponse
    {
        if (strtolower($job->status) !== 'open') {
            return response()->json([
                'message' => 'This job posting is closed and no longer accepting applications.',
            ], 409);
        }

        $validated = $request->validate([
            'cover_letter' => ['required', 'string', 'min:30', 'max:5000'],
        ], [
            'cover_letter.required' => 'A cover letter is required.',
            'cover_letter.min' => 'The cover letter must be at least 30 characters.',
            'cover_letter.max' => 'The cover letter may not exceed 5000 characters.',
        ]);

        $application = $request->user()->applications()->firstOrCreate(
            ['job_id' => $job->getKey()],
            ['cover_letter' => $validated['cover_letter']]
        );

        if (! $application->wasRecentlyCreated) {
            return response()->json([
                'message' => 'You have already applied for this job.',
                'data' => $application,
            ], 409);
        }

        return response()->json([
            'message' => 'Application submitted successfully.',
            'data' => $application,
        ], 201);
    }
}
