<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'invoice',
        'id_jenis_pakaian',
        'id_user',
        'berat',
        'harga',
        'tgl_mulai',
        'tgl_selesai',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function jenis_pakaian()
    {
        return $this->belongsTo(JenisPakaian::class, 'id_jenis_pakaian', 'id');
    }
}
