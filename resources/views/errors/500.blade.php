@extends('layouts.app')

@section('title', '500 - Terjadi Kesalahan Server')

@section('content')
<div class="container py-5 text-center">
    <h1 class="display-1 fw-bold text-primary">500</h1>
    <h4 class="fw-semibold">Terjadi Kesalahan Server</h4>
    <p class="text-muted">Maaf, terjadi kesalahan pada server kami. Silakan coba lagi nanti.</p>
    <a href="{{ route('home') }}" class="btn btn-brand-blue mt-2">Kembali ke Beranda</a>
</div>
@endsection
