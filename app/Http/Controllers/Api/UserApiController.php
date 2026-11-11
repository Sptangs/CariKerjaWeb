<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserApiController extends Controller
{
    public function index()
    {
        $data = User::all();

        return response()->json([
            'message' => 'Users retrieved successfully.',
            'data' => $data,
        ], 200);
    }

    public function show(int $id)
    {
        $data = User::find($id);
        if (! $data) {
            return response()->json([
                'message' => 'User not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'User details retrieved successfully.',
            'data' => $data,
        ], 200);
    }
}
