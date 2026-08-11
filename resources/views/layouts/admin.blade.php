<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Masjid Al-Fajri UNIFA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        #sidebar {
            width: 250px; min-height: 100vh; background: #0d1b2a; color: #fff; position: fixed; top:0; left:0;
        }
        #sidebar .brand { padding: 20px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,.08); }
        #sidebar a { color: #adb5bd; padding: 12px 20px; display:flex; align-items:center; gap:10px; text-decoration:none; }
        #sidebar a:hover, #sidebar a.active { color:#fff; background: rgba(13,110,253,.25); border-right: 3px solid #0d6efd; }
        #main-content { margin-left: 250px; padding: 24px; }
        @media (max-width: 991px) {
            #sidebar { margin-left: -250px; transition: margin-left .3s; z-index: 1040; }
            #sidebar.show { margin-left: 0; }
            #main-content { margin-left: 0; }
        }
        .card-modern { border:none; border-radius: 14px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); }
        .badge-status-menunggu_verifikasi { background-color:#ffc107; color:#212529; }
        .badge-status-terverifikasi { background-color:#198754; }
        .badge-status-ditolak { background-color:#dc3545; }
    </style>
    @stack('styles')
</head>
<body>

<div id="sidebar">
    <div class="brand"><i class="bi bi-mosque"></i> Admin Masjid Al-Fajri</div>
    <nav class="d-flex flex-column py-2">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('admin.donasi.index') }}" class="{{ request()->routeIs('admin.donasi.*') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i> Kelola Donasi</a>
        <a href="{{ route('admin.kurban.index') }}" class="{{ request()->routeIs('admin.kurban.*') ? 'active' : '' }}"><i class="bi bi-flower1"></i> Kelola Kurban</a>
        <a href="{{ route('admin.jenis-donasi.index') }}" class="{{ request()->routeIs('admin.jenis-donasi.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Kelola Jenis Donasi</a>
        <a href="{{ route('admin.paket-kurban.index') }}" class="{{ request()->routeIs('admin.paket-kurban.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Kelola Paket Kurban</a>
        <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i> Kelola Berita</a>
        <a href="{{ route('admin.profil-masjid.edit') }}" class="{{ request()->routeIs('admin.profil-masjid.*') ? 'active' : '' }}"><i class="bi bi-building"></i> Kelola Profil Masjid</a>
        <a href="{{ route('admin.laporan-keuangan.index') }}" class="{{ request()->routeIs('admin.laporan-keuangan.*') ? 'active' : '' }}"><i class="bi bi-graph-up-arrow"></i> Laporan Keuangan</a>
        <a href="{{ route('admin.laporan-donasi.index') }}" class="{{ request()->routeIs('admin.laporan-donasi.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> Kelola Laporan Donasi</a>
        <a href="{{ route('home') }}" target="_blank"><i class="bi bi-globe"></i> Lihat Website</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link text-start w-100" style="color:#adb5bd; padding:12px 20px;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>
</div>

<div id="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4 d-lg-none">
        <button class="btn btn-outline-secondary" id="sidebar-toggle"><i class="bi bi-list"></i></button>
        <span class="fw-semibold">{{ auth()->user()->name }}</span>
    </div>

    <div class="d-none d-lg-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h4>
        <span class="text-muted"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: @json(session('success')), timer: 3000, showConfirmButton: false });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
            });
        </script>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
