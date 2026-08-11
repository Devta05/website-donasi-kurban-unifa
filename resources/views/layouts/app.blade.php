<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masjid Kampus Universitas Fajar')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-blue: #0d6efd;
            --brand-green: #198754;
        }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #212529; }
        .navbar-brand { font-weight: 700; }
        .hero-section {
            background: linear-gradient(135deg, var(--brand-blue) 0%, var(--brand-green) 100%);
            color: #fff;
            padding: 90px 0 70px;
        }
        .card-modern {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .card-modern:hover { transform: translateY(-4px); box-shadow: 0 10px 26px rgba(0,0,0,0.10); }
        .btn-brand-blue { background-color: var(--brand-blue); border-color: var(--brand-blue); color:#fff; }
        .btn-brand-blue:hover { background-color:#0b5ed7; color:#fff; }
        .btn-brand-green { background-color: var(--brand-green); border-color: var(--brand-green); color:#fff; }
        .btn-brand-green:hover { background-color:#157347; color:#fff; }
        .section-title { font-weight: 700; margin-bottom: 8px; }
        .section-subtitle { color: #6c757d; margin-bottom: 40px; }
        footer { background-color: #0b1f14; color: #cfd8d3; }
        footer a { color: #cfd8d3; text-decoration: none; }
        footer a:hover { color: #fff; }
        #back-to-top {
            position: fixed; bottom: 24px; right: 24px; display:none; z-index: 1050;
            width: 46px; height: 46px; border-radius: 50%;
        }
        .stat-card { border-radius: 14px; }
        .badge-status-menunggu_verifikasi { background-color:#ffc107; color:#212529; }
        .badge-status-terverifikasi { background-color:#198754; }
        .badge-status-ditolak { background-color:#dc3545; }
    </style>

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
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
    </main>

    @include('partials.footer')

    <button id="back-to-top" class="btn btn-brand-blue shadow"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const backToTop = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
        });
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    </script>

    @stack('scripts')
</body>
</html>
