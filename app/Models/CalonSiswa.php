<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'asal_tk',
        'alamat',
        'nama_ortu',
        'no_handphone',
        'email_ortu',
        'kartu_keluarga',
        'akta_lahir',
        'pas_foto',
    ];

    // Relasi ke User (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
