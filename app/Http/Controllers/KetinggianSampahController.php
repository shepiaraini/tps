<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tempatsampah;

class KetinggianSampahController extends Controller
{
    public function TampilKetinggianSampah()
    {
        $tsampah = tempatsampah::orderBy('created_at', 'desc')->get();
        $dtsensor = compact('tsampah');
        
        return view('Halaman.ketinggianSampah', $dtsensor);
    }

    public function CetakKetinggianSampah(){

        return view('Halaman.cetak-ketingian-sampah');
    }

    public function CetakSampah($tanggal_awal, $tanggal_akhir){
        // Convert input dates to start and end of day
        $tanggal_awal = $tanggal_awal . ' 00:00:00';
        $tanggal_akhir = $tanggal_akhir . ' 23:59:59';
    
        // Retrieve data within the date range
        $cetak = tempatsampah::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
        $jumlah = tempatsampah::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();
    
        return view('Halaman.tampilan-cetak-ketinggianSampah', compact('cetak', 'jumlah'));
    }
    

}
