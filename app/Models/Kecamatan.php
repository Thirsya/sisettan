<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;
    protected $table = 'kecamatans';
    protected $fillable = ['kecamatan'];
    protected $dates = ['deleted_at'];
}
