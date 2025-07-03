<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'metode',
        'status',
        'jumlah',
        'bukti',
    ];

    public function user()
    {
        return $this->belongsTo(CalonSiswa::class);
    }
}
