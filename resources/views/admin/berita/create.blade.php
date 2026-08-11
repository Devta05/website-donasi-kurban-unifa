@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul</label>
            <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" required>
            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Gambar</label>
            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
            @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Konten</label>
            <textarea name="konten" rows="8" class="form-control @error('konten') is-invalid @enderror" required>{{ old('konten') }}</textarea>
            @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-brand-blue">Simpan</button>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
