<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $table = "donasi";

    protected $fillable = [
        "kode_transaksi", "jenis_donasi_id", "nama", "whatsapp", "email",
        "nominal", "pesan", "tanggal", "bukti_pembayaran", "status",
    ];

    protected function casts(): array
    {
        return [
            "tanggal" => "date",
            "nominal" => "decimal:2",
        ];
    }

    public function jenisDonasi()
    {
        return $this->belongsTo(JenisDonasi::class, "jenis_donasi_id");
    }

    public function laporanDonasi()
    {
        return $this->hasOne(LaporanDonasi::class);
    }
}
