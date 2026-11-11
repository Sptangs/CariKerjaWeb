<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminApiController extends Controller
{
    public function dashboard(): JsonResponse
    {
        return response()->json([
            'data' => [
                'user_count' => User::count(),
                'company_count' => Company::count(),
                'job_posting_count' => JobPosting::count(),
                'application_count' => Application::count(),
            ],
        ]);
    }
}
