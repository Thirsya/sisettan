<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTkdRequest extends FormRequest
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
        $id = $this->route('tkd')->id;
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
            'id_kelurahan.required' => 'Kelurahan wajib diisi',
            'bidang.required' => 'Bidang wajib diisi',
            'letak.required' => 'Letak wajib diisi',
            'bukti.required' => 'Bukti wajib diisi',
            'luas.required' => 'Luas wajib diisi',
            'harga_dasar.required' => 'Harga Dasar wajib diisi',
            'longitude.required' => 'Longitude wajib diisi',
            'latitude.required' => 'Latitude wajib diisi',
            'foto.required' => 'Foto Wajib Diisi',
            'foto.image' => 'Foto Wajib Sesuai Format',
            'foto.mimes' => 'Foto Tidak Sesuai Format',
            'foto.max' => 'Foto Melebihi Maksimal Ukuran',
        ];
    }
}
