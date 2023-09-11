<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenawaranRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idfk_daftar' => 'required',
            'idfk_tkd' => 'required',
            'luas' => 'required',
            'harga_dasar' => 'required',
            'nilai_penawaran' => 'nullable',
            'keterangan' => 'nullable'
        ];
    }
}
