<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tinggiair extends Model
{
    use HasFactory;

    protected $table = "tinggiair";
    protected $primaryKey = "id_tinggi_air";
    protected $fillable = [
        'id_tinggi_air', 'nilai_tinggi_air', 'keterangan', 'created_at',
    ];

    public function datasensor(){
        return $this->hasMany(datasensor::class);
    }
}
