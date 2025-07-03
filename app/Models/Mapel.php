<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mapel',
        'kelas',
        'tahun_ajar',
    ];

    public function pengampus()
    {
        return $this->hasMany(GuruPengampu::class);
    }
}
