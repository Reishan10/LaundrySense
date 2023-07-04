<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPakaian extends Model
{
    use HasFactory;

    protected $table = 'jenis_pakaian';
    protected $fillable = [
        'jenis_pakaian',
        'harga_perkilo',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_jenis_pakaian', 'id');
    }
}
