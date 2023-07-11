<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKecamatanRequest extends FormRequest
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
            'kecamatan' => 'required|unique:kecamatans,kecamatan|regex:/^[a-zA-Z]+$/u',
        ];
    }

    public function messages()
    {
        return [
            'kecamatan.required' => 'Kecamatan Wajib Diisi',
            'kecamatan.unique' => 'Kecamatan Sudah Ada',
            'kecamatan.regex' => 'Kecamatan tidak boleh karakter @!_?',
        ];
    }
}
