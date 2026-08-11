@extends('layouts.app')

@section('title', 'Kurban Berhasil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            <h2 class="fw-bold mt-3">Pendaftaran Kurban Berhasil!</h2>
            <p class="text-muted">Terima kasih. Tim kami akan segera melakukan verifikasi pembayaran Anda.</p>

            <div class="card card-modern p-4 mt-4 text-start">
                <div class="row mb-2"><div class="col-5 text-muted">Kode Transaksi</div><div class="col-7 fw-bold">{{ $kurban->kode_transaksi }}</div></div>
                <div class="row mb-2"><div class="col-5 text-muted">Nama</div><div class="col-7">{{ $kurban->nama }}</div></div>
                <div class="row mb-2"><div class="col-5 text-muted">Paket</div><div class="col-7">{{ $kurban->paketKurban->nama_paket }}</div></div>
                @if ($kurban->slotSapi)
                    <div class="row mb-2"><div class="col-5 text-muted">Slot</div><div class="col-7">Slot #{{ $kurban->slotSapi->nomor_slot }}</div></div>
                @endif
                <div class="row mb-2"><div class="col-5 text-muted">Nominal</div><div class="col-7">Rp {{ number_format($kurban->nominal, 0, ',', '.') }}</div></div>
                <div class="row"><div class="col-5 text-muted">Status</div><div class="col-7"><span class="badge badge-status-{{ $kurban->status }}">Menunggu Verifikasi</span></div></div>
            </div>

            <p class="text-muted small mt-3">Simpan kode transaksi ini untuk mengecek status kurban Anda di menu <a href="{{ route('cek-status.index') }}">Cek Status</a>.</p>
            <a href="{{ route('home') }}" class="btn btn-brand-blue mt-2">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
