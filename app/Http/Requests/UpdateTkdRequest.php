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
        ];
    }
}
