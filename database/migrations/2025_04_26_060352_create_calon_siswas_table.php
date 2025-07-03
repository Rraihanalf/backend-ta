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
        Schema::create('calon_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']); 
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_tk')->nullable();
            $table->text('alamat');
            $table->string('nama_ortu');
            $table->string('email_ortu');
            $table->string('no_handphone');
            $table->string('kartu_keluarga')->nullable();
            $table->string('akta_lahir')->nullable();
            $table->string('pas_foto')->nullable();
            $table->enum('Status', ['Accepted', 'Waiting', 'Rejected'])->default('Waiting');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswas');
    }
};
