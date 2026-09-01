<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Absensi Perpustakaan STIKes Panti Waluya</title>
    <meta name="description" content="Halaman login khusus Admin Sistem Absensi Perpustakaan STIKes Panti Waluya Malang.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            overflow: hidden;
        }

        /* ===== LEFT PANEL (Decorative) ===== */
        .left-panel {
            flex: 1;
            background: linear-gradient(145deg, #1e1b4b 0%, #312e81 40%, #4c1d95 80%, #1e1b4b 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        @media (max-width: 768px) { .left-panel { display: none; } }

        /* Animated orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.3;
            animation: orbFloat 10s ease-in-out infinite alternate;
        }
        .orb-1 { width: 350px; height: 350px; background: #818cf8; top: -80px; left: -80px; }
        .orb-2 { width: 250px; height: 250px; background: #a78bfa; bottom: -60px; right: 30px; animation-delay: -5s; }
        .orb-3 { animation: orb3Float 10s ease-in-out infinite alternate; width: 180px; height: 180px; background: #06b6d4; }
        @keyframes orbFloat { from { transform: translate(0,0); } to { transform: translate(20px,25px); } }
        @keyframes orb3Float { from { top: 48%; left: 48%; } to { top: 52%; left: 52%; } }

        /* Grid dots */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(167,139,250,0.3) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .panel-content { position: relative; z-index: 1; text-align: center; }
        .panel-logo {
            width: 90px; height: 90px;
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; color: #fff;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
        .panel-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem; font-weight: 800; color: #fff;
            margin-bottom: 0.6rem; letter-spacing: -0.03em;
        }
        .panel-sub {
            color: rgba(196,181,253,0.8);
            font-size: 0.9rem; line-height: 1.6;
            max-width: 280px; margin: 0 auto 2rem;
        }
        .feature-list { display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-start; max-width: 280px; margin: 0 auto; }
        .feature-item {
            display: flex; align-items: center; gap: 0.65rem;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; padding: 0.55rem 1rem;
            color: rgba(255,255,255,0.85);
            font-size: 0.82rem; font-weight: 500; width: 100%;
            backdrop-filter: blur(4px);
        }
        .feature-item i { color: #a78bfa; font-size: 0.9rem; width: 16px; text-align: center; }

        /* ===== RIGHT PANEL (Login Form) ===== */
        .right-panel {
            width: 100%; max-width: 480px;
            background: #0f172a;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 2.5rem 2rem;
            position: relative;
        }
        @media (max-width: 768px) { .right-panel { max-width: 100%; } }

        .right-panel::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79,70,229,0.15), transparent 70%);
            bottom: -80px; right: -80px;
            pointer-events: none;
        }

        .login-box { width: 100%; max-width: 380px; position: relative; z-index: 1; }

        .login-back-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            color: rgba(148,163,184,0.8); font-size: 0.8rem;
            text-decoration: none; margin-bottom: 2rem; transition: color 0.2s;
        }
        .login-back-link:hover { color: #a5b4fc; }

        .login-greeting { margin-bottom: 2rem; }
        .login-label-top {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(79,70,229,0.15);
            border: 1px solid rgba(79,70,229,0.25);
            border-radius: 50px; padding: 0.25rem 0.8rem;
            font-size: 0.72rem; font-weight: 600; color: #a5b4fc;
            letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 0.8rem;
        }
        .login-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.9rem; font-weight: 800; color: #f1f5f9;
            letter-spacing: -0.03em; margin-bottom: 0.4rem;
        }
        .login-subtitle { color: #64748b; font-size: 0.85rem; }

        /* Alert error */
        .login-alert {
            display: flex; align-items: center; gap: 0.65rem;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px; padding: 0.8rem 1rem;
            color: #fca5a5; font-size: 0.83rem; margin-bottom: 1.3rem;
            animation: shakeAlert 0.4s ease;
        }
        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Form Group */
        .form-group { margin-bottom: 1.1rem; }
        .form-label {
            display: block; font-size: 0.78rem; font-weight: 600;
            color: #94a3b8; text-transform: uppercase;
            letter-spacing: 0.06em; margin-bottom: 0.5rem;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 1rem; top: 50%;
            transform: translateY(-50%);
            color: #334155; font-size: 0.9rem; pointer-events: none;
            transition: color 0.2s;
        }
        .login-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            font-size: 0.95rem; font-family: 'Inter', sans-serif;
            color: #f1f5f9;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 12px; outline: none;
            transition: all 0.25s ease;
        }
        .login-input:focus {
            border-color: #6366f1;
            background: rgba(99,102,241,0.08);
            box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
        }
        .login-input:focus + .input-icon { color: #a5b4fc; }
        .login-input::placeholder { color: #475569; }

        /* Password wrap */
        .pw-wrap { position: relative; }
        .pw-input { padding-right: 3rem !important; }
        .toggle-pw {
            position: absolute; right: 0.9rem; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; color: #475569;
            cursor: pointer; font-size: 0.9rem; padding: 0.2rem;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: #a5b4fc; }

        /* Divider */
        .form-divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 0.5rem 0 1rem;
            color: #1e293b; font-size: 0.7rem;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,0.06);
        }

        /* Login button */
        .btn-login {
            width: 100%; padding: 0.95rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem; font-weight: 700; color: #fff;
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
            border: none; border-radius: 12px; cursor: pointer;
            position: relative; overflow: hidden;
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
        }
        .btn-login::before {
            content: '';
            position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }
        .btn-login:hover::before { left: 100%; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(79,70,229,0.45); }
        .btn-login:active { transform: translateY(0); }

        /* Divider */
        .login-divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 1.2rem 0; color: #334155; font-size: 0.75rem;
        }
        .login-divider::before, .login-divider::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,0.07);
        }

        /* Back to form */
        .btn-back-form {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            width: 100%; padding: 0.85rem;
            font-size: 0.85rem; font-weight: 600; color: #64748b;
            background: rgba(255,255,255,0.04);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 12px; text-decoration: none;
            transition: all 0.25s; font-family: 'Inter', sans-serif;
        }
        .btn-back-form:hover {
            color: #94a3b8; background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.15);
        }

        /* Credential hint */
        .credential-hint {
            margin-top: 1.2rem;
            background: rgba(79,70,229,0.08);
            border: 1px solid rgba(79,70,229,0.15);
            border-radius: 10px; padding: 0.8rem 1rem;
            font-size: 0.75rem; color: #475569; line-height: 1.7;
        }
        .credential-hint strong { color: #6366f1; }

        .login-note {
            margin-top: 1.2rem;
            text-align: center; color: #334155;
            font-size: 0.72rem; line-height: 1.5;
        }
        .login-note i { color: #4f46e5; }
    </style>
</head>
<body>

    <!-- Left Decorative Panel -->
    <div class="left-panel">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="panel-content">
            <div class="panel-logo">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h1 class="panel-title">Perpustakaan<br>STIKes PWM</h1>
            <p class="panel-sub">Panel admin untuk mengelola rekap kehadiran pengunjung dan data anggota perpustakaan.</p>
            <div class="feature-list">
                <div class="feature-item">
                    <i class="fa-solid fa-chart-bar"></i>
                    Rekap data kehadiran lengkap
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-users"></i>
                    Manajemen data anggota
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-file-excel"></i>
                    Export laporan ke Excel
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Tambah absensi manual
                </div>
            </div>
        </div>
    </div>

    <!-- Right Login Panel -->
    <div class="right-panel">
        <div class="login-box">

            <a href="{{ route('absensi.index') }}" class="login-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Form Absensi
            </a>

            <div class="login-greeting">
                <div class="login-label-top">
                    <i class="fa-solid fa-lock"></i>
                    Area Terbatas
                </div>
                <h2 class="login-title">Masuk sebagai<br>Admin</h2>
                <p class="login-subtitle">Masukkan username dan password untuk mengakses dashboard.</p>
            </div>

            @if (session('error'))
                <div class="login-alert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.process') }}" method="POST" id="login-form">
                @csrf

                {{-- USERNAME --}}
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-wrap">
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="login-input"
                            placeholder="Masukkan username..."
                            value="{{ old('username') }}"
                            autofocus
                            required
                            autocomplete="username"
                        >
                        <i class="fa-solid fa-user input-icon"></i>
                    </div>
                    @error('username')
                        <p style="color:#f87171; font-size:0.75rem; margin-top:0.35rem;">
                            <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap pw-wrap">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="login-input pw-input"
                            placeholder="Masukkan password..."
                            required
                            autocomplete="current-password"
                        >
                        <i class="fa-solid fa-lock input-icon"></i>
                        <button type="button" class="toggle-pw" onclick="togglePassword()" title="Tampilkan/Sembunyikan password">
                            <i class="fa-solid fa-eye" id="pw-eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p style="color:#f87171; font-size:0.75rem; margin-top:0.35rem;">
                            <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="btn-login" id="login-btn">
                    <i class="fa-solid fa-right-to-bracket" style="margin-right:0.5rem;"></i>
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="login-divider">atau</div>

            <a href="{{ route('absensi.index') }}" class="btn-back-form">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Form Absensi Publik
            </a>

            <div class="login-note" style="margin-top:1.2rem;">
                <i class="fa-solid fa-shield-halved"></i>
                Halaman ini hanya untuk petugas perpustakaan yang berwenang.<br>
                Akses tidak sah akan dicatat oleh sistem.
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('pw-eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        }

        // Loading state on submit
        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('login-btn');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right:0.5rem;"></i>Memverifikasi...';
            btn.disabled = true;
        });
    </script>
</body>
</html>