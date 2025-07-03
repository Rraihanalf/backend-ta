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
        Schema::create('nilai_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->integer('nilai')->nullable(); // Bisa kosong dulu
            $table->string('semester', 10);       // Bisa 'Ganjil' / 'Genap'
            $table->string('tahun_ajar', 9);       // Format: 2024/2025
            $table->timestamps();

            $table->unique(['mapel_id', 'siswa_id', 'semester', 'tahun_ajar'], 'nilai_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswas');
    }
};
