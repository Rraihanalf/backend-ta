<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangKelas extends Model
{
    use HasFactory;

    protected $table = 'ruang_kelas';

    protected $fillable = [
        'tahun_ajar',
        'nama_kelas',
        'guru_id',
    ];

    // Relasi ke wali kelas (guru)
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
