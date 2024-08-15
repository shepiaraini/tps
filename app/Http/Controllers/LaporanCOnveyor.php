<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\deteksisampah;
use App\Models\tempatsampah;
use App\Models\tinggiair;

class LaporanCOnveyor extends Controller
{
    // ... (fungsi lainnya seperti lapdeteksi, laporantempatsampah, laporanKetinggianAir, dll.) ...

    public function laporanConveyor(Request $request)
    {
        $latestDetection = deteksisampah::latest()->first();
        $conveyorStatus = $this->getConveyorStatus($latestDetection);
        $conveyorHistory = collect($this->getConveyorHistory($request));  // Tidak perlu parameter tanggal di sini
    

        return view('Laporan.lap-conveyor', compact('latestDetection', 'conveyorStatus', 'conveyorHistory'));
    }

    public function cetakLaporanConveyor(Request $request, $tanggal_awal = null, $tanggal_akhir = null)
{
    $conveyorHistory = collect($this->getConveyorHistory($request, $tanggal_awal, $tanggal_akhir)); 

    return view('Laporan.cetak-conveyor', compact('conveyorHistory'));
}

public function Cetak(Request $request, $tanggal_awal = null, $tanggal_akhir = null)
{
    $conveyorHistory = collect($this->getConveyorHistory($request, $tanggal_awal, $tanggal_akhir));

    return view('Laporan.tampilan-cetak-conveyor', compact('conveyorHistory'));
}

    private function getConveyorStatus($latestDetection)
    {
        return ($latestDetection && $latestDetection->nilai_deteksi == 1) ? 'on' : 'off';
    }

    private function getConveyorHistory(Request $request, $tanggal_awal = null, $tanggal_akhir = null)
    {
        $query = deteksisampah::where('keterangan', 'like', '%conveyor%')
            ->orderBy('created_at', 'desc');

        if ($tanggal_awal && $tanggal_akhir) {
            $tanggal_awal = $tanggal_awal . ' 00:00:00';
            $tanggal_akhir = $tanggal_akhir . ' 23:59:59';
            $query->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir]);
        }

        $detections = $query->get();

        $history = [];
        $lastStatus = null;
        $onStartTime = null;

        foreach ($detections as $index => $detection) {
            $currentStatus = $this->getConveyorStatus($detection);

            if ($currentStatus !== $lastStatus) {
                if ($currentStatus == 'on') {
                    $onStartTime = $detection->created_at;
                } elseif ($lastStatus == 'on' && $onStartTime) {
                    $duration = $onStartTime->diffForHumans($detection->created_at, ['parts' => 2]);
                    $history[] = [
                        'status' => 'ON',
                        'start_time' => $onStartTime,
                        'end_time' => $detection->created_at,
                        'duration' => $duration,
                    ];
                    $onStartTime = null;
                }
                $lastStatus = $currentStatus;
            }
        }

        // Handle jika conveyor masih ON
        if ($lastStatus == 'on' && $onStartTime) {
            $duration = $onStartTime->diffForHumans(now(), ['parts' => 2]);
            $history[] = [
                'status' => 'ON',
                'start_time' => $onStartTime,
                'end_time' => null,
                'duration' => $duration . ' (masih berjalan)',
            ];
        }

        return $history;
    }

    // ... (fungsi getRealTimeWaterLevel dan getRealTimeTempatSampah tetap sama) ...
}
