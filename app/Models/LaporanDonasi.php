<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDonasi extends Model
{
    use HasFactory;

    protected $table = "laporan_donasi";

    protected $fillable = ['donasi_id', 'tanggal', 'jenis_donasi', 'nominal', 'status_penyaluran', 'keterangan', 'file_laporan'];

    protected function casts(): array
    {
        return [
            "tanggal" => "date",
            "nominal" => "decimal:2",
        ];
    }

    public function donasi()
    {
        return $this->belongsTo(Donasi::class);
    }
}
