@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="container py-5 text-center">
    <h1 class="display-1 fw-bold text-primary">403</h1>
    <h4 class="fw-semibold">Akses Ditolak</h4>
    <p class="text-muted">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ route('home') }}" class="btn btn-brand-blue mt-2">Kembali ke Beranda</a>
</div>
@endsection
