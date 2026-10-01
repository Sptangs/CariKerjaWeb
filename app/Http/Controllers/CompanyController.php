<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CompanyController extends Controller
{
    public function dashboard(): View
    {
        return view('company.dashboard');
    }
}