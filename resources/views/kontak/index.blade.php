@extends('layouts.app')

@section('title', 'Hubungi Admin')

@section('content')
<div class="container py-5">
    <h2 class="section-title text-center">Hubungi Admin</h2>
    <p class="section-subtitle text-center">Kami siap membantu pertanyaan Anda seputar donasi dan kurban</p>

    <div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-modern p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt text-primary"></i> Alamat</h6>
            <p class="text-muted">{{ $profil->alamat ?? 'Jl. Prof. Dr. H. M. Yamin, SH, Makassar' }}</p>

            <h6 class="fw-bold mb-3 mt-3"><i class="bi bi-envelope text-primary"></i> Email</h6>
            <p class="text-muted">{{ $profil->email ?? 'masjid@unifa.ac.id' }}</p>

            <h6 class="fw-bold mb-3 mt-3"><i class="bi bi-whatsapp text-primary"></i> WhatsApp</h6>
            <p class="text-muted">{{ $profil->whatsapp ?? '628123456789' }}</p>

            <a href="https://wa.me/{{ $profil->whatsapp ?? '628123456789' }}" target="_blank" class="btn btn-brand-green mt-3">
                <i class="bi bi-whatsapp"></i> Chat via WhatsApp
            </a>
        </div>
    </div>
</div>
</div>
@endsection
