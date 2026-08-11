@extends('layouts.app')

@section('title', 'Berita')

@section('content')
<div class="container py-5">
    <h2 class="section-title text-center">Berita & Kegiatan</h2>
    <p class="section-subtitle text-center">Update informasi terbaru seputar Masjid Al-Fajri UNIFA</p>

    <div class="row g-4">
        @forelse ($berita as $item)
            <div class="col-md-4">
                <div class="card card-modern h-100">
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" style="height:190px; object-fit:cover; border-radius:14px 14px 0 0;" alt="{{ $item->judul }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:190px; border-radius:14px 14px 0 0;">
                            <i class="bi bi-newspaper fs-1 text-secondary"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-1"><i class="bi bi-calendar3"></i> {{ $item->created_at->translatedFormat('d F Y') }}</small>
                        <h6 class="fw-semibold">{{ Str::limit($item->judul, 60) }}</h6>
                        <p class="text-muted small flex-grow-1">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                        <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-outline-primary mt-2">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada berita.</p>
        @endforelse
    </div>

    <div class="mt-5">{{ $berita->links() }}</div>
</div>
@endsection
