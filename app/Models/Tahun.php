<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahun extends Model
{
    use SoftDeletes;
    protected $table = 'tahuns';
    protected $fillable = ['tahun'];
    protected $dates = ['deleted_at'];
}
