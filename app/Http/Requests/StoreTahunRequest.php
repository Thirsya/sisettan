<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTahunRequest extends FormRequest
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
            'tahun' => 'required|unique:tahuns,tahun|regex:/^[0-9]+$/u',
        ];
    }

    public function messages()
    {
        return [
            'tahun.required' => 'Tahun Wajib Diisi',
            'tahun.unique' => 'Tahun Sudah Ada',
            'tahun.regex' => 'Tahun tidak boleh karakter @!_? dan huruf',
        ];
    }
}
