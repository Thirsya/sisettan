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
            'pejabat' => 'required|unique:pejabats,pejabat|regex:/^[a-zA-Z]+$/u',
            'id_jabatan' => 'required',
            'nip_pejabat' => 'required|regex:/^[0-9]+$/u',
            'no_sk' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jabatan_id.required' => 'Nama Jabatan Wajib Diisi',
            'pejabat.required' => 'Pejabat Wajib Diisi',
            'pejabat.unique' => 'Pejabat Sudah Ada',
            'pejabat.regex' => 'Pejabat tidak boleh karakter @!_? dan angka',
            'nip_pejabat.required' => 'NIP Pejabat Wajib Diisi',
            'nip_pejabat.regex' => 'NIP Pejabat tidak boleh karakter @!_? dan angka',
            'no_sk.required' => 'No SK Wajib Diisi',
            'no_sk.regex' => 'No SK tidak boleh karakter @!_? dan angka',
        ];
    }
}
