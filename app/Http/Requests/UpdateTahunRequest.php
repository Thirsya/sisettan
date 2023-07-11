<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTahunRequest extends FormRequest
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
        $id = $this->route('tahun')->id;
        return [
            'tahun' => 'required|regex:/^[0-9]+$/u|unique:tahuns,tahun,' . $id
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
