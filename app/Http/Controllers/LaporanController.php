<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\deteksisampah;
use App\Models\tempatsampah;
use App\Models\tinggiair;
use App\Models\History;
use Carbon\Carbon;

class LaporanController extends Controller
{

    public function laporanTotalConveyor(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $deteksiData = deteksisampah::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $dailySummary = $deteksiData->map(function ($dayData, $date) {
            $onCount = $dayData->where('keterangan', 'TERDETEKSI SAMPAH')->count();
            $offCount = $dayData->where('keterangan', 'TIDAK TERDETEKSI SAMPAH')->count();
            return [
                'date' => $date,
                'onCount' => $onCount,
                'offCount' => $offCount
            ];
        });

        return view('Laporan.laporanTotalConveyor', compact('dailySummary', 'startDate', 'endDate'));
    }
    
    // public function cetakTotalConveyor(Request $request)
    // {
    //     $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
    //     $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

    //     $deteksiData = deteksisampah::whereBetween('created_at', [$startDate, $endDate])
    //         ->orderBy('created_at', 'asc')
    //         ->get()
    //         ->groupBy(function ($date) {
    //             return Carbon::parse($date->created_at)->format('Y-m-d');
    //         });

    //     $dailySummary = $deteksiData->map(function ($dayData, $date) {
    //         $onCount = $dayData->where('keterangan', 'TERDETEKSI SAMPAH')->count();
    //         $offCount = $dayData->where('keterangan', 'TIDAK TERDETEKSI SAMPAH')->count();
    //         return [
    //             'date' => $date,
    //             'onCount' => $onCount,
    //             'offCount' => $offCount
    //         ];
    //     });

    //     return view('Laporan.cetakTotalConveyor', compact('dailySummary', 'startDate', 'endDate'));
    // }

    
   

    public function cetakTotalSampah(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        
        $sampahData = tempatsampah::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $dailySummary = $sampahData->map(function ($dayData, $date) {
            $filteredData = $dayData->unique('nilai_tinggi_sampah');
            $totalVolume = $filteredData->sum('nilai_tinggi_sampah');
            return [
                'date' => $date,
                'totalVolume' => $totalVolume
            ];
        });

        return view('Laporan.cetakTotalSampah', compact('dailySummary', 'startDate', 'endDate'));
    }
    
    public function laporanSensorAirBerbahaya(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        
        $airData = tinggiair::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $dailySummary = $airData->map(function ($dayData, $date) {
            $berbahayaCount = 0;
            $previousKeterangan = null;

            foreach ($dayData as $data) {
                if ($data->keterangan == 'BERBAHAYA' && ($previousKeterangan !== 'BERBAHAYA' || $previousKeterangan === null)) {
                    $berbahayaCount++;
                }
                $previousKeterangan = $data->keterangan;
            }

            return [
                'date' => $date,
                'berbahayaCount' => $berbahayaCount
            ];
        });

        return view('Laporan.laporanSensorAirBerbahaya', compact('dailySummary', 'startDate', 'endDate'));
    }

    // public function laporanSensorAirBerbahaya(Request $request)
    // {
    //     $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
    //     $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        
    //     $airData = tinggiair::where('keterangan', 'BERBAHAYA')
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->orderBy('created_at', 'asc')
    //         ->get()
    //         ->groupBy(function($date) {
    //             return Carbon::parse($date->created_at)->format('Y-m-d');
    //         });

    //     $dailySummary = $airData->map(function ($dayData, $date, $airData) {
    //         return [
    //             'date' => $date,
    //             'airData' => $airData,
    //             'berbahayaCount' => $dayData->count()
    //         ];
    //     });

    //     return view('Laporan.laporanSensorAirBerbahaya', compact('dailySummary', 'startDate', 'endDate'));
    // }

    public function cetakSensorAirBerbahaya(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        
        $airData = tinggiair::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $dailySummary = $airData->map(function ($dayData, $date) {
            $berbahayaCount = 0;
            $previousKeterangan = null;

            foreach ($dayData as $data) {
                if ($data->keterangan == 'BEBAHAYA' && ($previousKeterangan !== 'BEBAHAYA' || $previousKeterangan === null)) {
                    $berbahayaCount++;
                }
                $previousKeterangan = $data->keterangan;
            }

            return [
                'date' => $date,
                'berbahayaCount' => $berbahayaCount
            ];
        });

        return view('Laporan.cetakSensorAirBerbahaya', compact('dailySummary', 'startDate', 'endDate'));
    }
    // public function lapdeteksi()
    // {
    //     // Ambil data deteksi sampah dari database, misalnya 30 data terakhir
    //     $deteks = deteksisampah::latest('created_at')->take(30)->get();
    //     return view('Laporan.lapdeteksi', compact('deteks')); // Sesuaikan nama view
    // }

    // public function cetaklapdeteksi($tanggal_awal, $tanggal_akhir)
    // {
    //     // Konversi tanggal input ke awal dan akhir hari
    //     $tanggal_awal = $tanggal_awal . ' 00:00:00';
    //     $tanggal_akhir = $tanggal_akhir . ' 23:59:59';

    //     // Ambil data deteksi sampah dalam rentang tanggal yang ditentukan
    //     $cetak = deteksisampah::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
    //     $jumlah = deteksisampah::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();

    //     return view('Laporan.cetakdeteksi', compact('cetak', 'jumlah')); // Sesuaikan nama view
    // }

    // public function laporantempatsampah()
    // {
    //     // Ambil 30 data tempat sampah terbaru
    //     $tpsampah = tempatsampah::latest('created_at')->take(30)->get();

    //     return view('Laporan.laptempatsampah', compact('tpsampah'));
    // }

    public function laporanHasilakhir()
    {
        $hasilakhir = History::orderBy('created_at', 'desc')->paginate(10);
        return view('Laporan.laporanHasilakhir', ['hasilakhir' => $hasilakhir]);
    }

    public function cetakHasilakhir(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();

        $hasilakhir = History::whereBetween('created_at', [$start_date, $end_date])
            ->orderBy('created_at')
            ->get();

        return view('Laporan.cetakHasilakhir', [
            'hasilakhir' => $hasilakhir,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }


    // public function cetaklaporantempatsampah($tanggal_awal = null, $tanggal_akhir = null)
    // {
    //     if ($tanggal_awal === null && $tanggal_akhir === null) {
    //         // Jika tidak ada tanggal yang diberikan, ambil semua data
    //         $cetak = tempatsampah::all();
    //         $jumlah = $cetak->count();
    //     } else {
    //         // ... (kode untuk filtering berdasarkan tanggal seperti sebelumnya) ...
    //     }

    //     return view('Laporan.cetaklaptempatsampah', compact('cetak', 'jumlah'));
    // }

    // public function laporanKetinggianAir()
    // {
    //     // Ambil data ketinggian air dari database, misalnya 30 data terakhir
    //     $ttair = tinggiair::latest('created_at')->take(30)->get();
    //     return view('Laporan.laptinggiair', compact('ttair')); // Sesuaikan nama view
    // }

    // public function cetaklapTinggiAir($tanggal_awal = null, $tanggal_akhir = null)
    // {
    //     if ($tanggal_awal === null && $tanggal_akhir === null) {
    //         // Jika tidak ada tanggal yang diberikan, ambil semua data
    //         $cetak = tinggiair::all();
    //         $jumlah = $cetak->count();
    //     } else {
    //         // Konversi tanggal input ke awal dan akhir hari
    //         $tanggal_awal = $tanggal_awal . ' 00:00:00';
    //         $tanggal_akhir = $tanggal_akhir . ' 23:59:59';

    //         // Ambil data ketinggian air dalam rentang tanggal yang ditentukan
    //         $cetak = tinggiair::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
    //         $jumlah = tinggiair::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();
    //     }

    //     return view('Laporan.cetaktinggiair', compact('cetak', 'jumlah')); // Sesuaikan nama view
    // }
}
