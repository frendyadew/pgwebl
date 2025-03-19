<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolylinesModel;

class PolylinesController extends Controller
{
    protected $polylines;

    public function __construct()
    {
        $this->polylines = new PolylinesModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dengan unique rule untuk name
        $request->validate([
            'name' => 'required|string|max:255|unique:polylines,name',
            'description' => 'nullable|string',
            'geom_polyline' => 'required|string',
        ]);

        // Simpan data ke database
        $polyline = new PolylinesModel();
        $polyline->geom = $request->geom_polyline;
        $polyline->name = $request->name;
        $polyline->description = $request->description;
        $polyline->save();

        return response()->json(['success' => 'Polyline berhasil disimpan!']);
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
