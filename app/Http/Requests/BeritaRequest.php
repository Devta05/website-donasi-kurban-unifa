<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "judul" => ["required", "string", "max:255"],
            "konten" => ["required", "string"],
            "gambar" => ["nullable", "image", "mimes:jpg,jpeg,png", "max:2048"],
        ];

        return $rules;
    }
}
