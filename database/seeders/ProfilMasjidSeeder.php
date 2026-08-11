<?php

namespace Database\Seeders;

use App\Models\ProfilMasjid;
use Illuminate\Database\Seeder;

class ProfilMasjidSeeder extends Seeder
{
    public function run(): void
    {
        ProfilMasjid::updateOrCreate(
            ['id' => 1],
            [
                'nama_masjid' => 'Masjid Kampus Universitas Fajar',
                'sejarah' => 'Masjid Kampus Universitas Fajar didirikan sebagai pusat kegiatan keagamaan dan sosial bagi civitas akademika Universitas Fajar. Sejak awal berdirinya, masjid ini menjadi tempat ibadah, kajian keislaman, dan pengembangan kegiatan sosial kemasyarakatan.',
                'visi' => 'Menjadi pusat pembinaan keislaman dan kegiatan sosial yang unggul di lingkungan kampus.',
                'misi' => "Menyelenggarakan kegiatan ibadah yang nyaman dan tertib.\nMengembangkan program dakwah dan kajian keislaman.\nMengelola donasi dan kurban secara transparan dan amanah.",
                'fasilitas' => "Ruang shalat utama ber-AC\nTempat wudhu pria dan wanita\nPerpustakaan mini\nArea parkir luas\nRuang kajian",
                'alamat' => 'Jl. Prof. Dr. H. M. Yamin, SH, Kota Makassar, Sulawesi Selatan',
                'email' => 'masjid@unifa.ac.id',
                'whatsapp' => '628123456789',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps?q=Universitas+Fajar+Makassar&output=embed" width="100%" height="350" style="border:0;" allowfullscreen loading="lazy"></iframe>',
            ]
        );
    }
}
