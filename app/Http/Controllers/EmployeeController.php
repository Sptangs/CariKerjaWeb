<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('company')
            ->latest()
            ->paginate(10);

        return view('company.employees.index', compact('employees'));
    }

public function create()
{
    $companies = Company::orderBy('company_name')->get();
    
    // $defaultName = "Semua Karyawan";

    return view('company.employees.create', compact('companies'));
}

   public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'employee_name' => ['required', 'string', 'max:255'],
        'position' => ['required', 'string', 'max:255'],
        'department' => ['nullable', 'string', 'max:255'],
        'hire_date' => ['required', 'date'],
        'employment_status' => [
            'required',
            Rule::in(['active', 'inactive', 'resigned']),
        ],
    ]);

    $company = $request->user()->company;
    abort_if($company === null, 403, 'Akun ini belum terhubung ke data perusahaan.');

    $validated['company_id'] = $company->id;

    // Simpan ke database
    Employee::create($validated);

    return redirect()
        ->route('company.employees.index')
        ->with('success', 'Data karyawan berhasil ditambahkan.');
}

    public function edit(Employee $employee)
    {
        $companies = Company::orderBy('company_name')->get();

        return view('company.employees.edit', compact('employee', 'companies'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['required', 'date'],
            'employment_status' => [
                'required',
                Rule::in(['active', 'inactive', 'resigned']),
            ],
        ]);

        $employee->update($validated);

        return redirect()
            ->route('company.employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()
            ->route('company.employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
