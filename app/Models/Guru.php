<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nip',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'golongan_darah',
        'status_nikah',
        'no_rekening',
        'nama_bank',
        'transportasi',
        'no_handphone',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangKelas()
    {
        return $this->hasMany(RuangKelas::class);
    }

    public function pengampus()
    {
        return $this->hasMany(GuruPengampu::class);
    }
}
