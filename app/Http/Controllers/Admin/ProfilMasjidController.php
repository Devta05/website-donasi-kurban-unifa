<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilMasjidRequest;
use App\Models\ProfilMasjid;
use Illuminate\Support\Facades\Storage;

class ProfilMasjidController extends Controller
{
    public function edit()
    {
        $profil = ProfilMasjid::first();

        return view('admin.profil-masjid.edit', compact('profil'));
    }

    public function update(ProfilMasjidRequest $request)
    {
        $profil = ProfilMasjid::first();
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($profil && $profil->foto) {
                Storage::disk('public')->delete($profil->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil-masjid', 'public');
        }

        if ($request->hasFile('qris')) {
        if ($profil && $profil->qris) {
            Storage::disk('public')->delete($profil->qris);
        }
        $data['qris'] = $request->file('qris')->store('profil-masjid', 'public');
    }

        if ($profil) {
            $profil->update($data);
        } else {
            ProfilMasjid::create($data);
        }

        return back()->with('success', 'Profil masjid berhasil diperbarui.');
    }
}
