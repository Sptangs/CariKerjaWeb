<?php

namespace App\Http\Controllers;

use App\Models\Shuttle;
use Illuminate\Http\Request;

class ShuttleController extends Controller
{
    /**
     * Menampilkan daftar shuttle dengan fitur filtering berdasarkan input 'search' dari form.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Logika Filtering berdasarkan input 'search' dari form
        $shuttles = Shuttle::when($request->search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })->get();
        return view('shuttles.index', compact('shuttles'));
    }

    /**
     * Memperlihatkan form untuk membuat shuttle baru.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
        return view('shuttles.create');
    }

    /**
     * Menyimpan shuttle baru ke dalam database setelah validasi.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Menerapkan aturan validasi sebelum data disimpan
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ]);
        Shuttle::create($request->all());
        return redirect()->route('shuttles.index');
    }

    /**
     * Menampilkan detail shuttle tertentu berdasarkan ID.
     * 
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        //
    }

    /**
     * menampilkan form untuk mengedit shuttle tertentu berdasarkan ID.
     * 
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        //
        $shuttle = Shuttle::findOrFail($id);
        return view('shuttles.edit', compact('shuttle'));
    }

    /**
     * Memperbarui shuttle tertentu berdasarkan ID setelah validasi.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ]);
        $shuttle = Shuttle::findOrFail($id);
        $shuttle->update($request->all());
        return redirect()->route('shuttles.index');
    }

    /**
     * Menghapus shuttle tertentu berdasarkan ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        //
        $shuttle = Shuttle::findOrFail($id);
        $shuttle->delete();
        return redirect()->route('shuttles.index');
    }
}
