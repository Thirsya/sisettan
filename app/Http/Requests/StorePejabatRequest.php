<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePejabatRequest extends FormRequest
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
            'nama_pejabat' => 'required|unique:pejabats,nama_pejabat',
            'id_jabatan' => 'required',
            'id_opd' => 'required',
            'nip_pejabat' => 'required',
            'no_sk' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jabatan_id.required' => 'Nama Jabatan Wajib Diisi',
            'nama_pejabat.required' => 'Nama Pejabat Wajib Diisi',
            'nama_pejabat.unique' => 'Nama Pejabat Sudah Ada',
            'nip_pejabat.required' => 'NIP Pejabat Wajib Diisi',
            'no_sk.required' => 'No SK Wajib Diisi',
        ];
    }
}
