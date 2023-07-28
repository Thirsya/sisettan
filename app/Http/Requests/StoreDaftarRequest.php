<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDaftarRequest extends FormRequest
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
            'no_urut' => 'required',
            'id_kelurahan' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_kk' => 'required',
            'no_wp' => 'nullable',
            'tgl_perjanjian' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'no_urut.required' => 'Nomor Urut Wajib Diisi',
            'id_kelurahan.required' => 'Kelurahan Wajib Diisi',
            'nama.required' => 'Nama Wajib Diisi',
            'alamat.required' => 'Alamat Wajib Diisi',
            'no_kk.required' => 'No.KK Wajib Diisi',
            'tgl_perjanjian.required' => 'Tanggal Wajib Diisi',
        ];
    }
}
