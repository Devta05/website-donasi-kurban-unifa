<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanDonasiRequest;
use App\Models\LaporanDonasi;
use Illuminate\Support\Facades\Storage;

class LaporanDonasiController extends Controller
{
    public function index()
    {
        $laporan = LaporanDonasi::latest('tanggal')->paginate(10);

        return view('admin.laporan-donasi.index', compact('laporan'));
    }

    public function create()
    {
        return view('admin.laporan-donasi.create');
    }

    public function store(LaporanDonasiRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file_laporan')) {
            $data['file_laporan'] = $request->file('file_laporan')->store('laporan-donasi', 'public');
        }

        LaporanDonasi::create($data);

        return redirect()->route('admin.laporan-donasi.index')->with('success', 'Laporan donasi berhasil ditambahkan.');
    }

    public function edit(LaporanDonasi $laporanDonasi)
    {
        return view('admin.laporan-donasi.edit', compact('laporanDonasi'));
    }

    public function update(LaporanDonasiRequest $request, LaporanDonasi $laporanDonasi)
    {
        $data = $request->validated();

        if ($request->hasFile('file_laporan')) {
            if ($laporanDonasi->file_laporan) {
                Storage::disk('public')->delete($laporanDonasi->file_laporan);
            }
            $data['file_laporan'] = $request->file('file_laporan')->store('laporan-donasi', 'public');
        }

        $laporanDonasi->update($data);

        return redirect()->route('admin.laporan-donasi.index')->with('success', 'Laporan donasi berhasil diperbarui.');
    }

    public function destroy(LaporanDonasi $laporanDonasi)
    {
        if ($laporanDonasi->file_laporan) {
            Storage::disk('public')->delete($laporanDonasi->file_laporan);
        }

        $laporanDonasi->delete();

        return back()->with('success', 'Laporan donasi berhasil dihapus.');
    }
}