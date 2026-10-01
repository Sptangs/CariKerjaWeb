<?php

namespace App\Http\Controllers;

class JobSeekerController extends Controller
{
    public function dashboard()
    {
        return view('job-seeker.dashboard');
    }

public function lowongan()
{
    $jobs = \App\Models\JobPosting::with('company')
        ->latest()
        ->get();

    return view('job-seeker.lowongan', compact('jobs'));
}

    public function riwayat()
    {
        return view('job-seeker.riwayat');
    }
}