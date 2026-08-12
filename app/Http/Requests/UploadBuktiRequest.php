<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadBuktiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'bukti_pembayaran' => [
            'required',
            'file',
            'mimes:jpg,jpeg,png,pdf',
            'max:2048',
        ],
    ];
}

public function messages(): array
{
    return [
        'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
        'bukti_pembayaran.mimes' => 'Format file harus JPG, JPEG, PNG, atau PDF.',
        'bukti_pembayaran.max' => 'Ukuran maksimal 2 MB.',
    ];
}
}
