<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'jenis_donasi' => ['required', 'string', 'max:255'],
            'nominal' => ['nullable', 'numeric', 'min:0'],
            'status_penyaluran' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'file_laporan' => [$this->isMethod('POST') ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'file_laporan.required' => 'File laporan PDF wajib diupload.',
            'file_laporan.mimes' => 'File laporan harus berformat PDF.',
            'file_laporan.max' => 'Ukuran file maksimal 5 MB.',
        ];
    }
}