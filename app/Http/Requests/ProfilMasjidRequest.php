<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilMasjidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'nama_masjid' => ['required', 'string', 'max:255'],
        'sejarah' => ['nullable', 'string'],
        'visi' => ['nullable', 'string'],
        'misi' => ['nullable', 'string'],
        'fasilitas' => ['nullable', 'string'],
        'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'qris' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'alamat' => ['nullable', 'string'],
        'email' => ['nullable', 'email'],
        'whatsapp' => ['nullable', 'string', 'max:20'],
        'google_maps_embed' => ['nullable', 'string'],
    ];
}
}
