<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreopdRequest extends FormRequest
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
            'no_opd' => 'required',
            'id_kecamatan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'no_opd.required' => 'Nomor OPD Wajib Diisi',
            'id_kecamatan.required' => 'Nama OPD Wajib Diisi',
        ];
    }
}
