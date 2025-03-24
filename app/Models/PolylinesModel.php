<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolylinesModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'polylines';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['geom', 'name', 'description'];

    public function geojson_polylines()
    {
        $polylines = $this->select(DB::raw('id, st_asgeojson(geom) as geom, name, description, created_at, updated_at, st_length(geom, true) / 1000 as length_km'))
            ->get();


        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($polylines as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'length_km' => $p->length_km,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ],
            ];


            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }
}
