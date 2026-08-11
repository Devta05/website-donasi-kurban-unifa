<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Masjid Al-Fajri UNIFA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #0d6efd 0%, #198754 100%);
        }
        .login-card { border-radius: 18px; border: none; box-shadow: 0 15px 40px rgba(0,0,0,.2); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-mosque text-primary" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-2">Login Admin</h4>
                    <p class="text-muted small">Masjid Al-Fajri Universitas Fajar</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger small">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
    <label class="form-label fw-semibold">Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" required>
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            <i class="bi bi-eye" id="toggleIcon"></i>
        </button>
    </div>
</div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Login</button>
                </form>
                <a href="{{ route('home') }}" class="text-center small mt-3 text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>

</body>
</html>
