<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJabatanRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'jabatan' => 'required|unique:jabatans,jabatan|regex:/^[a-zA-Z0-9]+$/u',
        ];
    }

    public function messages()
    {
        return [
            'jabatan.required' => 'Jabatan Wajib Diisi',
            'jabatan.unique' => 'Jabatan Sudah Ada',
            'jabatan.regex' => 'Jabatan tidak boleh karakter @!_?',
        ];
    }
}
