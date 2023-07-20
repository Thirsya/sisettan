<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;
    protected $table = 'pejabats';
    protected $fillable = [
        'nama_pejabat', 'id_jabatan', 'id_opd','nip_pejabat', 'no_sk'
    ];

    public function pejabat()
    {
        return $this->belongsTo(Pejabat::class);
    }
}
