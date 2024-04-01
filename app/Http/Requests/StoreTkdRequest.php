<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTkdRequest extends FormRequest
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
            'id_kelurahan' => 'required',
            'bidang' => 'required',
            'letak' => 'required',
            'bukti' => 'required',
            'luas' => 'required',
            'harga_dasar' => 'required',
            'keterangan' => 'nullable',
            'nop' => 'nullable',
            'longitude' => 'required',
            'latitude' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10000',

        ];
    }

    public function messages()
    {
        return [
            'bidang.required' => 'Bidang Wajib Diisi',
            'id_kelurahan.required' => 'Kelurahan Wajib Diisi',
            'letak.required' => 'Letak Wajib Diisi',
            'bukti.required' => 'Bukti Wajib Diisi',
            'luas.required' => 'Luas Wajib Diisi',
            'harga_dasar.required' => 'Harga Dasar Wajib Diisi',
            'longitude.required' => 'Longitude Wajib Diisi',
            'latitude.required' => 'Latitude Dasar Wajib Diisi',
            'foto.required' => 'Foto Wajib Diisi',
            'foto.image' => 'Foto Wajib Sesuai Format',
            'foto.mimes' => 'Foto Tidak Sesuai Format',
            'foto.max' => 'Foto Melebihi Maksimal Ukuran',
        ];
    }
}
