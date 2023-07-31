<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenawaranRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('penawaran')->id;
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
