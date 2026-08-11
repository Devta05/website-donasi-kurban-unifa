<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengeluaranRequest;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{

    public function store(PengeluaranRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('pengeluaran', 'public');
        }

        Pengeluaran::create($data);

        return back()->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    public function update(PengeluaranRequest $request, Pengeluaran $pengeluaran)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti')) {
            if ($pengeluaran->bukti) {
                Storage::disk('public')->delete($pengeluaran->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('pengeluaran', 'public');
        }

        $pengeluaran->update($data);

        return back()->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->bukti) {
            Storage::disk('public')->delete($pengeluaran->bukti);
        }

        $pengeluaran->delete();

        return back()->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}