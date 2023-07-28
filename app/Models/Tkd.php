<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tkd extends Model
{
    use HasFactory;
    protected $table = 'tkds';
    protected $fillable = ['id_tkd', 'id_kelurahan', 'bidang', 'letak', 'bukti', 'harga_dasar', 'luas', 'keterangan', 'nop'];
}
