<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Daftar extends Model
{
    use SoftDeletes;

    protected $table = 'daftars';
    protected $fillable = ['id_daftar', 'id_kelurahan', 'no_urut', 'nama', 'alamat', 'no_kk', 'no_wp', 'tgl_perjanjian'];
    protected $dates = ['deleted_at'];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}
