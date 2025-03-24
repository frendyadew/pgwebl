<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolygonsModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'polygons';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['geom', 'name', 'description'];

    public function geojson_polygons()
    {
        $polygons = $this->select(DB::raw('id, st_asgeojson(geom) as geom, name, description, created_at, updated_at, st_area(geom, true) / 1000000 as area_km2'))
            ->get();


        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'area_km2' => $p->area_km2,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ],
            ];


            array_push($geojson['features'], $feature);

        }

        return $geojson;
    }
}
