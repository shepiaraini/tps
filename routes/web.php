<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DataSensorController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\TempatSampahController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\StatusAirController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeteksiObjekController;
use App\Http\Controllers\KetinggianAirController;
use App\Http\Controllers\KetinggianSampahController;
use App\Http\Controllers\InputSampahController;
use App\Http\Controllers\DataInformasiController;
use App\Http\Controllers\welcomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanCOnveyor;
use App\Http\Controllers\HasilTempatSampahController;



Route::get('/', [welcomeController::class, 'tampilstatusair'])->name('status-air');
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
Route::get('/api/sensor-data', [WelcomeController::class, 'getSensorData']);
Route::get('/test-notification', function () {
    $telegramService = app(App\Services\TelegramService::class);
    $telegramService->sendMessage('5779632555', 'Ini adalah pesan notifikasi dari Laravel');
    return 'Pesan telah dikirim';
});

Route::get('/test-notification-2', function () {
    $telegramService = app(App\Services\TelegramService::class);
    $telegramService->sendMessage('5779632555', 'Ini adalah pesan notifikasi kedua dari Laravel', 'second');
    return 'Pesan kedua telah dikirim';
});

Route::get('/test-notification-3', function () {
    $telegramService = app(App\Services\TelegramService::class);
    $telegramService->sendMessage('5779632555', 'Ini adalah pesan notifikasi ketiga dari Laravel', 'third');
    return 'Pesan ketiga telah dikirim';
});


Route::get('/login', [LoginController::class, 'Tampillogin'])->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/api/sensordata', [DashboardController::class, 'getSensorData']);

Route::get('/api/chart-data', [DashboardController::class, 'getChartData']);
// UNTUK PETUGAS
Route::group(['middleware' => ['Ceklevel:admin,petugas']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/tempat-sampah', [TempatSampahController::class, 'tampiltempatsampah'])->name('tempat-sampah');
    Route::put('/tempat-sampah/updateStatus/{id_tinggi_sampah}', [TempatSampahController::class, 'updateStatus'])->name('tempatsampah.updateStatus');
});

// UNTUK ADMIN
Route::group(['middleware' => ['Ceklevel:admin']], function () {

    Route::get('/deteksi-sampah', [DeteksiObjekController::class, 'TampilDataDeteksiSampah'])->name('deteksi-sampah');
    Route::get('/ketinggianAir', [KetinggianAirController::class, 'TampilKetinggianAir'])->name('ketinggianAir');
    Route::get('/ketinggianSampah', [KetinggianSampahController::class, 'TampilKetinggianSampah'])->name('ketinggianSampah');


    Route::get('/hasil', [HasilController::class, 'hasilPerhitungan'])->name('hasil.perhitungan');
    Route::get('/pengambilansampah', [HasilController::class, 'pengambilansampah']);
    Route::get('/delete/{id_sensor_data}', [Datasensorcontroller::class, 'delete'])->name('delete');
    Route::post('/delete/deleteAll', [Datasensorcontroller::class, 'deleteAll'])->name('data-sensor.deleteAll');


    Route::get('/cetaketinggianAir', [KetinggianAirController::class, 'CetakKetinggianAir']);
    Route::get('/cetaketinggianAir/{tanggal_awal}/{tanggal_akhir}', [KetinggianAirController::class, 'Cetak']);
    Route::get('/api/ketinggian-air', [KetinggianAirController::class, 'getLatestData']);

    Route::get('/CetakKetinggianSampah', [KetinggianSampahController::class, 'CetakKetinggianSampah']);
    Route::get('/CetakKetinggianSampah/{tanggal_awal}/{tanggal_akhir}', [KetinggianSampahController::class, 'CetakSampah']);

    Route::get('/cetak-deteksi-sampah', [DeteksiObjekController::class, 'CetakTampilanDeteksiSampah']);
    Route::get('/cetak-deteksi-sampah/{tanggal_awal}/{tanggal_akhir}', [DeteksiObjekController::class, 'CetakDeteksiSampah']);
    Route::get('/poll-deteksi-sampah', [DeteksiObjekController::class, 'PollDataDeteksiSampah']);



    Route::get('/lapdeteksi', [LaporanController::class, 'lapdeteksi'])->name('lapdeteksi');
    Route::get('/cetakdeteksi/{tanggal_awal}/{tanggal_akhir}', [LaporanController::class, 'cetaklapdeteksi'])->name('cetaklapdeteksi');
    Route::get('/laptempatsampah', [LaporanController::class, 'laporantempatsampah'])->name('laporantempatsampah');
    Route::get('/cetaklaptempatsampah/{tanggal_awal?}/{tanggal_akhir?}', [LaporanController::class, 'cetaklaporantempatsampah'])->name('cetaklaporantempatsampah');
    Route::get('/laptinggiair', [LaporanController::class, 'laporanKetinggianAir'])->name('laporanKetinggianAir');
  
    Route::get('/cetaktinggiair/{tanggal_awal?}/{tanggal_akhir?}', [LaporanController::class, 'cetaklapTinggiAir'])->name('cetaklapTinggiAir');

    Route::get('/laporanHasilakhir', [LaporanController::class, 'laporanHasilakhir'])->name('laporanHasilakhir');
Route::get('/cetakHasilakhir', [LaporanController::class, 'cetakHasilakhir'])->name('cetakHasilakhir');

    Route::get('/laporanTotalConveyor', [LaporanController::class, 'laporanTotalConveyor'])->name('laporanTotalConveyor');
    Route::get('/cetakTotalConveyor', [LaporanController::class, 'cetakTotalConveyor'])->name('cetakTotalConveyor');

    Route::get('/laporanTotalSampah', [HasilTempatSampahController::class, 'laporanTotalSampah'])->name('laporanTotalSampah');
    Route::get('/cetakTotalSampah', [HasilTempatSampahController::class, 'cetakTotalSampah'])->name('cetakTotalSampah');

    Route::get('/laporanSensorAirBerbahaya', [LaporanController::class, 'laporanSensorAirBerbahaya'])->name('laporanSensorAirBerbahaya');
    Route::get('/cetakSensorAirBerbahaya', [LaporanController::class, 'cetakSensorAirBerbahaya'])->name('cetakSensorAirBerbahaya');
    

    Route::get('/lap-conveyor', [LaporanCOnveyor::class, 'laporanConveyor'])->name('laporan.conveyor');
    Route::get('/cetak-conveyor', [LaporanCOnveyor::class, 'cetakLaporanConveyor']);
    Route::get('/cetak-conveyor/{tanggal_awal?}/{tanggal_akhir?}', [LaporanCOnveyor::class, 'cetak']);

    Route::get('/LaporanHasilAir', [StatusAirController::class, 'dataBerbahaya']);
    Route::get('/cetakHasilAirBerbahaya', [StatusAirController::class, 'cetakHasilAirBerbahaya'])->name('cetakHasilAirBerbahaya');
    

    //Input Data
    Route::get('/input', [InputDataController::class, 'tampilHalamanInput'])->name('input');
    Route::get('/tambahdata', [InputDataController::class, 'tampilHalamanTambahData'])->name('tambahdata');
    Route::get('/edit-input/{id_input_data}', [InputDataController::class, 'EditInput'])->name('edit-input');
    Route::post('/Simpan-Data', [InputDataController::class, 'SimpanData'])->name('SimpanData');
    Route::post('/update-input/{id_input_data}', [InputDataController::class, 'UpdateInput'])->name('update-input');
    Route::get('/delete-input/{id_input_data}', [InputDataController::class, 'DeleteInput'])->name('delete-input');

    //INPUT DATA SAMPAH
    Route::get('/input-sampah', [InputSampahController::class, 'TampilhalamanInputSampah'])->name('input-sampah');
    Route::get('/tambah-sampah', [InputSampahController::class, 'tampilHalamanTambahDataSampah'])->name('tambah-sampah');
    Route::get('/edit-sampah/{id_input_sampah}', [InputSampahController::class, 'EditInputSampah'])->name('edit-sampah');
    Route::post('/Simpan-sampah', [InputSampahController::class, 'SimpanDataSampah'])->name('SimpanDataSampah');
    Route::post('/update-sampah/{id_input_sampah}', [InputSampahController::class, 'UpdateInputSampah'])->name('update-sampah');
    Route::get('/delete-sampah/{id_input_sampah}', [InputSampahController::class, 'DeleteInputSampah'])->name('delete-sampah');


    //DATA INFORMASI
    Route::get('/informasi', [DataInformasiController::class, 'Tampilhalamaninformasi'])->name('informasi');
    Route::get('/informasi-sampah', [DataInformasiController::class, 'TampilInformasisampah'])->name('informasi-sampah');
});

// UNTUK ADMIN DAN MASYARAKAT


Route::get('/sensordata', [Datasensorcontroller::class, 'index'])->name('sensordata');
Route::get('/status-air', [StatusAirController::class, 'tampilstatusair'])->name('status-air');
