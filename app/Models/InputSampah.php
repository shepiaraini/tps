<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputSampah extends Model
{
    protected $table = "input_sampah";
    protected $primaryKey = "id_input_sampah";
    public $timestamps = false; // jika Anda tidak menggunakan timestamps otomatis

    protected $fillable = [
        'id_input_sampah', 'ketinggian_sampah', 'tanggal', 'created_at', // Tambahkan 'created_at' jika dibutuhkan
    ];
}
