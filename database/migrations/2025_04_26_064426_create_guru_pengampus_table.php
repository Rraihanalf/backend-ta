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
        Schema::create('guru_pengampus', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajar');
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->onDelete('set null');
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_pengampus');
    }
};
