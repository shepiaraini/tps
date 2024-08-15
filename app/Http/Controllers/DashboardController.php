<?php

namespace App\Http\Controllers;

use App\Models\tempatsampah;
use Illuminate\Http\Request;
use App\Models\tinggiair;
use App\Models\deteksisampah;
use App\Services\TelegramService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('Halaman.dashboard');
    }

    public function getSensorData()
    {
        $tair = tinggiair::latest()->take(10)->get();
        $tempatsampah = tempatsampah::latest()->take(10)->get();
        $deteksisampah = deteksisampah::latest()->take(10)->get();
    
        $data = [
            'tair' => $tair,
            'tempatsampah' => $tempatsampah,
            'deteksisampah' => $deteksisampah
        ];
    
        return response()->json($data);
    }

    protected function formatTanggalIndonesia($date)
    {
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('l, d F Y H:i:s');
    }
}
