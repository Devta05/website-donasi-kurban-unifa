@extends('layouts.admin')

@section('title', 'Detail Kurban')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-modern p-4">
            <a href="{{ route('admin.kurban.index') }}" class="small text-decoration-none mb-3 d-inline-block"><i class="bi bi-arrow-left"></i> Kembali</a>
            <h5 class="fw-bold mb-3">Detail Kurban {{ $kurban->kode_transaksi }}</h5>

            <div class="row mb-2"><div class="col-4 text-muted">Nama</div><div class="col-8">{{ $kurban->nama }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">WhatsApp</div><div class="col-8">{{ $kurban->whatsapp }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Email</div><div class="col-8">{{ $kurban->email ?: '-' }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Alamat</div><div class="col-8">{{ $kurban->alamat }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Paket</div><div class="col-8">{{ $kurban->paketKurban->nama_paket ?? $kurban->nama_paket_snapshot ?? 'Paket telah dihapus' }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Slot</div><div class="col-8">{{ $kurban->slotSapi ? '#'.$kurban->slotSapi->nomor_slot : '-' }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Nominal</div><div class="col-8">Rp {{ number_format($kurban->nominal, 0, ',', '.') }}</div></div>
            <div class="row mb-2"><div class="col-4 text-muted">Tanggal</div><div class="col-8">{{ $kurban->tanggal->format('d/m/Y') }} <span class="text-muted small">({{ $kurban->created_at->timezone('Asia/Makassar')->format('H:i:s') }} WITA)</span></div></div>
            <div class="row mb-3"><div class="col-4 text-muted">Status</div><div class="col-8"><span class="badge badge-status-{{ $kurban->status }}">{{ str_replace('_',' ',$kurban->status) }}</span></div></div>

            <h6 class="fw-semibold">Bukti Pembayaran</h6>
            @if ($kurban->bukti_pembayaran)
                @if (str_ends_with($kurban->bukti_pembayaran, '.pdf'))
                    <a href="{{ asset('storage/' . $kurban->bukti_pembayaran) }}" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Lihat File PDF</a>
                @else
                    <a href="{{ asset('storage/' . $kurban->bukti_pembayaran) }}" target="_blank">
                        <img src="{{ asset('storage/' . $kurban->bukti_pembayaran) }}" class="img-fluid rounded mb-3" style="max-height:350px;">
                    </a>
                @endif
            @else
                <p class="text-muted">Belum ada bukti pembayaran.</p>
            @endif

            @if ($kurban->status === 'menunggu_verifikasi')
                <div class="d-flex gap-2 mt-3">
                    <form action="{{ route('admin.kurban.verifikasi', $kurban) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-brand-green"><i class="bi bi-check-circle"></i> Verifikasi</button>
                    </form>
                    <form action="{{ route('admin.kurban.tolak', $kurban) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger"><i class="bi bi-x-circle"></i> Tolak</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
