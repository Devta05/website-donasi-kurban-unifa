<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        $judul = 'Pembukaan Pendaftaran Kurban Tahun Ini';

        Berita::updateOrCreate(
            ['judul' => $judul],
            [
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'konten' => 'Masjid Kampus Universitas Fajar membuka pendaftaran kurban untuk tahun ini. Pendaftaran dapat dilakukan melalui website resmi masjid dengan memilih paket sapi atau kambing sesuai kemampuan. Panitia menghimbau para jamaah untuk mendaftar lebih awal karena slot terbatas.',
                'user_id' => $admin?->id,
            ]
        );
    }
}
