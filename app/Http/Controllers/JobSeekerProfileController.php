<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class JobSeekerProfileController extends Controller
{
    public function dashboard(): View
    {
        return view('job-seeker.dashboard');
    }

    public function profile(Request $request): View
    {
        $user = $request->user();

        return view('job-seeker.profile', [
            'user' => $user,
            'profile' => $user->jobSeekerProfile,
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
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:5000'],
            'education' => ['nullable', 'string', 'max:255'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $oldCvPath = $user->jobSeekerProfile?->cv_path;
        $newCvPath = $request->file('cv')?->store('job-seeker-cv', 'local');

        if ($request->hasFile('cv') && $newCvPath === false) {
            return back()
                ->withErrors(['cv' => 'CV gagal disimpan. Silakan coba lagi.'])
                ->withInput();
        }

        try {
            DB::transaction(function () use ($user, $validated, $newCvPath): void {
                $user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);

                $profileData = [
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'education' => $validated['education'] ?? null,
                ];

                if (is_string($newCvPath)) {
                    $profileData['cv_path'] = $newCvPath;
                }

                $user->jobSeekerProfile()->updateOrCreate([], $profileData);
            });
        } catch (Throwable $exception) {
            if (is_string($newCvPath)) {
                Storage::disk('local')->delete($newCvPath);
            }

            throw $exception;
        }

        if (is_string($newCvPath) && is_string($oldCvPath)) {
            Storage::disk('local')->delete($oldCvPath);
        }

        return redirect()
            ->route('job-seeker.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function downloadCv(Request $request): StreamedResponse
    {
        $cvPath = $request->user()->jobSeekerProfile?->cv_path;

        abort_unless(is_string($cvPath), 404);

        $stream = Storage::disk('local')->readStream($cvPath);

        if (! is_resource($stream)) {
            abort(404);
        }

        return response()->streamDownload(function () use ($stream): void {
            try {
                fpassthru($stream);
            } finally {
                fclose($stream);
            }
        }, basename($cvPath));
    }

    public function deleteCv(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! ($user instanceof User)) {
            abort(403);
        }

        $profile = $user->jobSeekerProfile;

        if (! $profile) {
            return redirect()
                ->route('job-seeker.profile')
                ->with('error', 'Profil tidak ditemukan.');
        }

        if ($profile->cv_path) {
            Storage::disk('public')->delete($profile->cv_path);

            $profile->cv_path = null;
            $profile->save();
        }

        return redirect()
            ->route('job-seeker.profile')
            ->with('success', 'CV berhasil dihapus.');
    }
}
