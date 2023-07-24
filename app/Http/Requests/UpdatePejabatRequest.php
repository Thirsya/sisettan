<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePejabatRequest extends FormRequest
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
        $id = $this->route('pejabat')->id;
        return [
            'nama_pejabat' => 'required|unique:pejabats,nama_pejabat,' . $id,
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
            'pejabat.required' => 'Pejabat Wajib Diisi',
            'pejabat.unique' => 'Pejabat Sudah Ada',
            'nip_pejabat.required' => 'NIP Pejabat Wajib Diisi',
            'no_sk.required' => 'No SK Wajib Diisi',
        ];
    }
}
