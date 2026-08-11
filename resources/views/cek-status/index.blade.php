@extends('layouts.app')

@section('title', 'Cek Status Transaksi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2 class="section-title text-center">Cek Status Transaksi</h2>
            <p class="section-subtitle text-center">Masukkan kode transaksi donasi (DON-xxxxxx) atau kurban (KRB-xxxxxx)</p>

            <div class="card card-modern p-4 mb-4">
                <form action="{{ route('cek-status.cek') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="kode_transaksi" value="{{ $kode ?? old('kode_transaksi') }}" class="form-control" placeholder="Contoh: DON-000001" required>
                    <button type="submit" class="btn btn-brand-blue px-4">Cek</button>
                </form>
                @error('kode_transaksi') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            </div>

            @isset($data)
                @if ($data)
                    <div class="card card-modern p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-receipt"></i> Detail Transaksi</h6>
                        <div class="row mb-2"><div class="col-5 text-muted">Kode</div><div class="col-7 fw-bold">{{ $data->kode_transaksi }}</div></div>
                        <div class="row mb-2"><div class="col-5 text-muted">Nama</div><div class="col-7">{{ $data->nama }}</div></div>
                        <div class="row mb-2"><div class="col-5 text-muted">Jenis</div><div class="col-7">{{ $tipe === 'donasi' ? $data->jenisDonasi->nama : $data->paketKurban->nama_paket }}</div></div>
                        <div class="row mb-2"><div class="col-5 text-muted">Tanggal</div><div class="col-7">{{ $data->tanggal->translatedFormat('d F Y') }}</div></div>
                        <div class="row mb-2"><div class="col-5 text-muted">Nominal</div><div class="col-7">Rp {{ number_format($data->nominal, 0, ',', '.') }}</div></div>
                        <div class="row"><div class="col-5 text-muted">Status</div><div class="col-7">
                            <span class="badge badge-status-{{ $data->status }}">
                                {{ str_replace('_', ' ', ucfirst($data->status)) }}
                            </span>
                        </div></div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">Kode transaksi <strong>{{ $kode }}</strong> tidak ditemukan.</div>
                @endif
            @endisset
        </div>
    </div>
</div>
@endsection
