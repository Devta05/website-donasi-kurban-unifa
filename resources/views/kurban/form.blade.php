@extends('layouts.app')

@section('title', 'Kurban')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="section-title text-center">Pendaftaran Kurban</h2>
            <p class="section-subtitle text-center">Pilih jenis hewan kurban sesuai yang anda inginkan</p>

            <form action="{{ route('kurban.store') }}" method="POST" id="formKurban">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

                <div class="row g-3 mb-4">
                    @foreach ($paketSapi as $paket)
                        <div class="col-md-6">
                            <div class="card card-modern p-3 h-100 paket-option" data-id="{{ $paket->id }}" data-hewan="sapi" style="cursor:pointer;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paket_kurban_id" value="{{ $paket->id }}" id="paket{{ $paket->id }}" data-hewan="sapi" {{ old('paket_kurban_id') == $paket->id ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-semibold" for="paket{{ $paket->id }}">🐄 {{ $paket->nama_paket }}</label>
                                </div>
                                <p class="text-muted small mt-2 mb-1">{{ $paket->deskripsi }}</p>
                                <h6 class="fw-bold text-primary mb-0">Rp {{ number_format($paket->harga, 0, ',', '.') }} / slot</h6>
                            </div>
                        </div>
                    @endforeach

@if ($paketSapi->isEmpty())
    <div class="col-12">
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-circle"></i> Mohon maaf, saat ini belum tersedia paket kurban. Silahkan hubungin admin untuk informasi lebih lanjut.
        </div>
    </div>
@endif

                    @foreach ($paketKambing as $paket)
                        <div class="col-md-6">
                            <div class="card card-modern p-3 h-100 paket-option" data-id="{{ $paket->id }}" data-hewan="kambing" style="cursor:pointer;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paket_kurban_id" value="{{ $paket->id }}" id="paket{{ $paket->id }}" data-hewan="kambing" {{ old('paket_kurban_id') == $paket->id ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-semibold" for="paket{{ $paket->id }}">🐐 {{ $paket->nama_paket }}</label>
                                </div>
                                <p class="text-muted small mt-2 mb-1">{{ $paket->deskripsi }}</p>
                                <h6 class="fw-bold text-primary mb-0">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="slotContainer" class="card card-modern p-4 mb-4 d-none">
                    <h6 class="fw-semibold mb-3"><i class="bi bi-grid-3x3-gap"></i> Pilih Slot (maksimal 7 peserta per ekor sapi)</h6>
                    <div id="slotList" class="d-flex flex-wrap gap-2"></div>
                    @error('slot_sapi_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="card card-modern p-4">
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
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-brand-green w-100 py-2 fw-semibold">Lanjutkan ke Pembayaran <i class="bi bi-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const slotContainer = document.getElementById('slotContainer');
    const slotList = document.getElementById('slotList');

    document.querySelectorAll('input[name="paket_kurban_id"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.paket-option').forEach(el => el.classList.remove('border', 'border-primary'));
            this.closest('.paket-option').classList.add('border', 'border-primary');

            if (this.dataset.hewan === 'sapi') {
                slotContainer.classList.remove('d-none');
                fetch(`/kurban/slot/${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        slotList.innerHTML = '';
                        data.forEach(slot => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'btn ' + (slot.status === 'terisi' ? 'btn-secondary disabled' : 'btn-outline-success');
                            btn.style.width = '70px';
                            btn.innerText = 'Slot ' + slot.nomor_slot;
                            btn.disabled = slot.status === 'terisi';
                            btn.addEventListener('click', () => {
                                document.querySelectorAll('#slotList button').forEach(b => b.classList.remove('btn-success'));
                                btn.classList.add('btn-success');
                                let hidden = document.getElementById('slot_sapi_id');
                                if (!hidden) {
                                    hidden = document.createElement('input');
                                    hidden.type = 'hidden';
                                    hidden.name = 'slot_sapi_id';
                                    hidden.id = 'slot_sapi_id';
                                    document.getElementById('formKurban').appendChild(hidden);
                                }
                                hidden.value = slot.id;
                            });
                            slotList.appendChild(btn);
                        });
                    });
            } else {
                slotContainer.classList.add('d-none');
                document.getElementById('slot_sapi_id')?.remove();
            }
        });
    });
</script>
@endpush
