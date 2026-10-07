<?php

namespace App\Http\Controllers;

use App\Models\Shuttle;
use Illuminate\Http\Request;

class ShuttleController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('shuttles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          Shuttle::create($request->all());
    return redirect()->route('shuttles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $shuttle = Shuttle::findOrFail($id);
    return view('shuttles.edit', compact('shuttle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    $shuttle = Shuttle::findOrFail($id);
    $shuttle->update($request->all());
    return redirect()->route('shuttles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    $shuttle = Shuttle::findOrFail($id);
    $shuttle->delete();
    return redirect()->route('shuttles.index');
    }
}