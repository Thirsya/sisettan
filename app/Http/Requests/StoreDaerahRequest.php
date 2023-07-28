<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDaerahRequest extends FormRequest
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
        return [
            'tanggal_lelang' => 'required',
            'id_kelurahan' => 'required',
            'id_kecamatan' => 'required',
            'noba' => 'nullable',
            'periode' => 'nullable',
            'thn_sts' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'tanggal_lelang.required' => 'Tanggal Lelang Wajib Diisi',
            'id_kelurahan.required' => 'Kelurahan Wajib Diisi',
            'id_kecamatan.required' => 'Kecamatan Wajib Diisi',
        ];
    }
}
