@extends('layouts.admin')

@section('title', 'Tambah Laporan Donasi')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('admin.laporan-donasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Judul / Jenis Laporan</label>
                <input type="text" name="jenis_donasi" value="{{ old('jenis_donasi') }}" class="form-control @error('jenis_donasi') is-invalid @enderror" placeholder="Contoh: Laporan Donasi Bulan Januari 2026" required>
                @error('jenis_donasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nominal (opsional)</label>
                <input type="number" name="nominal" value="{{ old('nominal') }}" class="form-control @error('nominal') is-invalid @enderror">
                @error('nominal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status Penyaluran</label>
                <input type="text" name="status_penyaluran" value="{{ old('status_penyaluran', 'Sudah Disalurkan') }}" class="form-control @error('status_penyaluran') is-invalid @enderror" required>
                @error('status_penyaluran') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Upload File Laporan (PDF)</label>
            <input type="file" name="file_laporan" class="form-control @error('file_laporan') is-invalid @enderror" accept="application/pdf" required>
            <small class="text-muted">Format PDF, maksimal 5 MB. File ini yang akan dilihat pengunjung.</small>
            @error('file_laporan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Keterangan (opsional)</label>
            <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
        </div>
        <button type="submit" class="btn btn-brand-blue">Simpan</button>
        <a href="{{ route('admin.laporan-donasi.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection