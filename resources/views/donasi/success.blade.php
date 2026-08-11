@extends('layouts.app')

@section('title', 'Donasi Berhasil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            <h2 class="fw-bold mt-3">Donasi Berhasil Dikirim!</h2>
            <p class="text-muted">Terima kasih atas donasi Anda. Tim kami akan segera melakukan verifikasi pembayaran.</p>

            <div class="card card-modern p-4 mt-4 text-start">
                <div class="row mb-2"><div class="col-5 text-muted">Kode Transaksi</div><div class="col-7 fw-bold">{{ $donasi->kode_transaksi }}</div></div>
                <div class="row mb-2"><div class="col-5 text-muted">Nama</div><div class="col-7">{{ $donasi->nama }}</div></div>
                <div class="row mb-2"><div class="col-5 text-muted">Jenis Donasi</div><div class="col-7">{{ $donasi->jenisDonasi->nama ?? $donasi->nama_jenis_donasi_snapshot ?? 'Jenis telah dihapus' }}</div></div>
                <div class="row mb-2"><div class="col-5 text-muted">Nominal</div><div class="col-7">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</div></div>
                <div class="row"><div class="col-5 text-muted">Status</div><div class="col-7"><span class="badge badge-status-{{ $donasi->status }}">Menunggu Verifikasi</span></div></div>
            </div>

            <p class="text-muted small mt-3">Simpan kode transaksi ini untuk mengecek status donasi Anda di menu <a href="{{ route('cek-status.index') }}">Cek Status</a>.</p>
            <a href="{{ route('home') }}" class="btn btn-brand-blue mt-2">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
