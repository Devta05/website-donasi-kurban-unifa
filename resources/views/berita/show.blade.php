@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('berita.index') }}" class="text-decoration-none small"><i class="bi bi-arrow-left"></i> Kembali ke Berita</a>
            <h2 class="fw-bold mt-3">{{ $berita->judul }}</h2>
            <p class="text-muted small"><i class="bi bi-calendar3"></i> {{ $berita->created_at->translatedFormat('d F Y') }}
                @if ($berita->user) &bull; oleh {{ $berita->user->name }} @endif
            </p>

            @if ($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid rounded-4 shadow mb-4 w-100" style="max-height:420px; object-fit:cover;" alt="{{ $berita->judul }}">
            @endif

            <div class="card card-modern p-4">
                <div style="white-space: pre-line;">{{ $berita->konten }}</div>
            </div>

            @if ($beritaLain->count())
                <h5 class="fw-bold mt-5 mb-3">Berita Lainnya</h5>
                <div class="row g-3">
                    @foreach ($beritaLain as $lain)
                        <div class="col-md-4">
                            <a href="{{ route('berita.show', $lain->slug) }}" class="text-decoration-none text-dark">
                                <div class="card card-modern h-100">
                                    <div class="card-body">
                                        <h6 class="fw-semibold small">{{ Str::limit($lain->judul, 50) }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
