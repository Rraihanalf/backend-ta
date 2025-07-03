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
        Schema::create('transaksi_daftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->nullable()->constrained('calon_siswas')->onDelete('set null');
            $table->string('metode');
            $table->enum('status', ['pending', 'sukses', 'gagal'])->default('pending');
            $table->decimal('jumlah', 15, 2);
            $table->string('bukti')->nullable(); // misalnya path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_daftars');
    }
};
