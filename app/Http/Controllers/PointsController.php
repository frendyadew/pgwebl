<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointsModel;

class PointsController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points = new PointsModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Map',
        ];

        return view('map', $data);
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
            'name' => 'required|string|max:255|unique:points,name', // Tambahkan unique rule
            'description' => 'nullable|string',
            'geom_point' => 'required|string',
        ]);

        // Simpan data ke database
        $point = new PointsModel();
        $point->geom = $request->geom_point;
        $point->name = $request->name;
        $point->description = $request->description;
        $point->save();

        return response()->json(['success' => 'Marker berhasil disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
