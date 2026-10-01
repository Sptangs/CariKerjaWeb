<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function dashboard(): View
    {
        return view('company.dashboard');
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
}
