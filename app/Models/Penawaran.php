<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;
    protected $table = 'penawarans';
    protected $fillable = [
        'id_penawaran',
        // 'total_luas',
        'idfk_daftar',
        'id_daftar',
        'idfk_tkd',
        'id_tkd',
        'nilai_penawaran',
        'keterangan'
    ];

    public function daftar()
    {
        return $this->belongsTo(Daftar::class);
    }

    public function tkd()
    {
        return $this->belongsTo(Tkd::class);
    }
}
