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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('deteksisampah');  // Menambahkan kolom untuk hasil deteksi sampah
            $table->string('tinggiair');      // Menambahkan kolom untuk tinggi air
            $table->string('tempatsampah');   // Menambahkan kolom untuk tempat sampah
            $table->string('output_kondisi'); // Menambahkan kolom untuk output kondisi
            $table->string('tindakan');       // Menambahkan kolom untuk tindakan
            $table->timestamps();            // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
