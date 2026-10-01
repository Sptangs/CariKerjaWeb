<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::in(['job_seeker', 'company'])],
            'company_name' => ['required_if:role,company', 'nullable', 'string', 'max:255'],
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'], 
                'role' => $data['role'],
            ]);

            if ($user->role === 'company') {
                $user->company()->create(['company_name' => $data['company_name']]);
            } else {
                $user->jobSeekerProfile()->create([]);
            }

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route($this->dashboardRoute($user))
            ->with('success', 'Registrasi berhasil. Selamat datang di CariKerja!');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()
            ->route($this->dashboardRoute($request->user()))
            ->with('success', 'Berhasil masuk.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda sudah keluar.');
    }

    private function dashboardRoute(User $user): string
    {
        return $user->role === 'company'
            ? 'company.dashboard'
            : 'job-seeker.dashboard';
    }
}