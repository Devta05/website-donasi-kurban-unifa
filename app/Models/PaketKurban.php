<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketKurban extends Model
{
    use HasFactory;

    protected $table = "paket_kurban";

    protected $fillable = ["jenis_hewan", "nama_paket", "harga", "deskripsi", "is_active"];

    protected function casts(): array
    {
        return ["is_active" => "boolean"];
    }

    public function slotSapi()
    {
        return $this->hasMany(SlotSapi::class);
    }

    public function kurban()
    {
        return $this->hasMany(Kurban::class);
    }
}
