<?php

namespace App\Http\Controllers\Api;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\JobPosting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompanyApiController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $company = $this->companyFor($request);
        $applications = Application::whereHas('job', fn ($query) => $query->where('company_id', $company->id));

        return response()->json([
            'data' => [
                'total_jobs' => $company->jobs()->count(),
                'active_jobs' => $company->jobs()->where('status', 'open')->count(),
                'total_applications' => (clone $applications)->count(),
                'pending_applications' => (clone $applications)->where('status', 'pending')->count(),
                'latest_applications' => (clone $applications)->with('user', 'job')->latest()->take(5)->get(),
            ],
        ]);
    }

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();
        $company = $this->companyFor($request);

        return response()->json([
            'data' => [
                'user' => $user->only(['id', 'name', 'email']),
                'company' => $company,
            ],
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'company_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'address' => ['nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($user, $validated): void {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $user->company()->updateOrCreate([], [
                'company_name' => $validated['company_name'],
                'description' => $validated['description'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);
        });

        return response()->json([
            'message' => 'Company profile updated successfully.',
            'data' => [
                'user' => $user->only(['id', 'name', 'email']),
                'company' => $user->company()->first(),
            ],
        ]);
    }

    public function jobs(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->companyFor($request)->jobs()->latest()->paginate(15),
        ]);
    }

    public function showJob(Request $request, JobPosting $jobPosting): JsonResponse
    {
        $this->ensureOwnsJob($request, $jobPosting);

        return response()->json(['data' => $jobPosting]);
    }

    public function storeJob(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'status' => ['required', Rule::in(['open', 'closed'])],
        ], [
            'salary_max.gte' => 'The maximum salary must be greater than or equal to the minimum salary.',
        ]);

        $jobPosting = $this->companyFor($request)->jobs()->create($validated);

        return response()->json([
            'message' => 'Job posting created successfully.',
            'data' => $jobPosting,
        ], 201);
    }

    public function updateJob(Request $request, JobPosting $jobPosting): JsonResponse
    {
        $this->ensureOwnsJob($request, $jobPosting);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);

        $jobPosting->update($validated);

        return response()->json([
            'message' => 'Job posting updated successfully.',
            'data' => $jobPosting->fresh(),
        ]);
    }

    public function closeJob(Request $request, JobPosting $jobPosting): JsonResponse
    {
        $this->ensureOwnsJob($request, $jobPosting);
        $jobPosting->update(['status' => 'closed']);

        return response()->json([
            'message' => 'Job posting closed successfully.',
            'data' => $jobPosting->fresh(),
        ]);
    }

    public function applications(Request $request, JobPosting $jobPosting): JsonResponse
    {
        $this->ensureOwnsJob($request, $jobPosting);

        return response()->json([
            'data' => $jobPosting->applications()->with('user')->latest()->paginate(15),
        ]);
    }

    public function updateApplicationStatus(Request $request, Application $application): JsonResponse
    {
        abort_unless($application->job->company_id === $this->companyFor($request)->id, 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['accepted', 'rejected'])],
        ]);

        $application->update($validated);

        return response()->json([
            'message' => 'Applicant status updated successfully.',
            'data' => $application->fresh()->load('user', 'job'),
        ]);
    }

    public function downloadApplicantCv(Request $request, Application $application): StreamedResponse
    {
        abort_unless($application->job->company_id === $this->companyFor($request)->id, 403);

        $cvPath = $application->user->jobSeekerProfile?->cv_path;
        abort_unless(is_string($cvPath), 404);

        $stream = Storage::disk('local')->readStream($cvPath);
        abort_unless(is_resource($stream), 404);

        return response()->streamDownload(function () use ($stream): void {
            try {
                fpassthru($stream);
            } finally {
                fclose($stream);
            }
        }, basename($cvPath));
    }

    public function exportExcel(Request $request): Response
    {
        return Excel::download(
            new LaporanExport($this->companyFor($request)->id),
            'laporan-pelamar.xlsx'
        );
    }

    private function companyFor(Request $request): Company
    {
        $company = $request->user()->company;
        abort_unless($company instanceof Company, 404);

        return $company;
    }

    private function ensureOwnsJob(Request $request, JobPosting $jobPosting): void
    {
        abort_unless($jobPosting->company_id === $this->companyFor($request)->id, 403);
    }
}
