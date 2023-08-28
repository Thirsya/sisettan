<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tkd extends Model
{
    use SoftDeletes;
    protected $table = 'tkds';
    protected $fillable = ['id_tkd', 'id_kelurahan', 'bidang', 'letak', 'bukti', 'harga_dasar', 'luas', 'keterangan', 'nop'];
    protected $dates = ['deleted_at'];
}
