<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    // Tambahkan field yang boleh di-mass assign
    protected $fillable = [
        'nama',
        'instansi',
        'tujuan',
        'waktu_kedatangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
