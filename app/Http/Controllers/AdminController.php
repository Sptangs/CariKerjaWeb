<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'companyCount' => Company::count(),
            'jobPostingCount' => JobPosting::count(),
            'applicationCount' => Application::count(),
        ]);
    }
}
