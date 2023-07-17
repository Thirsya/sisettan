<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJabatanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('jabatan')->id;
        return [
            'jabatan' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:jabatans,jabatan,' . $id
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
