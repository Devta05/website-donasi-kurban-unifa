<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        "jenis_donasi_id" => ["required", "exists:jenis_donasi,id"],
        "nama" => ["required", "string", "max:255"],
        "whatsapp" => ["required", "string", "max:20", "regex:/^[0-9]+$/"],
        "email" => ["nullable", "email", "max:255"],
        "nominal" => ["required", "numeric", "min:1000"],
        "pesan" => ["nullable", "string", "max:1000"],

        "bukti_pembayaran" => [
            "required",
            "file",
            "mimes:jpg,jpeg,png,pdf",
            "max:2048",
        ],
    ];
}
    public function messages(): array
    {
        return [
            "jenis_donasi_id.required" => "Jenis donasi wajib dipilih.",
            "nama.required" => "Kolom nama wajib diisi.",
            "nominal.min" => "Nominal donasi minimal Rp 1.000.",
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',

            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
             "bukti_pembayaran.mimes" => "Format file harus JPG, JPEG, PNG, atau PDF.",
            'bukti_pembayaran.max' => 'Ukuran maksimal 2 MB.',
        ];
    }
}
