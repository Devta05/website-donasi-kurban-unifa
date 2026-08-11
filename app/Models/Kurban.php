<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurban extends Model
{
    use HasFactory;

    protected $table = "kurban";

    protected $fillable = [
    "kode_transaksi", "paket_kurban_id", "nama_paket_snapshot", "slot_sapi_id", "nama", "whatsapp",
    "email", "alamat", "nominal", "tanggal", "bukti_pembayaran", "status",
    ];

    protected function casts(): array
    {
        return [
            "tanggal" => "date",
            "nominal" => "decimal:2",
        ];
    }

    public function paketKurban()
    {
        return $this->belongsTo(PaketKurban::class, "paket_kurban_id");
    }

    public function slotSapi()
    {
        return $this->belongsTo(SlotSapi::class, "slot_sapi_id");
    }
}
