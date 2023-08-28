<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelurahan extends Model
{
    use SoftDeletes;
    protected $table = 'kelurahans';
    protected $fillable = [
        'kelurahan', 'id_kecamatan'
    ];
    protected $dates = ['deleted_at'];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}
