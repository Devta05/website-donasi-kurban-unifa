@extends('layouts.app')

@section('title', 'Donasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h2 class="section-title text-center">Salurkan Donasi Anda</h2>
            <p class="section-subtitle text-center">Pilih jenis donasi dan lengkapi form berikut</p>

            <div class="card card-modern p-4">
                <form action="{{ route('donasi.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Donasi</label>
                        <select name="jenis_donasi_id" class="form-select @error('jenis_donasi_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Donasi --</option>
                            @foreach ($jenisDonasi as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_donasi_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                        @error('jenis_donasi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Nomor WhatsApp</label>
    <input type="text" inputmode="numeric" name="whatsapp" value="{{ old('whatsapp') }}" class="form-control @error('whatsapp') is-invalid @enderror" placeholder="08xxxxxxxxxx" pattern="[0-9]*" maxlength="15" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/\D/g, '')">
    @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email (opsional)</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
    <label class="form-label fw-semibold">Nominal Donasi (Rp)</label>
    <input type="text" inputmode="numeric" id="nominal_display" value="{{ old('nominal') ? number_format(old('nominal'), 0, ',', '.') : '' }}" class="form-control @error('nominal') is-invalid @enderror" required>
    <input type="hidden" name="nominal" id="nominal_value" value="{{ old('nominal') }}">
    @error('nominal') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pesan / Doa (opsional)</label>
                        <textarea name="pesan" rows="3" class="form-control @error('pesan') is-invalid @enderror">{{ old('pesan') }}</textarea>
                        @error('pesan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand-blue w-100 py-2 fw-semibold">Lanjutkan ke Pembayaran <i class="bi bi-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const nominalDisplay = document.getElementById('nominal_display');
    const nominalValue = document.getElementById('nominal_value');

    nominalDisplay.addEventListener('input', function () {
        let angka = this.value.replace(/\D/g, ''); // hapus semua selain angka
        nominalValue.value = angka;
        this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
    });
</script>
@endpush

@endsection
