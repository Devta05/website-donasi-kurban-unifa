<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JenisDonasiRequest;
use App\Models\JenisDonasi;

class JenisDonasiController extends Controller
{
    public function index()
    {
        $jenisDonasi = JenisDonasi::latest()->paginate(10);

        return view('admin.jenis-donasi.index', compact('jenisDonasi'));
    }

    public function store(JenisDonasiRequest $request)
    {
        JenisDonasi::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Jenis donasi berhasil ditambahkan.');
    }

    public function update(JenisDonasiRequest $request, JenisDonasi $jenisDonasi)
    {
        $jenisDonasi->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Jenis donasi berhasil diperbarui.');
    }

    public function destroy(JenisDonasi $jenisDonasi)
    {
        $jenisDonasi->delete();

        return back()->with('success', 'Jenis donasi berhasil dihapus.');
    }
}
