<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shuttle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShuttleApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Shuttle::query()->latest()->get()]);
    }

    public function show(Shuttle $shuttle): JsonResponse
    {
        return response()->json(['data' => $shuttle]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_armada' => ['required', 'string', 'max:50'],
            'kapasitas' => ['required', 'numeric', 'min:10', 'max:60'],
            'rute_operasional' => ['required', 'string'],
        ]);

        $shuttle = Shuttle::create($validated);

        return response()->json([
            'message' => 'Shuttle created successfully.',
            'data' => $shuttle,
        ], 201);
    }

    public function update(Request $request, Shuttle $shuttle): JsonResponse
    {
        $validated = $request->validate([
            'nama_armada' => ['required', 'string', 'max:50'],
            'kapasitas' => ['required', 'numeric', 'min:10', 'max:60'],
            'rute_operasional' => ['required', 'string'],
        ]);

        $shuttle->update($validated);

        return response()->json([
            'message' => 'Shuttle updated successfully.',
            'data' => $shuttle->fresh(),
        ]);
    }
}
