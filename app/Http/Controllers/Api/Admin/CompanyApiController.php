<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));

        $companies = Company::query()
            ->select(['id', 'user_id', 'company_name', 'created_at'])
            ->with('user:id,name,email')
            ->withCount(['jobs', 'applications'])
            ->when($search !== '', function ($query) use ($search): void {
                $keyword = '%'.addcslashes($search, '%_\\').'%';

                $query->where(function ($query) use ($keyword): void {
                    $query->where('company_name', 'like', $keyword)
                        ->orWhereHas('user', function ($query) use ($keyword): void {
                            $query->where('name', 'like', $keyword)
                                ->orWhere('email', 'like', $keyword);
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return response()->json(['data' => $companies]);
    }

    public function show(Company $company): JsonResponse
    {
        $company->load('user:id,name,email')
            ->loadCount(['jobs', 'applications']);

        return response()->json([
            'message' => 'Company details retrieved successfully.',
            'data' => $company,
        ]);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'address' => ['nullable', 'string', 'max:5000'],
        ]);

        $company->update($validated);

        return response()->json([
            'message' => 'Company profile updated successfully.',
            'data' => $company->fresh()->load('user:id,name,email'),
        ]);
    }

    public function destroy(Company $company): JsonResponse
    {
        DB::transaction(function () use ($company): void {
            $jobIds = $company->jobs()->pluck('id');

            Application::whereIn('job_id', $jobIds)->delete();
            $company->jobs()->delete();
            $company->delete();
            $company->user?->delete();
        });

        return response()->json([
            'message' => 'Company, its owner account, and all related data deleted successfully.',
        ]);
    }
}
