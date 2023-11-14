<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportBaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'import-file' => 'required|mimes:pdf|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'import-file.mimes' => 'Hanya file PDF yang diperbolehkan.',
            'import-file.required' => 'File Wajib Diisi.',
            'import-file.max' => 'Ukuran file melebihi 10MB.',
        ];
    }
}
