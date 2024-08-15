<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tempatsampah;
use Carbon\Carbon;

class HasilTempatSampahController extends Controller
{
    public function laporanTotalSampah(Request $request)
    {
        // Ambil tanggal mulai dan akhir dari permintaan, atau gunakan tanggal sekarang jika tidak ada
        $endDate = $request->input('end_date', Carbon::now()->endOfDay());
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());

        // Ambil semua data sampah dalam rentang waktu yang ditentukan
        $sampahData = tempatsampah::select('created_at', 'nilai_tinggi_sampah')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mengelompokkan data berdasarkan tanggal dan menghitung volume sampah per hari
        $dailySummary = $sampahData->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($dayData) {
            $totalVolume = 0;
            $previousValue = null;

            foreach ($dayData as $data) {
                if ($previousValue !== $data->nilai_tinggi_sampah) {
                    $totalVolume += $data->nilai_tinggi_sampah * 17 * 12;
                    $previousValue = $data->nilai_tinggi_sampah;
                }
            }
            return $totalVolume;
        });

        return view('Laporan.laporanTotalSampah', [
            'dailySummary' => $dailySummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function cetakTotalSampah(Request $request)
    {
        // Ambil tanggal mulai dan akhir dari permintaan
        $endDate = $request->input('end_date', Carbon::now()->endOfDay());
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());

        // Ambil semua data sampah dalam rentang waktu yang ditentukan
        $sampahData = tempatsampah::select('created_at', 'nilai_tinggi_sampah')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mengelompokkan data berdasarkan tanggal dan menghitung volume sampah per hari
        $dailySummary = $sampahData->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($dayData) {
            $totalVolume = 0;
            $previousValue = null;

            foreach ($dayData as $data) {
                if ($previousValue !== $data->nilai_tinggi_sampah) {
                    $totalVolume += $data->nilai_tinggi_sampah * 17 * 12;
                    $previousValue = $data->nilai_tinggi_sampah;
                }
            }
            return $totalVolume;
        });

        return view('Laporan.cetakTotalSampah', [
            'dailySummary' => $dailySummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    private function formatTanggalIndonesia($date)
    {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $tanggal = Carbon::parse($date)->format('d');
        $bulanIndex = Carbon::parse($date)->format('n') - 1;
        $tahun = Carbon::parse($date)->format('Y');
        $hariIndex = Carbon::parse($date)->format('w');

        return $hari[$hariIndex] . ', ' . $tanggal . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
    }
}
