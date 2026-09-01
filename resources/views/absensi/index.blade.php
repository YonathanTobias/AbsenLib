<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Perpustakaan - STIKes Panti Waluya Malang</title>
    <meta name="description" content="Sistem Absensi Digital Perpustakaan STIKes Panti Waluya Malang. Catat kehadiran Anda dengan mudah dan cepat.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #0284c7;
            --accent: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --bg-card: rgba(255,255,255,0.82);
            --border-glass: rgba(255,255,255,0.6);
            --shadow-card: 0 8px 32px rgba(37,99,235,0.1);
            --shadow-hover: 0 20px 48px rgba(37,99,235,0.22);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 40%, #f0f9ff 70%, #e0f2fe 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            animation: blobFloat 8s ease-in-out infinite alternate;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #60a5fa, #38bdf8);
            top: -150px; left: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #38bdf8, #93c5fd);
            bottom: -100px; right: -80px;
            animation-delay: -4s;
        }
        @keyframes blobFloat {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(30px, 20px) scale(1.08); }
        }

        /* Dot pattern overlay */
        body .bg-dots {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, #93c5fd 1.2px, transparent 1.2px);
            background-size: 32px 32px;
            opacity: 0.28;
            z-index: 0;
            pointer-events: none;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 50%, #0284c7 100%);
            box-shadow: 0 4px 24px rgba(37,99,235,0.28);
            backdrop-filter: blur(12px);
            padding: 0.85rem 0;
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            letter-spacing: -0.01em;
        }
        .navbar-brand .brand-icon {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .navbar-brand .brand-sub {
            font-size: 0.65rem;
            font-weight: 400;
            opacity: 0.85;
            display: block;
            line-height: 1;
        }
        .btn-admin-nav {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 1rem;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 50px;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(8px);
        }
        .btn-admin-nav:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.7);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            text-align: center;
            padding: 2.5rem 1.5rem 1rem;
            position: relative;
            z-index: 1;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(37,99,235,0.1);
            border: 1px solid rgba(37,99,235,0.22);
            border-radius: 50px;
            padding: 0.3rem 0.9rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.8rem;
            letter-spacing: 0.03em;
        }
        .hero-badge .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--success);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.8); }
        }
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.5rem, 4vw, 2.1rem);
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.2;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }
        .hero-title span {
            background: linear-gradient(90deg, #1d4ed8, #0284c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-sub {
            color: var(--text-secondary);
            font-size: 0.9rem;
            max-width: 420px;
            margin: 0 auto 1.5rem;
            line-height: 1.6;
        }

        /* ===== MAIN LAYOUT ===== */
        .main-grid {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem 3rem;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 1.5rem;
            position: relative;
            z-index: 1;
        }
        @media (max-width: 768px) {
            .main-grid { grid-template-columns: 1fr; }
        }

        /* ===== GLASS CARD ===== */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: box-shadow 0.35s ease, transform 0.35s ease;
        }
        .glass-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        /* Card Header */
        .card-header-custom {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(37,99,235,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .card-header-title .icon-wrap {
            width: 32px; height: 32px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
        }
        .icon-wrap-primary { background: linear-gradient(135deg, #1d4ed8, #0284c7); color: #fff; }
        .icon-wrap-secondary { background: linear-gradient(135deg, #0284c7, #0ea5e9); color: #fff; }

        /* ===== FORM ABSENSI ===== */
        .form-body { padding: 1.5rem; }

        .input-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.45rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
        .input-group-custom {
            position: relative;
            margin-bottom: 0.5rem;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #93c5fd;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .form-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--text-primary);
            background: rgba(255,255,255,0.85);
            border: 2px solid rgba(147,197,253,0.45);
            border-radius: 12px;
            outline: none;
            transition: all 0.25s ease;
        }
        .form-input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        }
        .form-input:focus + .input-icon,
        .input-group-custom:focus-within .input-icon { color: var(--primary); }
        .form-input::placeholder { color: #94a3b8; font-weight: 400; }
        .input-hint {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.35rem;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 50%, #0284c7 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
            margin-top: 1.2rem;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.5s ease;
        }
        .btn-submit:hover::before { left: 100%; }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.38);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Register Button */
        .btn-register {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.9rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--success);
            background: rgba(16,185,129,0.1);
            border: 1.5px solid rgba(16,185,129,0.3);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
        }
        .btn-register:hover {
            background: rgba(16,185,129,0.18);
            border-color: var(--success);
            transform: translateY(-1px);
        }

        /* ===== FLASH MESSAGES ===== */
        .alert-custom {
            border-radius: 12px;
            padding: 0.9rem 1rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            font-size: 0.84rem;
            font-weight: 500;
            animation: slideDown 0.3s ease;
            position: relative;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success-custom {
            background: rgba(16,185,129,0.1);
            border: 1.5px solid rgba(16,185,129,0.25);
            color: #065f46;
        }
        .alert-warning-custom {
            background: rgba(245,158,11,0.1);
            border: 1.5px solid rgba(245,158,11,0.25);
            color: #78350f;
        }
        .alert-icon {
            font-size: 1rem;
            margin-top: 0.05rem;
            flex-shrink: 0;
        }
        .alert-close {
            position: absolute;
            top: 0.6rem; right: 0.7rem;
            background: none; border: none;
            cursor: pointer;
            opacity: 0.5;
            font-size: 0.85rem;
            color: inherit;
            transition: opacity 0.2s;
        }
        .alert-close:hover { opacity: 1; }
        .btn-daftar-inline {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
            padding: 0.3rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(245,158,11,0.15);
            border: 1.5px solid rgba(245,158,11,0.4);
            border-radius: 50px;
            color: #78350f;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-daftar-inline:hover { background: rgba(245,158,11,0.25); }

        /* ===== VISITORS TABLE ===== */
        .visitors-table { width: 100%; border-collapse: collapse; }
        .visitors-table thead th {
            padding: 0.75rem 1rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(37,99,235,0.08);
            background: rgba(249,250,251,0.6);
        }
        .visitors-table thead th:first-child { padding-left: 1.5rem; border-radius: 0; }
        .visitors-table thead th:last-child { padding-right: 1.5rem; }
        .visitors-table tbody tr {
            border-bottom: 1px solid rgba(37,99,235,0.05);
            transition: background 0.2s ease;
        }
        .visitors-table tbody tr:last-child { border-bottom: none; }
        .visitors-table tbody tr:hover { background: rgba(37,99,235,0.04); }
        .visitors-table td {
            padding: 0.8rem 1rem;
            vertical-align: middle;
        }
        .visitors-table td:first-child { padding-left: 1.5rem; }
        .visitors-table td:last-child { padding-right: 1.5rem; }

        /* Avatar */
        .avatar-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .visitor-name-cell {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }
        .visitor-name { font-weight: 600; font-size: 0.88rem; color: var(--text-primary); }

        /* Nomor induk chip */
        .nim-chip {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            background: rgba(37,99,235,0.08);
            border: 1px solid rgba(37,99,235,0.18);
            border-radius: 6px;
            font-size: 0.78rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--primary);
        }

        /* Badge peran */
        .badge-peran {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.65rem;
            border-radius: 50px;
            font-size: 0.73rem;
            font-weight: 600;
        }
        .badge-mahasiswa { background: rgba(2,132,199,0.12); color: #0284c7; border: 1px solid rgba(2,132,199,0.25); }
        .badge-dosen     { background: rgba(16,185,129,0.12); color: #065f46; border: 1px solid rgba(16,185,129,0.25); }
        .badge-umum      { background: rgba(107,114,128,0.12); color: #374151; border: 1px solid rgba(107,114,128,0.25); }

        .time-label {
            font-size: 0.78rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
        }
        .empty-icon {
            width: 60px; height: 60px;
            background: rgba(37,99,235,0.08);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            color: #93c5fd;
            margin: 0 auto 0.75rem;
        }
        .empty-text { color: var(--text-secondary); font-size: 0.85rem; }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.6);
            backdrop-filter: blur(6px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeOverlay 0.25s ease;
        }
        .modal-overlay.show { display: flex; }
        @keyframes fadeOverlay {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .modal-box {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.2);
            animation: modalSlideUp 0.3s cubic-bezier(0.34,1.56,0.64,1);
            overflow: hidden;
        }
        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-header {
            padding: 1.3rem 1.5rem;
            background: linear-gradient(90deg, #1d4ed8, #2563eb);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .modal-close {
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 50%;
            width: 30px; height: 30px;
            cursor: pointer;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .modal-close:hover { background: rgba(255,255,255,0.35); }
        .modal-body { padding: 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #f3f4f6; display: flex; gap: 0.75rem; justify-content: flex-end; }

        .modal-form-group { margin-bottom: 1.1rem; }
        .modal-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            outline: none;
            transition: all 0.25s;
        }
        .modal-input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
        }
        .modal-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 16px;
            padding-right: 2.5rem;
        }
        .btn-modal-cancel {
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            background: #f3f4f6;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-modal-cancel:hover { background: #e5e7eb; }
        .btn-modal-submit {
            padding: 0.6rem 1.4rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(90deg, #1d4ed8, #2563eb);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.25s;
        }
        .btn-modal-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.35);
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding: 1.5rem;
            position: relative;
            z-index: 1;
            color: var(--text-secondary);
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="bg-dots"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a class="navbar-brand" href="#">
                <div class="brand-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <span>Perpustakaan STIKes</span>
                    <span class="brand-sub">Panti Waluya Malang</span>
                </div>
            </a>
            <a href="{{ route('absensi.admin') }}" class="btn-admin-nav">
                <i class="fa-solid fa-user-shield"></i>
                <span>Admin</span>
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero-section">
        <div class="hero-badge">
            <span class="dot"></span>
            Sistem Aktif — Absensi Digital
        </div>
        <h1 class="hero-title">Selamat Datang di<br><span>Perpustakaan</span></h1>
        <p class="hero-sub">Catat kehadiran Anda dengan mudah. Cukup masukkan Nomor Induk dan kami akan mencatat waktu kunjungan Anda secara otomatis.</p>
    </div>

    <!-- Main Grid -->
    <div class="main-grid">

        <!-- Form Absensi -->
        <div class="glass-card">
            <div class="card-header-custom">
                <div class="card-header-title">
                    <div class="icon-wrap icon-wrap-primary"><i class="fa-solid fa-pen-to-square"></i></div>
                    Catat Kehadiran
                </div>
                <button class="btn-register" onclick="document.getElementById('modalRegister').classList.add('show')">
                    <i class="fa-solid fa-user-plus"></i>
                    Register Baru
                </button>
            </div>
            <div class="form-body">

                {{-- Flash Success --}}
                @if (session('success'))
                    <div class="alert-custom alert-success-custom">
                        <i class="fa-solid fa-circle-check alert-icon"></i>
                        <div>{{ session('success') }}</div>
                        <button class="alert-close" onclick="this.closest('.alert-custom').remove()"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                {{-- Error Not Found --}}
                @if (session('error_not_found'))
                    <div class="alert-custom alert-warning-custom">
                        <i class="fa-solid fa-triangle-exclamation alert-icon"></i>
                        <div>
                            {{ session('error_not_found') }}
                            <br>
                            <button class="btn-daftar-inline" onclick="document.getElementById('modalRegister').classList.add('show')">
                                <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                            </button>
                        </div>
                        <button class="alert-close" onclick="this.closest('.alert-custom').remove()"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert-custom alert-warning-custom">
                        <i class="fa-solid fa-triangle-exclamation alert-icon"></i>
                        <div>{{ $errors->first() }}</div>
                        <button class="alert-close" onclick="this.closest('.alert-custom').remove()"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                <!-- Form Absen -->
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1.5rem;">
                        <label for="nomor_induk" class="input-label">NIM / NIP / NIS</label>
                        <div class="input-group-custom">
                            <input
                                type="text"
                                class="form-input"
                                id="nomor_induk"
                                name="nomor_induk"
                                value="{{ old('nomor_induk') }}"
                                placeholder="Masukkan nomor induk Anda..."
                                autofocus
                                required
                                autocomplete="off"
                            >
                            <i class="fa-solid fa-id-card input-icon"></i>
                        </div>
                        <p class="input-hint"><i class="fa-solid fa-circle-info" style="color:#2563eb; margin-right:4px;"></i>Cukup masukkan nomor induk untuk mencatat kehadiran.</p>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-paper-plane" style="margin-right:0.5rem;"></i>
                        Catat Kehadiran Sekarang
                    </button>
                </form>

                <!-- Jam Sekarang -->
                <div style="text-align:center; margin-top:1.2rem; padding-top:1.2rem; border-top: 1px solid rgba(37,99,235,0.1);">
                    <p style="font-size:0.78rem; color:var(--text-secondary); margin-bottom:0.2rem;">Waktu Sekarang</p>
                    <p id="current-time" style="font-family:'Poppins',sans-serif; font-size:1.6rem; font-weight:800; color:var(--primary); letter-spacing:-0.03em;"></p>
                    <p id="current-date" style="font-size:0.78rem; color:var(--text-secondary);"></p>
                </div>
            </div>
        </div>

        <!-- Pengunjung Terakhir -->
        <div class="glass-card">
            <div class="card-header-custom">
                <div class="card-header-title">
                    <div class="icon-wrap icon-wrap-secondary"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    Pengunjung Terakhir
                </div>
                <span style="display:inline-flex; align-items:center; gap:0.3rem; background:linear-gradient(90deg,#1d4ed8,#0284c7); color:#fff; font-size:0.73rem; font-weight:700; padding:0.25rem 0.75rem; border-radius:50px;">
                    <i class="fa-solid fa-star" style="font-size:0.65rem;"></i> Top 10
                </span>
            </div>
            <table class="visitors-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Nomor Induk</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensi as $item)
                        @php
                            $nama = $item->anggota->nama ?? '-';
                            $peran = $item->anggota->peran ?? 'Umum';
                            $initials = strtoupper(substr($nama, 0, 1));
                            if (str_word_count($nama) > 1) {
                                $parts = explode(' ', $nama);
                                $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                            }
                            $colors = ['#2563eb','#0284c7','#0891b2','#0d9488','#059669','#3b82f6','#0369a1','#1d4ed8'];
                            $color = $colors[crc32($nama) % count($colors)];
                            $badgeClass = match($peran) {
                                'Mahasiswa'   => 'badge-mahasiswa',
                                'Dosen/Staff' => 'badge-dosen',
                                default       => 'badge-umum',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="visitor-name-cell">
                                    <div class="avatar-circle" style="background:{{ $color }};">{{ $initials }}</div>
                                    <span class="visitor-name">{{ $nama }}</span>
                                </div>
                            </td>
                            <td><span class="nim-chip">{{ $item->anggota->nomor_induk ?? '-' }}</span></td>
                            <td><span class="badge-peran {{ $badgeClass }}">{{ $peran }}</span></td>
                            <td>
                                <span class="time-label">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $item->created_at->format('H:i') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fa-solid fa-users"></i></div>
                                    <p class="empty-text">Belum ada pengunjung hari ini.<br>Jadilah yang pertama!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© {{ date('Y') }} Perpustakaan STIKes Panti Waluya Malang &mdash; Sistem Absensi Digital</p>
    </div>

    <!-- ===== MODAL REGISTER ===== -->
    <div class="modal-overlay" id="modalRegister" onclick="if(event.target===this) this.classList.remove('show')">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fa-solid fa-user-plus"></i>
                    Registrasi Anggota Baru
                </div>
                <button class="modal-close" onclick="document.getElementById('modalRegister').classList.remove('show')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('absensi.register') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-form-group">
                        <label class="input-label" for="reg_nomor_induk">NIM / NIP / NIS</label>
                        <input type="text" class="modal-input" id="reg_nomor_induk" name="nomor_induk" placeholder="Contoh: 210101050" required autocomplete="off">
                    </div>
                    <div class="modal-form-group">
                        <label class="input-label" for="reg_nama">Nama Lengkap</label>
                        <input type="text" class="modal-input" id="reg_nama" name="nama" placeholder="Contoh: Ahmad Subagja" required>
                    </div>
                    <div class="modal-form-group">
                        <label class="input-label" for="reg_peran">Status / Peran</label>
                        <select class="modal-input modal-select" id="reg_peran" name="peran" required>
                            <option value="Mahasiswa" selected>Mahasiswa</option>
                            <option value="Dosen/Staff">Dosen / Staff</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="document.getElementById('modalRegister').classList.remove('show')">Batal</button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fa-solid fa-check" style="margin-right:0.4rem;"></i>Daftar & Absen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Live clock
        function updateClock() {
            const now = new Date();
            const timeEl = document.getElementById('current-time');
            const dateEl = document.getElementById('current-date');
            if (timeEl) {
                timeEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
            if (dateEl) {
                dateEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            }
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Auto-dismiss alerts after 6 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert-custom').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 6000);
    </script>
</body>
</html>