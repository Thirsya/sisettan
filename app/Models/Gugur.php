<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gugur extends Model
{
    use SoftDeletes;
    protected $table = 'gugurs';
    protected $fillable = ['id_penawaran', 'id_daftar', 'id_tkd', 'nilai_penawaran', 'keterangan'];
    protected $dates = ['deleted_at'];
}
