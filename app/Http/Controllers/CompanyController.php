<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function dashboard(Request $request): View
    {
        $company = $request->user()->company;

        // ngitung statistik
        $totalLowongan = $company->jobs()->count();
        $lowonganAktif = $company->jobs()->where('status', 'open')->count();
        $totalPelamar = Application::whereHas('job', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();
        $pelamarMenunggu = Application::whereHas('job', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->where('status', 'pending')->count();

        // ambil 5 terbaru
        $pelamarTerbaru = Application::whereHas('job', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->with('user', 'job')->latest()->take(5)->get();
        
        return view('company.dashboard', compact('totalLowongan', 'lowonganAktif', 'totalPelamar', 'pelamarMenunggu', 'pelamarTerbaru'));
    }

    public function profile(Request $request): View
    {
        $user = $request->user();

        return view('company.profile', [
            'user' => $user,
            'company' => $user->company,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
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

        return redirect()
            ->route('company.profile')
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    //lowongan
    public function lowongan(Request $request): View
    {
        $company = $request->user()->company;
        $jobPostings = $company->jobs()->latest()->get();

        return view('company.lowongan', compact('jobPostings'));
    }

    public function createLowongan(): View
    {
        return view('company.buat-lowongan');
    }

    public function storeLowongan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'status' => ['required', 'in:open,closed'],
        ], [
            'salary_max.gte' => 'Gaji maksimum harus lebih besar atau sama dengan gaji minimum.',
        ]);

        $request->user()->company->jobs()->create($validated);

        return redirect()
            ->route('company.lowongan')
            ->with('success', 'Lowongan berhasil dibuat.');
    }

    public function editLowongan(Request $request, JobPosting $jobPosting): View
    {
        abort_if($request->user()->company->id !== $jobPosting->company->id, 403);

        return view('company.edit-lowongan', compact('jobPosting'));
    }

    public function updateLowongan(Request $request, JobPosting $jobPosting): RedirectResponse
    {
        abort_if($request->user()->company->id !== $jobPosting->company->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'status' => ['required', 'in:open,closed'],
        ]);

        $jobPosting->update($validated);

        return redirect()
            ->route('company.lowongan')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function tutupLowongan(Request $request, JobPosting $jobPosting): RedirectResponse
    {
        abort_if($request->user()->company->id !== $jobPosting->company->id, 403);

        $jobPosting->update(['status' => 'closed']);

        return redirect()
            ->route('company.lowongan')
            ->with('success', 'Lowongan berhasil ditutup.');
    }

    //pelamar
    public function pelamar(Request $request, JobPosting $jobPosting): View
    {
        abort_if($jobPosting->company->id !== $request->user()->company->id, 403);

        $applications = $jobPosting->applications()->with('user')->latest()->get();

        return view('company.pelamar', compact('jobPosting', 'applications'));
    }

    public function terimaPelamar(Request $request, Application $application): RedirectResponse
    {
        abort_if($application->job->company_id !== $request->user()->company->id, 403);

        $application->update(['status' => 'accepted']);

        return back()->with('success', 'Pelamar berhasil diterima.');
    }

    public function tolakPelamar(Request $request, Application $application): RedirectResponse
    {
        abort_if($application->job->company_id !== $request->user()->company->id, 403);

        $application->update(['status' => 'rejected']);

        return back()->with('success', 'Pelamar berhasil ditolak.');
    }
}