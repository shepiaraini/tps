<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempatsampah extends Model
{
    use HasFactory;

    protected $table = "tempatsampah";
    protected $primaryKey = "id_tinggi_sampah";
    protected $fillable = [
        'id_tinggi_sampah', 'nilai_tinggi_sampah','created_at', 'keterangan',
    ];

    public function datasensor(){
        return $this->hasMany(datasensor::class);
    }
}
