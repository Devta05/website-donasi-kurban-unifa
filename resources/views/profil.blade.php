@extends('layouts.app')

@section('title', 'Profil Masjid')

@section('content')
<div class="container py-5">
    <h2 class="section-title text-center">Profil Masjid Al-Fajri Universitas Fajar</h2>
    <p class="section-subtitle text-center">Mengenal lebih dekat sejarah, visi, misi, dan fasilitas masjid kami</p>

    @if ($profil)
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                @if ($profil->foto)
                    <img src="{{ asset('storage/' . $profil->foto) }}" class="img-fluid rounded-4 shadow mb-4" alt="{{ $profil->nama_masjid }}">
                @endif

                <div class="card card-modern p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt text-primary"></i> Alamat & Kontak</h6>
                    <p class="mb-1 small">{{ $profil->alamat }}</p>
                    <p class="mb-1 small"><i class="bi bi-envelope"></i> {{ $profil->email }}</p>
                    <p class="mb-3 small"><i class="bi bi-whatsapp"></i> {{ $profil->whatsapp }}</p>
                    @if ($profil->google_maps_embed)
                        <div class="ratio ratio-16x9 rounded overflow-hidden">
                            {!! $profil->google_maps_embed !!}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card card-modern p-4 mb-4">
                    <h5 class="fw-bold text-primary"><i class="bi bi-clock-history"></i> Sejarah</h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $profil->sejarah }}</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card card-modern p-4 h-100">
                            <h6 class="fw-bold text-success"><i class="bi bi-eye"></i> Visi</h6>
                            <p class="text-muted small mb-0">{{ $profil->visi }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-modern p-4 h-100">
                            <h6 class="fw-bold text-success"><i class="bi bi-flag"></i> Misi</h6>
                            <p class="text-muted small mb-0" style="white-space: pre-line;">{{ $profil->misi }}</p>
                        </div>
                    </div>
                </div>
                <div class="card card-modern p-4">
                    <h6 class="fw-bold text-primary"><i class="bi bi-building"></i> Fasilitas</h6>
                    <ul class="text-muted small mb-0">
                        @foreach (explode("\n", $profil->fasilitas ?? '') as $fasilitas)
                            @if (trim($fasilitas) !== '')
                                <li>{{ trim($fasilitas) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-muted">Profil masjid belum tersedia.</p>
    @endif
</div>
@endsection
