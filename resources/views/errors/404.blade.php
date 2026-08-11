@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5 text-center">
    <h1 class="display-1 fw-bold text-primary">404</h1>
    <h4 class="fw-semibold">Halaman Tidak Ditemukan</h4>
    <p class="text-muted">Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
    <a href="{{ route('home') }}" class="btn btn-brand-blue mt-2">Kembali ke Beranda</a>
</div>
@endsection
