<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class JobSeekerProfileApiController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $profile = $user->jobSeekerProfile;

        return response()->json([
            'data' => [
                'user' => $user->only(['id', 'name', 'email']),
                'profile' => $profile?->only(['id', 'phone', 'address', 'education']),
                'has_cv' => filled($profile?->cv_path),
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:5000'],
            'education' => ['nullable', 'string', 'max:255'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $oldCvPath = $user->jobSeekerProfile?->cv_path;
        $newCvPath = $request->file('cv')?->store('job-seeker-cv', 'local');

        if ($request->hasFile('cv') && ! is_string($newCvPath)) {
            return response()->json([
                'message' => 'The CV could not be saved. Please try again.',
            ], 500);
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
            if (! Storage::disk('local')->delete($oldCvPath)) {
                return response()->json([
                    'message' => 'The profile was updated, but the old CV could not be deleted.',
                ], 500);
            }
        }

        $profile = $user->jobSeekerProfile()->first();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => [
                'user' => $user->only(['id', 'name', 'email']),
                'profile' => $profile?->only(['id', 'phone', 'address', 'education']),
                'has_cv' => filled($profile?->cv_path),
            ],
        ]);
    }

    public function downloadCv(Request $request): StreamedResponse
    {
        $cvPath = $request->user()->jobSeekerProfile?->cv_path;
        abort_unless(is_string($cvPath), 404);

        $stream = Storage::disk('local')->readStream($cvPath);
        abort_unless(is_resource($stream), 404);

        return response()->streamDownload(function () use ($stream): void {
            try {
                fpassthru($stream);
            } finally {
                fclose($stream);
            }
        }, basename($cvPath));
    }

    public function deleteCv(Request $request): JsonResponse
    {
        $user = $request->user();
        abort_unless($user instanceof User, 401);

        $profile = $user->jobSeekerProfile;
        if ($profile === null) {
            return response()->json(['message' => 'Profile not found.'], 404);
        }

        if (is_string($profile->cv_path)) {
            if (! Storage::disk('local')->delete($profile->cv_path)) {
                return response()->json(['message' => 'The CV could not be deleted. Please try again.'], 500);
            }

            $profile->cv_path = null;
            $profile->save();
        }

        return response()->json([
            'message' => 'CV deleted successfully.',
            'data' => ['has_cv' => false],
        ]);
    }
}
