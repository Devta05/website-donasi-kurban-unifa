<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaketKurbanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "jenis_hewan" => ["required", "in:sapi,kambing"],
            "nama_paket" => ["required", "string", "max:255"],
            "harga" => ["required", "numeric", "min:0"],
            "deskripsi" => ["nullable", "string"],
            "is_active" => ["nullable", "boolean"],
        ];
    }
}
