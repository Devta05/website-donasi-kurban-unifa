<?php

namespace Database\Seeders;

use App\Models\JenisDonasi;
use Illuminate\Database\Seeder;

class JenisDonasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Pembangunan Masjid', 'deskripsi' => 'Donasi untuk renovasi dan pembangunan fasilitas masjid.'],
            ['nama' => 'Operasional Masjid', 'deskripsi' => 'Donasi untuk kebutuhan operasional harian masjid.'],
            ['nama' => 'Kegiatan Keagamaan', 'deskripsi' => 'Donasi untuk mendukung kajian dan kegiatan keagamaan.'],
            ['nama' => 'Infaq Jumat', 'deskripsi' => 'Infaq rutin setiap pelaksanaan shalat Jumat.'],
        ];

        foreach ($data as $item) {
            JenisDonasi::updateOrCreate(['nama' => $item['nama']], [...$item, 'is_active' => true]);
        }
    }
}
