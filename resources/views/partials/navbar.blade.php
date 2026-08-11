<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand text-primary" href="{{ route('home') }}">
            <i class="bi bi-mosque"></i> Masjid Al-Fajri UNIFA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'fw-semibold text-primary' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('profil.index') ? 'fw-semibold text-primary' : '' }}" href="{{ route('profil.index') }}">Profil Masjid</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('berita.*') ? 'fw-semibold text-primary' : '' }}" href="{{ route('berita.index') }}">Berita</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('donasi.*') ? 'fw-semibold text-primary' : '' }}" href="{{ route('donasi.index') }}">Donasi</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('kurban.*') ? 'fw-semibold text-primary' : '' }}" href="{{ route('kurban.index') }}">Kurban</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('laporan.index') ? 'fw-semibold text-primary' : '' }}" href="{{ route('laporan.index') }}">Laporan Donasi</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('cek-status.*') ? 'fw-semibold text-primary' : '' }}" href="{{ route('cek-status.index') }}">Cek Status</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak.index') ? 'fw-semibold text-primary' : '' }}" href="{{ route('kontak.index') }}">Hubungi Admin</a></li>
                <li class="nav-item ms-lg-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-brand-blue btn-sm px-3"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">Login Admin</a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
