@extends('layouts.admin')

@section('title', 'Kelola Profil Masjid')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('admin.profil-masjid.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Masjid</label>
            <input type="text" name="nama_masjid" value="{{ old('nama_masjid', $profil->nama_masjid ?? '') }}" class="form-control @error('nama_masjid') is-invalid @enderror" required>
            @error('nama_masjid') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        @if ($profil && $profil->foto)
            <img src="{{ asset('storage/' . $profil->foto) }}" class="mb-2 rounded" style="max-height:150px;">
        @endif
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Masjid</label>
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr class="my-4">
<h6 class="fw-bold mb-3"><i class="bi bi-qr-code"></i> QRIS Pembayaran</h6>
@if ($profil && $profil->qris)
    <div class="mb-2">
        <img src="{{ asset('storage/' . $profil->qris) }}" class="rounded border p-2" style="max-height:200px;">
    </div>
@endif
<div class="mb-4">
    <label class="form-label fw-semibold">Upload / Ganti QRIS</label>
    <input type="file" name="qris" class="form-control @error('qris') is-invalid @enderror" accept="image/*">
    <small class="text-muted">Gambar QRIS resmi masjid, akan tampil di halaman pembayaran Donasi & Kurban.</small>
    @error('qris') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Sejarah</label>
            <textarea name="sejarah" rows="4" class="form-control">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Visi</label>
                <textarea name="visi" rows="3" class="form-control">{{ old('visi', $profil->visi ?? '') }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Misi (1 baris per poin)</label>
                <textarea name="misi" rows="3" class="form-control">{{ old('misi', $profil->misi ?? '') }}</textarea>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Fasilitas (1 baris per poin)</label>
            <textarea name="fasilitas" rows="4" class="form-control">{{ old('fasilitas', $profil->fasilitas ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $profil->email ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $profil->whatsapp ?? '') }}" class="form-control">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Embed Google Maps</label>
            <textarea name="google_maps_embed" rows="3" class="form-control" placeholder="<iframe src=...></iframe>">{{ old('google_maps_embed', $profil->google_maps_embed ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-brand-blue">Simpan Perubahan</button>
    </form>
</div>
@endsection
