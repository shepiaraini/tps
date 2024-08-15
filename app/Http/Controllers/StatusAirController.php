<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tinggiair;
use Carbon\Carbon;

class StatusAirController extends Controller
{
    public function tampilstatusair()
    {
        $tair = tinggiair::latest()->first();
        $dtsensor = compact('tair');

        return view('Halaman.status-air', $dtsensor);
    }

    public function dataBerbahaya()
    {
        $dataBerbahaya = tinggiair::whereIn('keterangan', ['WARNING', 'BEBAHAYA', 'BERBAHAYA'])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->unique(function ($item) {
                    return $item->created_at->format('Y-m-d H:i');
                });
            });

        return view('Laporan.LaporanHasilAir', ['dataBerbahaya' => $dataBerbahaya]);
    }

    public function cetakHasilAirBerbahaya(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();

        $dataBerbahaya = tinggiair::whereIn('keterangan', ['WARNING', 'BEBAHAYA', 'BERBAHAYA'])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->unique(function ($item) {
                    return $item->created_at->format('Y-m-d H:i');
                });
            });

        return view('Laporan.CetakHasilAirBerbahaya', ['dataBerbahaya' => $dataBerbahaya, 'start_date' => $start_date, 'end_date' => $end_date]);
    }

    public function getKeterangan($nilai)
    {
        if ($nilai < 2) {
            return 'Surut (S)';
        } elseif ($nilai >= 2 && $nilai <= 5) {
            return 'Normal (N)';
        } elseif ($nilai > 5) {
            return 'Berbahaya (B)';
        } else {
            return 'Nilai tidak valid';
        }
    }
}
