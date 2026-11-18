<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobPostingApiController extends Controller
{
    private const STATUSES = ['open', 'closed'];

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(self::STATUSES)],
            'company' => ['nullable', 'integer', 'exists:companies,id'],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $status = (string) ($validated['status'] ?? '');
        $companyId = (int) ($validated['company'] ?? 0);

        $jobPostings = JobPosting::query()
            ->select([
                'id',
                'company_id',
                'title',
                'location',
                'employment_type',
                'salary_min',
                'salary_max',
                'description',
                'requirements',
                'status',
                'created_at',
                'updated_at',
            ])
            ->with('company:id,company_name')
            ->withCount('applications')
            ->when($search !== '', function ($query) use ($search): void {
                $keyword = '%'.addcslashes($search, '%_\\').'%';

                $query->where(function ($query) use ($keyword): void {
                    $query->where('title', 'like', $keyword)
                        ->orWhere('location', 'like', $keyword);
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($companyId > 0, fn ($query) => $query->where('company_id', $companyId))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return response()->json(['data' => $jobPostings]);
    }

    public function show(JobPosting $jobPosting): JsonResponse
    {
        $jobPosting->load('company:id,company_name')
            ->loadCount('applications');

        return response()->json([
            'message' => 'Job posting details retrieved successfully.',
            'data' => $jobPosting,
        ]);
    }

    public function update(Request $request, JobPosting $jobPosting): JsonResponse
    {
        $jobPosting->update($this->jobRules($request));

        return response()->json([
            'message' => 'Job posting updated successfully.',
            'data' => $jobPosting->fresh()->load('company:id,company_name'),
        ]);
    }

    public function changeStatus(Request $request, JobPosting $jobPosting): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $jobPosting->update($validated);

        return response()->json([
            'message' => 'Job posting status updated successfully.',
            'data' => $jobPosting->fresh(),
        ]);
    }

    public function destroy(JobPosting $jobPosting): JsonResponse
    {
        DB::transaction(function () use ($jobPosting): void {
            $jobPosting->applications()->delete();
            $jobPosting->delete();
        });

        return response()->json([
            'message' => 'Job posting and its applications deleted successfully.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function jobRules(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'status' => ['required', Rule::in(self::STATUSES)],
        ], [
            'salary_max.gte' => 'The maximum salary must be greater than or equal to the minimum salary.',
        ]);
    }
}
