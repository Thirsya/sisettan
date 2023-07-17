<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaerahLelang extends Model
{
    use HasFactory;
    protected $table = 'daerah_lelangs';
    protected $fillable = ['id_kecamatan', 'id_kelurahan', 'tanggal_lelang'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}
