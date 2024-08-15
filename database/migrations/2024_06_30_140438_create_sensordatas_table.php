<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensordata', function (Blueprint $table) {
            $table->id('id_sensor_data');
            $table->float('nilai_tinggi_air');
            $table->float('nilai_tinggi_sampah');
            $table->float('nilai_deteksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensordata');
    }
};
