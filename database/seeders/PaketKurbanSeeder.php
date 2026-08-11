<?php

namespace Database\Seeders;

use App\Models\PaketKurban;
use App\Models\SlotSapi;
use Illuminate\Database\Seeder;

class PaketKurbanSeeder extends Seeder
{
    public function run(): void
    {
        $sapi = PaketKurban::updateOrCreate(
            ['nama_paket' => 'Paket Sapi (Patungan 7 Orang)'],
            [
                'jenis_hewan' => 'sapi',
                'harga' => 2800000,
                'deskripsi' => 'Harga per slot untuk 1 ekor sapi kurban, maksimal 7 peserta per ekor.',
                'is_active' => true,
            ]
        );

        if ($sapi->slotSapi()->count() === 0) {
            for ($i = 1; $i <= 7; $i++) {
                SlotSapi::create([
                    'paket_kurban_id' => $sapi->id,
                    'nomor_slot' => $i,
                    'status' => 'kosong',
                ]);
            }
        }

        PaketKurban::updateOrCreate(
            ['nama_paket' => 'Paket Kambing Standar'],
            [
                'jenis_hewan' => 'kambing',
                'harga' => 2500000,
                'deskripsi' => 'Harga 1 ekor kambing kurban ukuran standar.',
                'is_active' => true,
            ]
        );
    }
}
