<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shuttle;

class ShuttleApiController extends Controller
{
    //
/**
 * menampilkan seluruh data (get ALL)
 */

public function index()
{
    $data = Shuttle::all();

    return response()->json([
        'message' => 'Berhasil mengambil semua data',
        'data' => $data
    ], 200);
}

/**
     * Menampilkan data spesifik berdasarkan ID (Get By ID)
     */
    public function show($id)
    {
        $data = Shuttle::find($id);

        // Validasi jika data tidak ditemukan (Status 404)
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