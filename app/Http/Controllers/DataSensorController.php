<?php

namespace App\Http\Controllers;

use App\Models\deteksisampah;
use App\Models\tinggiair;
use App\Models\tempatsampah;
use Illuminate\Http\Request;

class DataSensorController extends Controller
{
    public function getSensorData()
    {
        $deteks = deteksisampah::latest()->take(5)->get(); // Ambil 5 data terakhir dari deteksi sampah
        $dtair = tinggiair::latest()->take(5)->get(); // Ambil 5 data terakhir dari tinggi air
        $tsampah = tempatsampah::latest()->take(5)->get(); // Ambil 5 data terakhir dari tempat sampah

        $dtsensor = compact('deteks', 'dtair', 'tsampah');

        return view('Halaman.data-sensor', $dtsensor);
    }
}


