<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPejabatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

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
