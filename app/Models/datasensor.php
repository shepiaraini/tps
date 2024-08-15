<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Datasensor extends Model
{
    use HasFactory;

    protected $table = "datasensor";
    protected $primaryKey = "id_data_sensor";
    protected $fillable = [
        'id_data_sensor', 'id_tinggi_air', 
        'id_tinggi_sampah', 'id_deteksi_sampah',
    ];

    public function allData(){
        return DB::table('datasensor')
            ->leftJoin('tinggiair', 'tinggiair.id_tinggi_air', '=', 'datasensor.id_tinggi_air')
            ->leftJoin('tempatsampah', 'tempatsampah.id_tinggi_sampah', '=', 'datasensor.id_tinggi_sampah')
            ->leftJoin('deteksisampah', 'deteksisampah.id_deteksi_sampah', '=', 'datasensor.id_deteksi_sampah')
            ->select('datasensor.*', 'tinggiair.nilai_tinggi_air', 'tempatsampah.nilai_tinggi_sampah', 'deteksisampah.nilai_deteksi')
            ->get();
    }

    public function tinggiair(){
        return $this->belongsTo(tinggiair::class, 'id_tinggi_air', 'id_tinggi_air');
    }

    public function tempatsampah(){
        return $this->belongsTo(tempatsampah::class, 'id_tinggi_sampah', 'id_tinggi_sampah');
    }

    public function deteksisampah(){
        return $this->belongsTo(deteksisampah::class, 'id_deteksi_sampah', 'id_deteksi_sampah');
    }
}

