<?php

namespace App\Http\Controllers;

use App\Models\deteksisampah;
use App\Models\tinggiair;
use App\Models\tempatsampah;
use App\Models\History;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TelegramService;

use Illuminate\Pagination\LengthAwarePaginator;

class HasilController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function hasilPerhitungan(Request $request)
    {
        $latestDetection = deteksisampah::latest()->first();
        $conveyorStatus = $this->getConveyorStatus($latestDetection);
        $conveyorHistory = $this->getConveyorHistory($request);
        $realTimeWaterLevel = $this->getRealTimeWaterLevel();
        $realTimeTempatSampah = $this->getRealTimeTempatSampah();

        $kategori = [
            'tinggiAir' => $this->kategorikanTinggiair($realTimeWaterLevel),
            'sampah' => $this->kategorikanDeteksisampah($latestDetection ? $latestDetection->nilai_deteksi : null),
            'tempatSampah' => $this->kategorikanTempatsampah($this->calculateVolumeTempatSampah()),
        ];

        $output_kondisi = $this->tentukanKondisi($kategori);

        return view('halaman.hasil', compact('latestDetection', 'conveyorStatus', 'conveyorHistory', 'realTimeWaterLevel', 'realTimeTempatSampah', 'kategori', 'output_kondisi'));
    }

    private function getConveyorStatus($latestDetection)
    {
        return ($latestDetection && $latestDetection->nilai_deteksi == 1) ? 'on' : 'off';
    }

    private function getConveyorHistory(Request $request)
    {
        $detections = deteksisampah::orderBy('created_at', 'desc')->get();
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
                        'status' => 'on',
                        'start_time' => $onStartTime,
                        'end_time' => $detection->created_at,
                        'duration' => $duration
                    ];
                    $onStartTime = null;
                }
                $lastStatus = $currentStatus;
            }

            if ($index == 0 && $currentStatus == 'on' && $onStartTime) {
                $duration = $onStartTime->diffForHumans(now(), ['parts' => 2]);
                $history[] = [
                    'status' => 'on',
                    'start_time' => $onStartTime,
                    'end_time' => null,
                    'duration' => $duration . ' (masih berjalan)'
                ];
            }
        }

        $perPage = 10;
        $page = $request->input('page', 1);
        $offset = ($page * $perPage) - $perPage;

        $items = array_slice($history, $offset, $perPage, true);

        $paginator = new LengthAwarePaginator(
            $items,
            count($history),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $paginator;
    }

    private function getRealTimeWaterLevel()
    {
        $latestWaterLevel = tinggiair::latest()->first();
        return $latestWaterLevel ? $latestWaterLevel->nilai_tinggi_air : 'No data available';
    }

    private function getRealTimeTempatSampah()
    {
        $latestTempatSampah = tempatsampah::latest()->first();
        return $latestTempatSampah ? $latestTempatSampah->keterangan : 'No data available';
    }

    public function pengambilanSampah(Request $request)
    {
        $chatId = '5779632555'; // Define chatId here

        $latestsampah = deteksisampah::latest('created_at')->first();
        $latestair = tinggiair::latest('created_at')->first();
        $latesttempatsampah = tempatsampah::latest('created_at')->first();
        $volumeTempatSampah = $this->calculateVolumeTempatSampah();

        $latestValues = [
            'deteksisampah' => $latestsampah ? $latestsampah->nilai_deteksi : null,
            'tinggiair' => $latestair ? $latestair->nilai_tinggi_air : null,
            'tempatsampah' => $volumeTempatSampah,
            'created_at' => $latestsampah ? $latestsampah->created_at : null,
        ];

        $kategori = [
            'tinggiAir' => $this->kategorikanTinggiair($latestValues['tinggiair']),
            'sampah' => $this->kategorikanDeteksisampah($latestValues['deteksisampah']),
            'tempatSampah' => $this->kategorikanTempatsampah($volumeTempatSampah),
        ];

        $output_kondisi = $this->tentukanKondisi($kategori);
        $tindakan = $this->tentukanTindakan($output_kondisi);

        // Menyimpan hasil ke tabel datahasils
        $dataHasil = new History();
        $dataHasil->deteksisampah = $latestValues['deteksisampah'];
        $dataHasil->tinggiair = $latestValues['tinggiair'];
        $dataHasil->tempatsampah = $latestValues['tempatsampah'];
        $dataHasil->output_kondisi = $output_kondisi;
        $dataHasil->tindakan = $tindakan;
        $dataHasil->created_at = now();
        $dataHasil->updated_at = now();
        $dataHasil->save();

        if ($output_kondisi === 'Penuh (P)') {
            $message = "PERINGATAN: Tempat sampah penuh! Harap segera kosongkan.";
            $this->telegramService->sendMessage($chatId, $message);
        }

        // Mengambil data hasil keputusan terbaru
        $latestDataHasil = History::orderBy('created_at', 'desc')->paginate(5);

        return view('Halaman.pengambilansampah', compact('latestDataHasil', 'latestValues', 'latestsampah', 'latestair', 'latesttempatsampah', 'kategori', 'output_kondisi', 'tindakan'));
    }
    private function calculateVolumeTempatSampah()
    {
        $tsampah = tempatsampah::latest()->first();
        $tinggiTempatSampah = 6; // cm
        $panjangTempatSampah = 17; // cm
        $lebarTempatSampah = 12; // cm
        
        if ($tsampah) {
            $tinggiSampah = $tsampah->nilai_tinggi_sampah;
            $volumeTempatSampah = $tinggiSampah * $panjangTempatSampah * $lebarTempatSampah;
        } else {
            $volumeTempatSampah = null;
        }
        
        return $volumeTempatSampah;
    }

    public function kategorikanDeteksisampah($nilai)
    {
        if ($nilai == 0) {
            return 'Tidak Terdeteksi (TT)';
        } elseif ($nilai == 1) {
            return 'Terdeteksi (T)';
        } else {
            return 'Nilai tidak valid';
        }
    }

    public function kategorikanTinggiair($nilai)
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

    public function kategorikanTempatsampah($volume)
    {
        if ($volume === null) {
            return 'No data available';
        } elseif ($volume < 510) {
            return 'Rendah (R)';
        } elseif ($volume >= 510 && $volume <= 816 ) {
            return 'Sedang (S)';
        } else {
            return 'Tinggi (T)';
        }
    }

    private function tentukanKondisi($kategori)
    {
        $aturan = [
            ['Tinggi Air' => 'Surut (S)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Rendah (R)', 'Output' => 'Kosong (K)'],
            ['Tinggi Air' => 'Surut (S)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Sedang (S)', 'Output' => 'Waspada (W)'],
            ['Tinggi Air' => 'Surut (S)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Tinggi (T)', 'Output' => 'Penuh (P)'],
            ['Tinggi Air' => 'Normal (N)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Rendah (R)', 'Output' => 'Aman (A)'],
            ['Tinggi Air' => 'Normal (N)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Sedang (S)', 'Output' => 'Waspada (W)'],
            ['Tinggi Air' => 'Normal (N)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Tinggi (T)', 'Output' => 'Penuh (P)'],
            ['Tinggi Air' => 'Normal (N)', 'Sampah' => 'Terdeteksi (T)', 'Tempat Sampah' => 'Rendah (R)', 'Output' => 'Aman (A)'],
            ['Tinggi Air' => 'Normal (N)', 'Sampah' => 'Terdeteksi (T)', 'Tempat Sampah' => 'Sedang (S)', 'Output' => 'Waspada (W)'],
            ['Tinggi Air' => 'Normal (N)', 'Sampah' => 'Terdeteksi (T)', 'Tempat Sampah' => 'Tinggi (T)', 'Output' => 'Penuh (P)'],
            ['Tinggi Air' => 'Berbahaya (B)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Rendah (R)', 'Output' => 'Aman (A)'],
            ['Tinggi Air' => 'Berbahaya (B)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Sedang (S)', 'Output' => 'Waspada (W)'],
            ['Tinggi Air' => 'Berbahaya (B)', 'Sampah' => 'Tidak Terdeteksi (TT)', 'Tempat Sampah' => 'Tinggi (T)', 'Output' => 'Penuh (P)'],
            ['Tinggi Air' => 'Berbahaya (B)', 'Sampah' => 'Terdeteksi (T)', 'Tempat Sampah' => 'Rendah (R)', 'Output' => 'Aman (A)'],
            ['Tinggi Air' => 'Berbahaya (B)', 'Sampah' => 'Terdeteksi (T)', 'Tempat Sampah' => 'Sedang (S)', 'Output' => 'Waspada (W)'],
            ['Tinggi Air' => 'Berbahaya (B)', 'Sampah' => 'Terdeteksi (T)', 'Tempat Sampah' => 'Tinggi (T)', 'Output' => 'Penuh (P)'],
        ];
        
        foreach ($aturan as $rule) {
            if (
                $rule['Tinggi Air'] == $kategori['tinggiAir'] &&
                $rule['Sampah'] == $kategori['sampah'] &&
                $rule['Tempat Sampah'] == $kategori['tempatSampah']
            ) {
                return $rule['Output'];
            }
        }

        return 'Tidak Terdefinisi';
    }

    private function tentukanTindakan($output_kondisi)
    {
        $tindakan = [
            'Kosong (K)' => 'Tidak ada tindakan khusus diperlukan.',
            'Aman (A)' => 'Kondisi aman.',
            'Waspada (W)' => 'Pantau secara berkala, Pertimbangkan untuk memeriksa tempat sampah.',
            'Penuh (P)' => 'Ambil tindakan segera untuk pengosongan tempat sampah.',
        ];

        return $tindakan[$output_kondisi] ?? 'Tidak ada tindakan yang ditentukan.';
    } 

}
