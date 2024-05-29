<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use SoftDeletes;
    protected $table = 'opds';
    protected $fillable = ['no_opd','id_kecamatan'];
    protected $dates = ['deleted_at'];
}
