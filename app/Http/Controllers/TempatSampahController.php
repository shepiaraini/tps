<!-- <?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tempatsampah;
use App\Services\TelegramService;

class TempatSampahController extends Controller
{
//     protected $telegramService;
//     const FULL_THRESHOLD = 5; // Threshold in cm

//     public function __construct(TelegramService $telegramService)
//     {
//         $this->telegramService = $telegramService;
//     }

//     public function tampiltempatsampah()
// {
//     // Fetch the most recent record
//     $tsampah = tempatsampah::latest()->first();
    
//     // Define tempat sampah dimensions
//     $tinggiTempatSampah = 6; // cm
//     $panjangTempatSampah = 17; // cm
//     $lebarTempatSampah = 12; // cm
    
//     // Calculate volume if tsampah exists
//     if ($tsampah) {
//         $tinggiSampah = $tsampah->nilai_tinggi_sampah;
//         $volumeTempatSampah = $tinggiSampah * $panjangTempatSampah * $lebarTempatSampah;
//     } else {
//         $volumeTempatSampah = null;
//     }
    
//     $dtsensor = compact('tsampah', 'volumeTempatSampah');
    
//     // Check if tempat sampah is full and send notification
//     $this->checkAndNotify($tsampah);
    
//     return view('Halaman.tempat-sampah', $dtsensor);
// }


//     public function updateStatus(Request $request, $id_tinggi_sampah)
//     {
//         $tempatsampah = tempatsampah::findOrFail($id_tinggi_sampah);
//         $tempatsampah->nilai_tinggi_sampah = $request->input('nilai_tinggi_sampah');
//         $tempatsampah->save();
    
//         // Check if tempat sampah is full after update and send notification
//         $this->checkAndNotify($tempatsampah);
    
//         return redirect()->back()->with('success', 'Ketinggian sampah telah diperbarui.');
//     }

//     private function checkAndNotify($tempatsampah)
//     {
//         if ($tempatsampah->nilai_tinggi_sampah > self::FULL_THRESHOLD) {
//             $chatId = '5779632555'; // Replace with your actual chat ID
//             $message = "Peringatan: Tempat sampah sudah penuh! Ketinggian sampah saat ini adalah {$tempatsampah->nilai_tinggi_sampah} cm. Mohon segera dikosongkan.";
            
//             $this->telegramService->sendMessage($chatId, $message);
//         }
//     }
} 