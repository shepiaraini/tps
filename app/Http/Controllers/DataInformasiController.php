<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tinggiair;
use App\Models\tempatsampah;

class DataInformasiController extends Controller
{
    public function Tampilhalamaninformasi()
    {
        $inair = tinggiair::latest()->first();
        $dtsensor = compact('inair');
        
        return view('Halaman.informasi', $dtsensor);
    }

    public function TampilInformasisampah()
    {
        // Fetch the most recent record
        $insampah = tempatsampah::latest()->first();
        $dtsensor = compact('insampah');
        
        return view('Halaman.informasi-sampah', $dtsensor);
    }
}
