<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pesanan', 'id_user', 'name', 'email', 'tipe_kamar', 'kapasitas', 'harga'
    ];
}
