<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotSapi extends Model
{
    use HasFactory;

    protected $table = "slot_sapi";

    protected $fillable = ["paket_kurban_id", "nomor_slot", "status"];

    public function paketKurban()
    {
        return $this->belongsTo(PaketKurban::class, "paket_kurban_id");
    }

    public function kurban()
    {
        return $this->hasOne(Kurban::class);
    }
}
