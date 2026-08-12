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
        ];
    }

    public function messages(): array
    {
        return [
            "jenis_donasi_id.required" => "Jenis donasi wajib dipilih.",
            "nama.required" => "Kolom nama wajib diisi.",
            "whatsapp.required" => "Nomor WhatsApp wajib diisi.",
            "whatsapp.regex" => "Nomor WhatsApp hanya boleh berisi angka.",
            "nominal.required" => "Nominal wajib diisi.",
            "nominal.min" => "Nominal donasi minimal Rp 1.000.",
        ];
    }
}