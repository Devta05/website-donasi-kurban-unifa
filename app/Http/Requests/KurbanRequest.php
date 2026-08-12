<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KurbanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paket_kurban_id' => ['required', 'exists:paket_kurban,id'],
            'slot_sapi_id' => ['nullable', 'exists:slot_sapi,id'],
            'nama' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'nominal' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'paket_kurban_id.required' => 'Paket kurban wajib dipilih.',
            'paket_kurban_id.exists' => 'Paket kurban yang dipilih tidak valid.',
            'nama.required' => 'Nama wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'email.email' => 'Format email tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
        ];
    }
}