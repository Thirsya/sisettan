<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    protected $table = 'daftars';
    protected $fillable = ['id_kelurahan', 'no_urut', 'nama', 'alamat', 'no_kk', 'no_wp', 'tgl_perjanjian'];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}
