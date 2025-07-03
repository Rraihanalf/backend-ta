<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPengampu extends Model
{
    use HasFactory;

    protected $table = 'guru_pengampus';

    protected $fillable = [
        'tahun_ajar',
        'guru_id',
        'mapel_id',
    ];

    // Relasi ke Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
