<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\deteksisampah;

class DeteksiObjekController extends Controller
{
    public function TampilDataDeteksiSampah()
    {
        $deteks = deteksisampah::latest('created_at')->take(30)->get();
        $dtsensor = compact('deteks');
        
        return view('Halaman.deteksi-sampah', $dtsensor);
    }


    public function CetakTampilanDeteksiSampah(){

        return view('Halaman.cetak-deteksi-sampah');
    }

    public function CetakDeteksiSampah($tanggal_awal, $tanggal_akhir){
        // Convert input dates to start and end of day
        $tanggal_awal = $tanggal_awal . ' 00:00:00';
        $tanggal_akhir = $tanggal_akhir . ' 23:59:59';
    
        // Retrieve data within the date range
        $cetak = deteksisampah::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
        $jumlah = deteksisampah::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();
    
        return view('Halaman.tampilan-cetak-deteksi-sampah', compact('cetak', 'jumlah'));
    }
    
    public function PollDataDeteksiSampah()
    {
        $deteks = deteksisampah::latest('created_at')->take(30)->get();
        return response()->json($deteks);
    }

}
