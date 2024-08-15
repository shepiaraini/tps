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
        Schema::create('datasensor', function (Blueprint $table) {
            $table->id('id_data_sensor');
            $table->unsignedBigInteger('id_tinggi_air');
            $table->unsignedBigInteger('id_tinggi_sampah');
            $table->unsignedBigInteger('id_deteksi_sampah');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_tinggi_air')->references('id_tinggi_air')->on('tinggiair')->onDelete('cascade');
            $table->foreign('id_tinggi_sampah')->references('id_tinggi_sampah')->on('tempatsampah')->onDelete('cascade');
            $table->foreign('id_deteksi_sampah')->references('id_deteksi_sampah')->on('deteksisampah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasensor');
    }
};

