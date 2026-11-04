<?php

namespace App\Http\Controllers;

use App\Models\Shuttle;
use Illuminate\Http\Request;

class ShuttleController extends Controller
{
    /**
     * Menampilkan formulir tambah shuttle.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('shuttles.create');
    }

      /**
     * Menampilkan formulir edit shuttle.
     *
     * @param  \App\Models\Shuttle  $shuttle
     * @return \Illuminate\View\View
     */
    public function edit(Shuttle $shuttle)
    {
        return view('shuttles.edit', compact('shuttle'));
    }

    /**
     * Menampilkan daftar data shuttle.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $shuttles = Shuttle::all();

        return view('shuttles.index', compact('shuttles'));
    }

    /**
     * Menyimpan data shuttle baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_armada' => 'required|string|max:50',
            'kapasitas' => 'required|numeric|min:10|max:60',
            'rute_operasional' => 'required|string'
        ]);

        Shuttle::create($request->all());
        return redirect()->route('shuttles.index');
    }

     /**
     * Memperbarui data shuttle di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shuttle  $shuttle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Shuttle $shuttle)
    {
        $validated = $request->validate([
            'nama_armada' => 'required|string|max:50',
            'kapasitas' => 'required|numeric|min:10|max:60',
            'rute_operasional' => 'required|string',
        ]);

        $shuttle->update($validated);

        return redirect()->route('shuttles.index');
    }
}
