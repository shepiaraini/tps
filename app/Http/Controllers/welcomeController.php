<?php

namespace App\Http\Controllers;

use App\Models\tempatsampah;
use Illuminate\Http\Request;
use App\Models\tinggiair;
use App\Services\TelegramService;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }
    public function tampilstatusair()
    {
        $tair = tinggiair::latest()->first();
        $tempatsampah = tempatsampah::latest()->first(); // Get the latest status of tempatsampah
    
        $dtsensor = compact('tair', 'tempatsampah');
    
        $formattedDate = $this->formatTanggalIndonesia($tair->created_at ?? now());
        
        // Check water level and send notification if necessary
        $this->checkWaterLevelAndNotify($tair);
    
        return view('welcome', array_merge($dtsensor, ['formattedDate' => $formattedDate]));
    }
    
    public function getSensorData()
    {
        $tair = tinggiair::latest()->first();
        $tempatsampah = tempatsampah::latest()->first();
    
        if ($tempatsampah) {
            $tempatsampah->volume = $tempatsampah->nilai_tinggi_sampah * 17 * 12;
        }
    
        $data = [
            'tair' => $tair,
            'tempatsampah' => $tempatsampah,
            'formattedDate' => $this->formatTanggalIndonesia($tair->created_at ?? now())
        ];
    
        return response()->json($data);
    }
    
    
    
    private function formatTanggalIndonesia($date)
    {
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('l, d F Y H:i:s');
    }

    protected function checkWaterLevelAndNotify($tair)
    {
        if ($tair) {
            $chatId = env('TELEGRAM_CHAT_ID_KETINGGIAN_AIR');

            if ($tair->nilai_tinggi_air == 5) {
                $message = "PERHATIAN: Ketinggian air telah mencapai 3 cm. Kondisi aman, tetapi perlu diwaspadai.";
                $this->telegramService->sendMessage($chatId, $message, 'default');
                $this->telegramService->sendMessage($chatId, $message, 'second');
            } elseif ($tair->nilai_tinggi_air > 5) {
                $message = "PERINGATAN BAHAYA: Ketinggian air telah melebihi 3 cm! Ketinggian saat ini: " . $tair->nilai_tinggi_air . " cm. Segera ambil tindakan pengamanan!";
                $this->telegramService->sendMessage($chatId, $message, 'default');
                $this->telegramService->sendMessage($chatId, $message, 'second');
            }
        }
    }
}
