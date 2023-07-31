<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenawaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'total_luas' => 'required|unique:pejabats,nama_pejabat',
            'id_penawaran' => 'required',
            'idfk_daftar' => 'required',
            'id_daftar' => 'required',
            'idfk_tkd' => 'required',
            'id_tkd' => 'required',
            'nilai_penawarab' => 'required',
            'keterangan' => 'nullable'
        ];
    }
}
