<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sensordata extends Model
{
    use HasFactory;

    protected $table = "sensordata";
    protected $primaryKey = "id_sensor_data";
    protected $fillable = [
        'id_sensor_data', 'nilai_tinggi_air', 
        'nilai_tinggi_sampah', 'nilai_deteksi',
    ];
}


