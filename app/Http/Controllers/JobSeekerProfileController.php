<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class JobSeekerProfileController extends Controller
{
    public function dashboard(): View
    {
        return view('job-seeker.dashboard');
    }
}