<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputData extends Model
{
    protected $table = "input_data";
    protected $primaryKey = "id_input_data";
    public $timestamps = false; // jika Anda tidak menggunakan timestamps otomatis

    protected $fillable = [
        'id_input_data', 'ketinggian_air', 'tanggal', 'created_at', // Tambahkan 'created_at' jika dibutuhkan
    ];
}
