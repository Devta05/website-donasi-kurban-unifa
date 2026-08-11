<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDonasi extends Model
{
    use HasFactory;

    protected $table = "jenis_donasi";

    protected $fillable = ["nama", "deskripsi", "is_active"];

    protected function casts(): array
    {
        return ["is_active" => "boolean"];
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class);
    }
}
