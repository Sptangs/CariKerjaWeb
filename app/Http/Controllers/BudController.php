<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudController extends Controller
{
    public function index()
    {
        return view('bud.index');
    }

    public function hitung(Request $request)
    {
        $sediaan = $request->input('sediaan', 'sirup');
        $tgl_buka = $request->input('tgl_buka', date('Y-m-d'));

        $timestamp_buka = strtotime($tgl_buka);

        if ($sediaan == "sirup") {
            $tambah_hari = 14;
            $petunjuk_simpan = "Simpan pada suhu ruangan, terhindar dari sinar matahari langsung. Jangan dibekukan.";
        } elseif ($sediaan == "racikan_kapsul") {
            $tambah_hari = 30;
            $petunjuk_simpan = "Simpan dalam wadah tertutup rapat dan kering untuk menghindari kelembapan.";
        } elseif ($sediaan == "tetes_mata") {
            $tambah_hari = 28;
            $petunjuk_simpan = "Pastikan ujung penetes tidak tersentuh tangan. Buang setelah masa pakai habis.";
        } else {
            $tambah_hari = 7;
            $petunjuk_simpan = "Simpan di lemari pendingin (suhu 2-8 derajat Celcius).";
        }

        $tgl_kadaluarsa_bud = date('d-m-Y', strtotime("+$tambah_hari days", $timestamp_buka));

        return view('bud.hasil', compact('tgl_kadaluarsa_bud', 'petunjuk_simpan', 'sediaan'));
    }
}
