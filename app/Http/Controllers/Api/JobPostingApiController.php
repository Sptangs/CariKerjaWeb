<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingApiController extends Controller
{
    // get all
    public function index()
    {
        $data = JobPosting::with('company')->latest()->get();
        return response()->json([
            'message' => 'Berhasil mengambil semua data lowongan',
            'data' => $data
        ], 200);
    }

    // get by id
    public function show($id)
    {
        $data = JobPosting::with('company')->find($id);
        
        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'message' => 'Detail data ditemukan',
            'data' => $data
        ], 200);
    }

    // post (create)
    public function store(Request $request)
    {

        if ($request->bearerToken() !== 'TOKEN-RAHASIA-123') {
            return response()->json([
                'message' => 'Unauthorized: Token tidak valid!'
            ], 401);
        }

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|max:50',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|in:open,closed',
        ]);

        $job = JobPosting::create($validated);

        return response()->json([
            'message' => 'Lowongan berhasil ditambahkan via API',
            'data' => $job
        ], 201);
    }
}