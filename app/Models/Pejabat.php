<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pejabat extends Model
{
    use SoftDeletes;
    protected $table = 'pejabats';
    protected $fillable = [
        'nama_pejabat', 'id_jabatan', 'id_opd','nip_pejabat', 'no_sk'
    ];
    protected $dates = ['deleted_at'];

    public function pejabat()
    {
        return $this->belongsTo(Pejabat::class);
    }
}
