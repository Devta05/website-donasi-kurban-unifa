<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaketKurbanRequest;
use App\Models\PaketKurban;
use App\Models\SlotSapi;

class PaketKurbanController extends Controller
{
    public function index()
{
    $paketKurban = PaketKurban::withCount(['kurban' => function ($q) {
        $q->where('status', '!=', 'ditolak');
    }])->with('slotSapi')->latest()->paginate(10);

    return view('admin.paket-kurban.index', compact('paketKurban'));
}

    public function store(PaketKurbanRequest $request)
    {
        $paket = PaketKurban::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($paket->jenis_hewan === 'sapi') {
            for ($i = 1; $i <= 7; $i++) {
                SlotSapi::create([
                    'paket_kurban_id' => $paket->id,
                    'nomor_slot' => $i,
                    'status' => 'kosong',
                ]);
            }
        }

        return back()->with('success', 'Paket kurban berhasil ditambahkan.');
    }

    public function update(PaketKurbanRequest $request, PaketKurban $paketKurban)
    {
        $paketKurban->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Paket kurban berhasil diperbarui.');
    }

    public function destroy(PaketKurban $paketKurban)
    {
        $paketKurban->delete();

        return back()->with('success', 'Paket kurban berhasil dihapus.');
    }
}
