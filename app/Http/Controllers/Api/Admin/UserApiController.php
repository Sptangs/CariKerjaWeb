<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserApiController extends Controller
{
    private const ROLES = ['job_seeker', 'company', 'admin'];

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::in(self::ROLES)],
            'company_name' => ['required_if:role,company', 'nullable', 'string', 'max:255'],
        ]);

        $user = DB::transaction(function () use ($validated): User {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $validated['role'],
            ]);

            if ($user->role === 'company') {
                $user->company()->create([
                    'company_name' => $validated['company_name'],
                ]);
            } elseif ($user->role === 'job_seeker') {
                $user->jobSeekerProfile()->create([]);
            }

            return $user;
        });

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user->only(['id', 'name', 'email', 'role', 'created_at']),
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', Rule::in(self::ROLES)],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $role = (string) ($validated['role'] ?? '');
        $keyword = '%'.addcslashes($search, '%_\\').'%';

        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->with('company:id,user_id,company_name')
            ->withCount('applications')
            ->when($search !== '', function ($query) use ($keyword): void {
                $query->where(function ($query) use ($keyword): void {
                    $query->where('name', 'like', $keyword)
                        ->orWhere('email', 'like', $keyword);
                });
            })
            ->when($role !== '', fn ($query) => $query->where('role', $role))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return response()->json(['data' => $users]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::query()
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->with('company:id,user_id,company_name')
            ->withCount('applications')
            ->find($id);

        if ($user === null) {
            return response()->json([
                'message' => 'User not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'User details retrieved successfully.',
            'data' => $user,
        ]);
    }
}
