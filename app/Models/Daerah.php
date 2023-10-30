<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Daerah extends Model
{
    use SoftDeletes;
    protected $table = 'daerahs';
    protected $fillable = ['id_kecamatan', 'id_kelurahan', 'tanggal_lelang', 'noba', 'periode', 'thn_sts'];
    protected $dates = ['deleted_at'];

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
        return $this->belongsTo(Tahun::class, 'thn_sts');
    }
}
