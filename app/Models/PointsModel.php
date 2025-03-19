<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'points';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['geom', 'name', 'description'];
}
