<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sts extends Model
{
    use HasFactory;
    protected $table = 'sts';
    protected $fillable = [
        'id_penawaran',
        'surat_tanda_setor',
        'surat_pernyataan',
        'surat_perjanjian',
        'berita_acara',
    ];
}
