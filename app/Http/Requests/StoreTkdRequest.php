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
            'keterangan',
            'nop',
        ];
    }
}
