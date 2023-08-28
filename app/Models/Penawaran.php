<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penawaran extends Model
{
    use SoftDeletes;
    protected $table = 'penawarans';
    protected $fillable = [
        'id_penawaran',
        'total_luas',
        'idfk_daftar',
        'id_daftar',
        'idfk_tkd',
        'id_tkd',
        'nilai_penawaran',
        'keterangan',
    ];
    protected $dates = ['deleted_at'];

    public function daftar()
    {
        return $this->belongsTo(Daftar::class);
    }

    public function tkd()
    {
        return $this->belongsTo(Tkd::class);
    }
}
