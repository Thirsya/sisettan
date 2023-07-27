<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;
    protected $table = 'daerahs';
    protected $fillable = ['id_kecamatan', 'id_kelurahan', 'tanggal_lelang', 'noba', 'periode', 'thn_sts'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun');
    }
}
