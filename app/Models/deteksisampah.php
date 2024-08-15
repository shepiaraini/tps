<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deteksisampah extends Model
{
    use HasFactory;

    protected $table = "deteksisampah";
    protected $primaryKey = "id_deteksi_sampah";
    protected $fillable = [
        'id_deteksi_sampah', 'nilai_deteksi', 'keterangan', 'created_at',
    ];

    public function datasensor(){
        return $this->hasMany(datasensor::class);
    }
}
