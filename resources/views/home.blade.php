@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="hero-section">
    <div class="container text-center">
        <h1 class="fw-bold display-5 mb-3">{{ $profil->nama_masjid ?? 'Masjid Al-Fajri Universitas Fajar' }}</h1>
        <p class="lead mb-4">Sinergi ibadah, dakwah, dan kepedulian sosial melalui donasi dan kurban yang mudah, transparan, dan terpercaya.</p>
        <a href="{{ route('donasi.index') }}" class="btn btn-light btn-lg fw-semibold me-2"><i class="bi bi-heart"></i> Donasi Sekarang</a>
        <a href="{{ route('kurban.index') }}" class="btn btn-outline-light btn-lg fw-semibold"><i class="bi bi-flower1"></i> Daftar Kurban</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card card-modern stat-card p-4 h-100">
                    <i class="bi bi-cash-stack text-primary fs-1"></i>
                    <h3 class="fw-bold mt-2">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total Donasi</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-modern stat-card p-4 h-100">
                    <i class="bi bi-people text-success fs-1"></i>
                    <h3 class="fw-bold mt-2">{{ number_format($totalDonatur, 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total Donatur</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-modern stat-card p-4 h-100">
                    <i class="bi bi-flower1 text-primary fs-1"></i>
                    <h3 class="fw-bold mt-2">{{ number_format($totalKurban, 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Total Peserta Kurban</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Berita Terbaru</h2>
        <p class="section-subtitle text-center">Informasi dan kegiatan terbaru dari Masjid Al-Fajri UNIFA</p>
        <div class="row g-4">
            @forelse ($beritaTerbaru as $berita)
                <div class="col-md-4">
                    <div class="card card-modern h-100">
                        @if ($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" class="card-img-top" style="height:180px; object-fit:cover; border-radius:14px 14px 0 0;" alt="{{ $berita->judul }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px; border-radius:14px 14px 0 0;">
                                <i class="bi bi-newspaper fs-1 text-secondary"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="fw-semibold">{{ Str::limit($berita->judul, 60) }}</h6>
                            <p class="text-muted small">{{ Str::limit(strip_tags($berita->konten), 90) }}</p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="small text-primary fw-semibold">Baca selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada berita.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
