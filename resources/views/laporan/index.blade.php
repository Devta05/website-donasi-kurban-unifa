@extends('layouts.app')

@section('title', 'Laporan Donasi')

@section('content')
<div class="container py-5">
    <h2 class="section-title text-center">Laporan Penyaluran Donasi</h2>
    <p class="section-subtitle text-center">Transparansi pengelolaan dana donasi Masjid Al-Fajri UNIFA.</p>

    <div class="row g-4">
        @forelse ($laporan as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card card-modern p-4 h-100 text-center">
                    <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 3rem;"></i>
                    <h6 class="fw-semibold mt-3">{{ $item->jenis_donasi }}</h6>
                    <p class="text-muted small mb-1"><i class="bi bi-calendar3"></i> {{ $item->tanggal->translatedFormat('d F Y') }}</p>
                    <span class="badge bg-success mb-3 align-self-center">{{ $item->status_penyaluran }}</span>
                    @if ($item->keterangan)
                        <p class="text-muted small">{{ Str::limit($item->keterangan, 80) }}</p>
                    @endif
                    @if ($item->file_laporan)
                        <a href="{{ asset('storage/' . $item->file_laporan) }}" target="_blank" class="btn btn-brand-blue mt-auto">
                            <i class="bi bi-eye"></i> Lihat Laporan PDF
                        </a>
                    @else
                        <span class="text-muted small mt-auto">File belum tersedia</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada laporan donasi yang dipublikasikan.</p>
        @endforelse
    </div>

    <div class="mt-5">{{ $laporan->links() }}</div>
</div>
@endsection