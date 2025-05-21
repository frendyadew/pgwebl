<?php

namespace App\Http\Controllers;
use App\Models\PolylinesModel;
use App\Models\PointsModel;
use App\Models\PolygonsModel;
use Illuminate\Http\Request;

class TableController extends Controller
{

    public function __construct()
    {
        $this->polylines = new PolylinesModel();
        $this->points = new PointsModel();
        $this->polygons = new PolygonsModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Table',
            'points' => $this->points->all(),
            'polylines' => $this->polylines->all(),
            'polygons' => $this->polygons->all(),
        ];

        return view('table', $data);
    }
}
