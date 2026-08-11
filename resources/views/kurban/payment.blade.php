@extends('layouts.app')

@section('title', 'Pembayaran Kurban')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2 class="section-title text-center">Pembayaran Kurban</h2>
            <p class="section-subtitle text-center">Scan QRIS lalu upload bukti pembayaran</p>

            <div class="card card-modern p-4 text-center mb-4">
                <p class="text-muted small mb-1">Paket</p>
                <h6 class="fw-bold">{{ $paket->nama_paket ?? '-' }}</h6>
                <p class="text-muted small mb-1 mt-2">Nominal</p>
                <h4 class="fw-bold text-primary">Rp {{ number_format($data['nominal'], 0, ',', '.') }}</h4>

                <div class="d-flex justify-content-center my-4">
    <div class="border rounded-4 p-3 bg-white" style="width:200px;">
        @if ($profil && $profil->qris)
            <img src="{{ asset('storage/' . $profil->qris) }}" alt="QRIS Pembayaran" class="img-fluid">
        @else
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=QRIS-MASJID-UNIFA-{{ urlencode($data['nama']) }}" alt="QRIS Pembayaran" class="img-fluid">
        @endif
    </div>
</div>
                
                <div class="alert alert-primary small text-start">
                    <strong>Petunjuk Pembayaran:</strong>
                    <ol class="mb-0 ps-3">
                        <li>Buka aplikasi mobile banking / e-wallet Anda.</li>
                        <li>Scan kode QRIS di atas.</li>
                        <li>Pastikan nominal sesuai, lalu bayar.</li>
                        <li>Upload bukti pembayaran pada form di bawah ini.</li>
                    </ol>
                </div>
            </div>

            <div class="card card-modern p-4">
                <form action="{{ route('kurban.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                        <small class="text-muted">Format: JPG, JPEG, PNG, PDF. Maksimal 2 MB.</small>
                        @error('bukti_pembayaran') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-brand-green w-100 py-2 fw-semibold">Kirim Bukti Pembayaran <i class="bi bi-upload"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
