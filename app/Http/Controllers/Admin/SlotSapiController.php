<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurban;
use App\Models\SlotSapi;

class SlotSapiController extends Controller
{

    public function reset(SlotSapi $slotSapi)
    {
        $kurbanTerkait = Kurban::where('slot_sapi_id', $slotSapi->id)
            ->where('status', '!=', 'ditolak')
            ->first();

        if ($kurbanTerkait) {
            $kurbanTerkait->update(['status' => 'ditolak']);

            $slotSapi->update(['status' => 'kosong']);

            return back()->with('success', "Slot #{$slotSapi->nomor_slot} berhasil direset. Data kurban atas nama \"{$kurbanTerkait->nama}\" ({$kurbanTerkait->kode_transaksi}) otomatis ditandai \"Ditolak\" agar data tetap sinkron.");
        }

        $slotSapi->update(['status' => 'kosong']);

        return back()->with('success', "Slot #{$slotSapi->nomor_slot} berhasil direset.");
    }
}