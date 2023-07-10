<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelurahanRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->route('kelurahan')->id;
        return [
            'kelurahan' => 'required|regex:/^[a-zA-Z]+$/u|unique:kelurahans,kelurahan,' . $id,
            'id_kecamatan' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id_kecamatan.required' => 'Kecamatan Wajib Diisi',
            'kelurahan.required' => 'Kelurahan Wajib Diisi',
            'kelurahan.unique' => 'Kelurahan Sudah Ada',
            'kelurahan.regex' => 'Kelurahan tidak boleh karakter @!_?',
        ];
    }
}
