<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationApiController extends Controller
{
    private const STATUSES = ['pending', 'accepted', 'rejected'];

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(self::STATUSES)],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $status = (string) ($validated['status'] ?? '');

        $applications = Application::query()
            ->select(['id', 'job_id', 'user_id', 'status', 'created_at', 'updated_at'])
            ->with(['user:id,name,email', 'job:id,company_id,title', 'job.company:id,company_name'])
            ->when($search !== '', function ($query) use ($search): void {
                $keyword = '%'.addcslashes($search, '%_\\').'%';

                $query->where(function ($query) use ($keyword): void {
                    $query->whereHas('user', function ($query) use ($keyword): void {
                        $query->where('name', 'like', $keyword)
                            ->orWhere('email', 'like', $keyword);
                    })->orWhereHas('job', function ($query) use ($keyword): void {
                        $query->where('title', 'like', $keyword);
                    });
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return response()->json(['data' => $applications]);
    }

    public function changeStatus(Request $request, Application $application): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $application->update($validated);

        return response()->json([
            'message' => 'Application status updated successfully.',
            'data' => $application->fresh()->load(['user:id,name,email', 'job:id,company_id,title']),
        ]);
    }

    public function destroy(Application $application): JsonResponse
    {
        $application->delete();

        return response()->json([
            'message' => 'Application deleted successfully.',
        ]);
    }
}
