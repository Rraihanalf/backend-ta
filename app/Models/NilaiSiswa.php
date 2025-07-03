<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapel_id',
        'siswa_id',
        'nilai',
        'semester',
        'tahun_ajar',
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
