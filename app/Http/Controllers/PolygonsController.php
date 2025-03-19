<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new PolygonsModel();
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
            'name' => 'required|string|max:255|unique:polygons,name',
            'description' => 'nullable|string',
            'geom_polygon' => 'required|string',
        ]);

        // Simpan data ke database
        $polygon = new PolygonsModel();
        $polygon->geom = $request->geom_polygon;
        $polygon->name = $request->name;
        $polygon->description = $request->description;
        $polygon->save();

        return response()->json(['success' => 'Polygon berhasil disimpan!']);
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
