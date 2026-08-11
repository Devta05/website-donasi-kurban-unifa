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
}
