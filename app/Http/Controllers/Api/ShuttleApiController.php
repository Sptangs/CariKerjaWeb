<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shuttle;
use Illuminate\Http\Request;

class ShuttleApiController extends Controller
{
    public function index()
    {
        $data = Shuttle::all();
        return response()->json(['message' => 'Berhasil', 'data' => $data], 200);
    }

    public function show($id)
    {
        $data = Shuttle::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan', 'data' => null], 404);
        }
        return response()->json(['message' => 'Detail data', 'data' => $data], 200);
    }

    public function store(Request $request)
    {
        if ($request->bearerToken() !== 'TOKEN-RAHASIA-123') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $validated = $request->validate([
            'nama_armada' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:10|max:60',
            'rute_operasional' => 'required|string',
            'status_aktif' => 'required|boolean',
        ]);

        $shuttle = Shuttle::create($validated);
        return response()->json(['message' => 'Berhasil ditambahkan', 'data' => $shuttle], 201);
    }
}