@extends('layouts.admin')

@section('title', 'Detail Donasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-modern p-4">
            <a href="{{ route('admin.donasi.index') }}" class="small text-decoration-none mb-3 d-inline-block"><i class="bi bi-arrow-left"></i> Kembali</a>
            <h5 class="fw-bold mb-3">Detail Donasi {{ $donasi->kode_transaksi }}</h5>

            <div class="row mb-2"><div class="col-4 text-muted">Nama</div><div class="col-8">{{ $donasi->nama }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">WhatsApp</div><div class="col-8">{{ $donasi->whatsapp }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Email</div><div class="col-8">{{ $donasi->email ?: '-' }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Jenis Donasi</div><div class="col-8">{{ $donasi->jenisDonasi->nama }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Nominal</div><div class="col-8">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Tanggal</div><div class="col-8">{{ $donasi->tanggal->format('d/m/Y') }} <span class="text-muted small">({{ $donasi->created_at->timezone('Asia/Makassar')->format('H:i:s') }} WITA)</span></div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Pesan</div><div class="col-8">{{ $donasi->pesan ?: '-' }}</div></div>
            <div class="row mb-3"><div class="col-4 text-muted">Status</div><div class="col-8"><span class="badge badge-status-{{ $donasi->status }}">{{ str_replace('_',' ',$donasi->status) }}</span></div></div>

            <h6 class="fw-semibold">Bukti Pembayaran</h6>
            @if ($donasi->bukti_pembayaran)
                @if (str_ends_with($donasi->bukti_pembayaran, '.pdf'))
                    <a href="{{ asset('storage/' . $donasi->bukti_pembayaran) }}" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Lihat File PDF</a>
                @else
                    <a href="{{ asset('storage/' . $donasi->bukti_pembayaran) }}" target="_blank">
                        <img src="{{ asset('storage/' . $donasi->bukti_pembayaran) }}" class="img-fluid rounded mb-3" style="max-height:350px;">
                    </a>
                @endif
            @else
                <p class="text-muted">Belum ada bukti pembayaran.</p>
            @endif

            @if ($donasi->status === 'menunggu_verifikasi')
                <div class="d-flex gap-2 mt-3">
                    <form action="{{ route('admin.donasi.verifikasi', $donasi) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-brand-green"><i class="bi bi-check-circle"></i> Verifikasi</button>
                    </form>
                    <form action="{{ route('admin.donasi.tolak', $donasi) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger"><i class="bi bi-x-circle"></i> Tolak</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
