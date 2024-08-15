<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tinggiair;

class KetinggianAirController extends Controller
{
    public function TampilKetinggianAir()
    {
        return view('Halaman.ketinggianAir');
    }

    public function getLatestData()
    {
        $tair = tinggiair::orderBy('created_at', 'desc')->get();
        return response()->json($tair);
    }

    public function CetakKetinggianAir()
    {
        return view('Halaman.cetaketinggianAir');
    }

    public function Cetak($tanggal_awal, $tanggal_akhir)
    {
        $tanggal_awal = $tanggal_awal . ' 00:00:00';
        $tanggal_akhir = $tanggal_akhir . ' 23:59:59';

        $cetak = tinggiair::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
        $jumlah = tinggiair::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();

        return view('Halaman.tampilan-cetak', compact('cetak', 'jumlah'));
    }
}
