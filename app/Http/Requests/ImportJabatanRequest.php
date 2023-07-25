<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportJabatanRequest extends FormRequest
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
        return [
            'import-file' => 'required|mimes:xlsx, csv, xls|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'import-file.mimes' => 'Jenis File Excel Tidak Sesuai',
            'import-file.required' => 'File Excel Wajib Diisi',
            'import-file.max' => 'Ukuran File Excel Melebihi 10MB',
        ];
    }
}
