<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index()
    {
        $data = User::all();
        
        return response()->json([
            'message' => 'Berhasil mengambil semua data',
            'data' => $data
        ], 200);
    }
    
    public function show(int $id)
    {
        $data = User::find($id);
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
}
