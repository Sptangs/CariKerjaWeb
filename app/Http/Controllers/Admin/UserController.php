<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Roles available for the admin role filter.
     *
     * @var array<string, string>
     */
    private const ROLES = [
        'job_seeker' => 'Pelamar',
        'company' => 'Perusahaan',
        'admin' => 'Admin',
    ];

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', Rule::in(array_keys(self::ROLES))],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $role = (string) ($validated['role'] ?? '');

        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->with('company:id,user_id,company_name')
            ->withCount('applications')
            ->when($search !== '', function ($query) use ($search) {
                $keyword = '%'.addcslashes($search, '%_\\').'%';

                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword)
                        ->orWhere('email', 'like', $keyword);
                });
            })
            ->when($role !== '', fn ($query) => $query->where('role', $role))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
            'roles' => self::ROLES,
        ]);
    }
}
