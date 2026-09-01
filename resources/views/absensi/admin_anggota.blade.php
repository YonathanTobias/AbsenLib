<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota — Admin Perpustakaan STIKes Panti Waluya</title>
    <meta name="description" content="Dashboard admin untuk mengelola data anggota perpustakaan STIKes Panti Waluya Malang.">
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
            --secondary: #0284c7;
            --accent: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-border: rgba(255,255,255,0.07);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            color: var(--text-primary);
            min-height: 100vh;
        }

        .layout { display: flex; min-height: 100vh; }

        /* Sidebar — identical to admin.blade.php */
        .sidebar {
            width: 240px;
            background: #090e1a;
            border-right: 1px solid var(--dark-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
        }
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .main-area { margin-left: 0 !important; }
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.4rem 1.3rem;
            border-bottom: 1px solid var(--dark-border);
        }
        .sidebar-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #1d4ed8, #0284c7);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff; flex-shrink: 0;
        }
        .sidebar-logo-text { font-family:'Poppins',sans-serif; font-size:0.82rem; font-weight:700; color:var(--text-primary); line-height:1.2; }
        .sidebar-logo-sub { font-size:0.65rem; font-weight:400; color:var(--text-muted); display:block; }
        .sidebar-nav { flex:1; padding:1.2rem 0.8rem; display:flex; flex-direction:column; gap:0.25rem; }
        .sidebar-label { font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); padding:0.5rem 0.7rem 0.3rem; margin-top:0.5rem; }
        .nav-link { display:flex; align-items:center; gap:0.65rem; padding:0.65rem 0.9rem; border-radius:10px; font-size:0.84rem; font-weight:500; color:var(--text-secondary); text-decoration:none; transition:all 0.2s ease; }
        .nav-link:hover { background:rgba(255,255,255,0.05); color:var(--text-primary); }
        .nav-link.active { background:linear-gradient(90deg,rgba(37,99,235,0.2),rgba(2,132,199,0.1)); color:#93c5fd; border:1px solid rgba(37,99,235,0.25); font-weight:600; }
        .nav-link .nav-icon { width:18px; text-align:center; font-size:0.88rem; }
        .sidebar-footer { padding:1rem 0.8rem; border-top:1px solid var(--dark-border); display:flex; flex-direction:column; gap:0.4rem; }
        .sidebar-footer-link { display:flex; align-items:center; gap:0.6rem; padding:0.6rem 0.9rem; border-radius:10px; font-size:0.82rem; font-weight:500; text-decoration:none; transition:all 0.2s; }
        .sidebar-footer-back { color:var(--text-secondary); }
        .sidebar-footer-back:hover { background:rgba(255,255,255,0.05); color:var(--text-primary); }
        .sidebar-logout-form { width:100%; }
        .sidebar-logout-btn { width:100%; display:flex; align-items:center; gap:0.6rem; padding:0.6rem 0.9rem; border-radius:10px; font-size:0.82rem; font-weight:600; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.15); color:#f87171; cursor:pointer; transition:all 0.2s; font-family:'Inter',sans-serif; }
        .sidebar-logout-btn:hover { background:rgba(239,68,68,0.2); }

        /* Main area */
        .main-area { margin-left:240px; flex:1; display:flex; flex-direction:column; }

        /* Topbar */
        .topbar { display:flex; align-items:center; justify-content:space-between; padding:1rem 2rem; background:rgba(15,23,42,0.8); backdrop-filter:blur(12px); border-bottom:1px solid var(--dark-border); position:sticky; top:0; z-index:40; }
        .topbar-left h1 { font-family:'Poppins',sans-serif; font-size:1.1rem; font-weight:700; color:var(--text-primary); }
        .topbar-left p { font-size:0.78rem; color:var(--text-muted); }
        .admin-badge { display:flex; align-items:center; gap:0.5rem; background:rgba(37,99,235,0.12); border:1px solid rgba(37,99,235,0.25); border-radius:50px; padding:0.4rem 0.9rem; font-size:0.78rem; font-weight:600; color:#93c5fd; }
        .admin-avatar { width:26px; height:26px; background:linear-gradient(135deg,#1d4ed8,#0284c7); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.7rem; color:#fff; }

        /* Page content */
        .page-content { padding: 2rem; }

        /* Flash Messages */
        .flash-msg { display:flex; align-items:center; gap:0.65rem; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2); border-radius:12px; padding:0.85rem 1rem; color:#6ee7b7; font-size:0.84rem; font-weight:500; margin-bottom:1.5rem; animation:slideDown 0.3s ease; }
        .flash-error { display:flex; align-items:center; gap:0.65rem; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:12px; padding:0.85rem 1rem; color:#fca5a5; font-size:0.84rem; font-weight:500; margin-bottom:1.5rem; animation:slideDown 0.3s ease; }
        @keyframes slideDown { from{opacity:0;transform:translateY(-10px);}to{opacity:1;transform:translateY(0);} }

        /* Stat grid */
        .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-bottom:1.5rem; }
        .stat-card { background:var(--dark-card); border:1px solid var(--dark-border); border-radius:16px; padding:1.2rem 1.3rem; display:flex; align-items:center; gap:1rem; position:relative; overflow:hidden; transition:transform 0.25s,box-shadow 0.25s; }
        .stat-card::before { content:''; position:absolute; top:0;left:0;right:0; height:2px; background:var(--stat-accent,linear-gradient(90deg,#1d4ed8,#0284c7)); }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.3); }
        .stat-icon-wrap { width:44px;height:44px; border-radius:12px; display:flex;align-items:center;justify-content:center; font-size:1.1rem; flex-shrink:0; }
        .stat-value { font-family:'Poppins',sans-serif; font-size:1.7rem; font-weight:800; color:var(--text-primary); line-height:1; margin-bottom:0.2rem; }
        .stat-label { font-size:0.73rem; color:var(--text-muted); font-weight:500; }

        /* Filter card */
        .filter-card { background:var(--dark-card); border:1px solid var(--dark-border); border-radius:16px; padding:1rem 1.2rem; margin-bottom:1.2rem; }
        .filter-form { display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap; }
        .filter-input-wrap { position:relative; flex:1; min-width:200px; }
        .filter-input-icon { position:absolute; left:0.9rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.85rem; pointer-events:none; }
        .filter-input { width:100%; padding:0.65rem 0.9rem 0.65rem 2.5rem; font-size:0.85rem; font-family:'Inter',sans-serif; color:var(--text-primary); background:rgba(255,255,255,0.05); border:1.5px solid rgba(255,255,255,0.08); border-radius:10px; outline:none; transition:all 0.2s; }
        .filter-input:focus { border-color:var(--primary); background:rgba(37,99,235,0.06); box-shadow:0 0 0 3px rgba(37,99,235,0.15); }
        .filter-input::placeholder { color:var(--text-muted); }
        .filter-select { padding:0.65rem 2.2rem 0.65rem 0.9rem; font-size:0.85rem; font-family:'Inter',sans-serif; color:var(--text-primary); background:rgba(255,255,255,0.05); border:1.5px solid rgba(255,255,255,0.08); border-radius:10px; outline:none; transition:all 0.2s; color-scheme:dark; min-width:180px; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 0.7rem center; background-size:14px; }
        .filter-select:focus { border-color:var(--primary); }
        .filter-btn-group { display:flex; gap:0.5rem; }
        .btn-filter { display:flex;align-items:center;gap:0.4rem; padding:0.65rem 1.1rem; font-size:0.83rem; font-weight:600; font-family:'Inter',sans-serif; border:none; border-radius:10px; cursor:pointer; transition:all 0.25s; white-space:nowrap; }
        .btn-primary-grad { background:linear-gradient(90deg,#1d4ed8,#0284c7); color:#fff; }
        .btn-primary-grad:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(37,99,235,0.35); }
        .btn-reset { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:var(--text-secondary); text-decoration:none; }
        .btn-reset:hover { background:rgba(255,255,255,0.1); color:var(--text-primary); }
        .btn-excel { background:rgba(16,185,129,0.12); border:1px solid rgba(16,185,129,0.2); color:#6ee7b7; text-decoration:none; }
        .btn-excel:hover { background:rgba(16,185,129,0.2); transform:translateY(-1px); }

        /* Table card */
        .table-card { background:var(--dark-card); border:1px solid var(--dark-border); border-radius:16px; overflow:hidden; }
        .table-card-header { padding:1rem 1.3rem; border-bottom:1px solid var(--dark-border); display:flex; align-items:center; justify-content:space-between; }
        .table-card-title { font-family:'Poppins',sans-serif; font-size:0.9rem; font-weight:700; color:var(--text-primary); display:flex; align-items:center; gap:0.5rem; }
        .table-card-title i { color:#38bdf8; }
        .result-count { font-size:0.75rem; color:var(--text-muted); background:rgba(255,255,255,0.05); border:1px solid var(--dark-border); border-radius:50px; padding:0.2rem 0.7rem; }

        .data-table { width:100%; border-collapse:collapse; }
        .data-table thead th { padding:0.75rem 1rem; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.09em; color:var(--text-muted); border-bottom:1px solid var(--dark-border); background:rgba(255,255,255,0.02); text-align:left; }
        .data-table thead th:first-child { padding-left:1.3rem; }
        .data-table thead th:last-child { padding-right:1.3rem; }
        .data-table tbody tr { border-bottom:1px solid rgba(255,255,255,0.04); transition:background 0.18s; }
        .data-table tbody tr:last-child { border-bottom:none; }
        .data-table tbody tr:hover { background:rgba(37,99,235,0.06); }
        .data-table td { padding:0.85rem 1rem; vertical-align:middle; font-size:0.85rem; }
        .data-table td:first-child { padding-left:1.3rem; }
        .data-table td:last-child { padding-right:1.3rem; }

        .row-num { width:28px;height:28px; border-radius:8px; background:rgba(37,99,235,0.12); border:1px solid rgba(37,99,235,0.25); display:flex;align-items:center;justify-content:center; font-size:0.72rem; font-weight:700; color:#60a5fa; }

        .name-cell { display:flex;align-items:center;gap:0.65rem; }
        .avatar-sm { width:36px;height:36px; border-radius:50%; display:flex;align-items:center;justify-content:center; font-size:0.78rem; font-weight:700; color:#fff; flex-shrink:0; }
        .name-bold { font-weight:600; color:var(--text-primary); }
        .name-sub { font-size:0.72rem; color:var(--text-muted); }

        .nim-chip { display:inline-block; padding:0.2rem 0.65rem; background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.25); border-radius:6px; font-size:0.78rem; font-family:'Courier New',monospace; font-weight:600; color:#93c5fd; }

        .badge-peran { display:inline-flex;align-items:center;gap:0.3rem; padding:0.25rem 0.7rem; border-radius:50px; font-size:0.72rem; font-weight:600; }
        .badge-mahasiswa { background:rgba(6,182,212,0.12);color:#67e8f9;border:1px solid rgba(6,182,212,0.2); }
        .badge-dosen     { background:rgba(16,185,129,0.12);color:#6ee7b7;border:1px solid rgba(16,185,129,0.2); }
        .badge-umum      { background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid rgba(148,163,184,0.15); }

        .dt-cell { display:flex;flex-direction:column;gap:0.1rem; }
        .dt-date { font-size:0.82rem;font-weight:600;color:var(--text-primary); }
        .dt-time { font-size:0.73rem;color:var(--text-muted);display:flex;align-items:center;gap:0.3rem; }

        /* Action Buttons */
        .action-btn-group { display:flex; align-items:center; justify-content:center; gap:0.45rem; }
        .btn-action {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1px solid transparent;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-action-edit {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.25);
            color: #fbbf24;
        }
        .btn-action-edit:hover {
            background: rgba(245, 158, 11, 0.25);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        }
        .btn-action-delete {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.25);
            color: #f87171;
        }
        .btn-action-delete:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        .empty-state { text-align:center; padding:4rem 2rem; }
        .empty-icon-wrap { width:72px;height:72px; border-radius:20px; background:rgba(37,99,235,0.1); border:1px solid rgba(37,99,235,0.25); display:flex;align-items:center;justify-content:center; font-size:1.8rem; color:#38bdf8; margin:0 auto 1rem; }
        .empty-title { font-family:'Poppins',sans-serif;font-size:1rem;font-weight:700;color:var(--text-secondary);margin-bottom:0.4rem; }
        .empty-sub { font-size:0.82rem;color:var(--text-muted); }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5);
            overflow: hidden;
            animation: modalIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
        }
        @keyframes modalIn { from { opacity:0; transform:scale(0.92) translateY(20px); } to { opacity:1; transform:scale(1) translateY(0); } }
        .modal-hdr {
            padding: 1.2rem 1.5rem;
            background: linear-gradient(90deg, #0f274a, #1e3a8a);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-ttl { font-family:'Poppins',sans-serif; font-size:0.95rem; font-weight:700; color:#fff; display:flex; align-items:center; gap:0.5rem; }
        .modal-cls { background:rgba(255,255,255,0.1); border:none; border-radius:50%; width:28px; height:28px; cursor:pointer; color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.85rem; transition:background 0.2s; }
        .modal-cls:hover { background:rgba(255,255,255,0.2); }
        .modal-bdy { padding:1.5rem; }
        .modal-ftr { padding:1rem 1.5rem; border-top:1px solid rgba(255,255,255,0.07); display:flex; gap:0.65rem; justify-content:flex-end; }

        .modal-grp { margin-bottom: 1rem; }
        .modal-lbl { display:block; font-size:0.73rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-muted); margin-bottom:0.4rem; }
        .modal-input {
            width: 100%;
            padding: 0.72rem 1rem;
            font-size: 0.88rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.09);
            border-radius: 10px;
            outline: none;
            transition: all 0.2s;
            color-scheme: dark;
        }
        .modal-input:focus { border-color: #2563eb; background:rgba(37,99,235,0.08); box-shadow:0 0 0 3px rgba(37,99,235,0.18); }
        .modal-hint { font-size:0.72rem; color:var(--text-muted); margin-top:0.3rem; }

        .btn-m-cancel {
            padding:0.6rem 1.1rem; font-size:0.83rem; font-weight:600;
            color:var(--text-secondary); background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.08); border-radius:10px; cursor:pointer;
            font-family:'Inter',sans-serif; transition:all 0.2s;
        }
        .btn-m-cancel:hover { background:rgba(255,255,255,0.1); color:var(--text-primary); }
        .btn-m-save {
            padding:0.6rem 1.3rem; font-size:0.83rem; font-weight:700;
            color:#fff; background:linear-gradient(90deg,#1d4ed8,#0284c7);
            border:none; border-radius:10px; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all 0.25s;
        }
        .btn-m-save:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(37,99,235,0.4); }
        .btn-m-delete {
            padding:0.6rem 1.3rem; font-size:0.83rem; font-weight:700;
            color:#fff; background:linear-gradient(90deg,#dc2626,#ef4444);
            border:none; border-radius:10px; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all 0.25s;
        }
        .btn-m-delete:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(239,68,68,0.4); }

        .btn-topbar-action {
            display: flex; align-items: center; gap: 0.45rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px;
            padding: 0.4rem 0.9rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }
        .btn-topbar-action:hover {
            background: rgba(37,99,235,0.15);
            border-color: rgba(37,99,235,0.3);
            color: #93c5fd;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon"><i class="fa-solid fa-book-open"></i></div>
            <div>
                <div class="sidebar-logo-text">Perpustakaan</div>
                <span class="sidebar-logo-sub">STIKes Panti Waluya</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-label">Menu Utama</div>
            <a href="{{ route('absensi.admin') }}" class="nav-link">
                <i class="fa-solid fa-list-check nav-icon"></i>
                Rekap Kehadiran
            </a>
            <a href="{{ route('absensi.admin.anggota') }}" class="nav-link active">
                <i class="fa-solid fa-users nav-icon"></i>
                Data Anggota
            </a>
            <div class="sidebar-label">Pengaturan</div>
            <a href="javascript:void(0)" onclick="openModalGantiPassword()" class="nav-link">
                <i class="fa-solid fa-key nav-icon"></i>
                Ganti Password
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('absensi.index') }}" class="sidebar-footer-link sidebar-footer-back">
                <i class="fa-solid fa-arrow-left" style="width:16px;text-align:center;"></i>
                Form Absensi
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket" style="width:16px;text-align:center;"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Area -->
    <div class="main-area">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>Data Anggota Terdaftar</h1>
                <p>{{ now()->format('l, d F Y') }}</p>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <button type="button" class="btn-topbar-action" onclick="openModalGantiPassword()" title="Ganti Username & Password">
                    <i class="fa-solid fa-key"></i>
                    <span>Ganti Password</span>
                </button>
                <div class="admin-badge">
                    <div class="admin-avatar"><i class="fa-solid fa-user-shield"></i></div>
                    {{ session('admin_username', 'Admin') }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="page-content">

            @if (session('success'))
                <div class="flash-msg">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="flash-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>Gagal menyimpan data:</strong>
                        <ul style="margin: 0.3rem 0 0 1.2rem; padding: 0;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Stat Cards -->
            <div class="stat-grid">
                <div class="stat-card" style="--stat-accent:linear-gradient(90deg,#10b981,#06b6d4);">
                    <div class="stat-icon-wrap" style="background:rgba(16,185,129,0.15);">
                        <i class="fa-solid fa-users" style="color:#6ee7b7;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalAnggota }}</div>
                        <div class="stat-label">Total Anggota Terdaftar</div>
                    </div>
                </div>
                <div class="stat-card" style="--stat-accent:linear-gradient(90deg,#0ea5e9,#2563eb);">
                    <div class="stat-icon-wrap" style="background:rgba(14,165,233,0.15);">
                        <i class="fa-solid fa-graduation-cap" style="color:#38bdf8;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $anggotas->where('peran','Mahasiswa')->count() }}</div>
                        <div class="stat-label">Anggota Mahasiswa</div>
                    </div>
                </div>
                <div class="stat-card" style="--stat-accent:linear-gradient(90deg,#0284c7,#1d4ed8);">
                    <div class="stat-icon-wrap" style="background:rgba(2,132,199,0.15);">
                        <i class="fa-solid fa-chalkboard-user" style="color:#60a5fa;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $anggotas->where('peran','Dosen/Staff')->count() }}</div>
                        <div class="stat-label">Dosen / Staff</div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <form method="GET" action="{{ route('absensi.admin.anggota') }}">
                    <div class="filter-form">
                        <div class="filter-input-wrap">
                            <i class="fa-solid fa-magnifying-glass filter-input-icon"></i>
                            <input type="text" name="search" class="filter-input" placeholder="Cari nama atau NIM/NIP..." value="{{ request('search') }}">
                        </div>
                        <select name="peran" class="filter-select">
                            <option value="">— Semua Status —</option>
                            <option value="Mahasiswa" {{ request('peran') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Dosen/Staff" {{ request('peran') == 'Dosen/Staff' ? 'selected' : '' }}>Dosen / Staff</option>
                            <option value="Umum" {{ request('peran') == 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                        <div class="filter-btn-group">
                            <button type="submit" class="btn-filter btn-primary-grad">
                                <i class="fa-solid fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('absensi.admin.anggota') }}" class="btn-filter btn-reset" title="Reset">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                            <a href="{{ route('absensi.admin.anggota.export', request()->query()) }}" class="btn-filter btn-excel">
                                <i class="fa-solid fa-file-excel"></i> Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <div class="table-card-header">
                    <div class="table-card-title">
                        <i class="fa-solid fa-id-card"></i>
                        Master Data Anggota
                    </div>
                    <span class="result-count">{{ $totalAnggota }} anggota</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Nomor Induk (NIM/NIP)</th>
                                <th>Nama Lengkap</th>
                                <th>Status / Peran</th>
                                <th>Tanggal Daftar</th>
                                <th style="width:100px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggotas as $item)
                                @php
                                    $nama = $item->nama;
                                    $initials = strtoupper(substr($nama, 0, 1));
                                    if (str_word_count($nama) > 1) {
                                        $parts = explode(' ', $nama);
                                        $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                                    }
                                    $colors = ['#2563eb','#0284c7','#0891b2','#0d9488','#059669','#3b82f6','#0369a1','#1d4ed8'];
                                    $color = $colors[crc32($nama) % count($colors)];
                                    $badgeClass = match($item->peran) {
                                        'Mahasiswa'   => 'badge-mahasiswa',
                                        'Dosen/Staff' => 'badge-dosen',
                                        default       => 'badge-umum',
                                    };
                                @endphp
                                <tr>
                                    <td><div class="row-num">{{ $loop->iteration }}</div></td>
                                    <td><span class="nim-chip">{{ $item->nomor_induk }}</span></td>
                                    <td>
                                        <div class="name-cell">
                                            <div class="avatar-sm" style="background:{{ $color }};">{{ $initials }}</div>
                                            <div>
                                                <div class="name-bold">{{ $nama }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-peran {{ $badgeClass }}">{{ $item->peran }}</span></td>
                                    <td>
                                        <div class="dt-cell">
                                            <span class="dt-date">{{ $item->created_at->format('d/m/Y') }}</span>
                                            <span class="dt-time"><i class="fa-regular fa-clock"></i>{{ $item->created_at->format('H:i') }} WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-btn-group">
                                            <button type="button" class="btn-action btn-action-edit"
                                                onclick="openEditAnggotaModal({{ $item->id }}, '{{ addslashes($item->nomor_induk) }}', '{{ addslashes($item->nama) }}', '{{ addslashes($item->peran) }}')"
                                                title="Edit Anggota">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-action-delete"
                                                onclick="openDeleteAnggotaModal({{ $item->id }}, '{{ addslashes($item->nama) }}', '{{ addslashes($item->nomor_induk) }}')"
                                                title="Hapus Anggota">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap"><i class="fa-solid fa-user-slash"></i></div>
                                            <div class="empty-title">Data anggota tidak ditemukan</div>
                                            <div class="empty-sub">Coba ubah filter pencarian atau tambah anggota baru lewat form publik.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- end page-content -->
    </div><!-- end main-area -->
</div><!-- end layout -->

<!-- ===== MODAL EDIT ANGGOTA ===== -->
<div class="modal-overlay" id="modalEditAnggota" onclick="if(event.target===this) closeEditAnggotaModal()">
    <div class="modal-box">
        <div class="modal-hdr">
            <div class="modal-ttl"><i class="fa-solid fa-user-pen"></i>Edit Data Anggota</div>
            <button type="button" class="modal-cls" onclick="closeEditAnggotaModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEditAnggota" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-bdy">
                <div class="modal-grp">
                    <label class="modal-lbl" for="edit_nomor_induk">Nomor Induk (NIM/NIP)</label>
                    <input type="text" class="modal-input" id="edit_nomor_induk" name="nomor_induk" placeholder="Contoh: 210101050" required autocomplete="off">
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="edit_nama">Nama Lengkap</label>
                    <input type="text" class="modal-input" id="edit_nama" name="nama" placeholder="Contoh: Ahmad Subagja" required>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="edit_peran">Status / Peran</label>
                    <select class="modal-input" id="edit_peran" name="peran" required style="appearance:none; background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E&quot;); background-repeat:no-repeat; background-position:right 0.8rem center; background-size:14px; padding-right:2.5rem;">
                        <option value="Mahasiswa">Mahasiswa</option>
                        <option value="Dosen/Staff">Dosen / Staff</option>
                        <option value="Umum">Umum</option>
                    </select>
                </div>
            </div>
            <div class="modal-ftr">
                <button type="button" class="btn-m-cancel" onclick="closeEditAnggotaModal()">Batal</button>
                <button type="submit" class="btn-m-save"><i class="fa-solid fa-check" style="margin-right:0.4rem;"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL KONFIRMASI HAPUS ANGGOTA ===== -->
<div class="modal-overlay" id="modalDeleteAnggota" onclick="if(event.target===this) closeDeleteAnggotaModal()">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-hdr" style="background: linear-gradient(90deg, #7f1d1d, #991b1b);">
            <div class="modal-ttl"><i class="fa-solid fa-triangle-exclamation"></i>Konfirmasi Hapus</div>
            <button type="button" class="modal-cls" onclick="closeDeleteAnggotaModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formDeleteAnggota" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-bdy" style="text-align:center; padding:1.8rem 1.5rem 1.2rem;">
                <div style="width:54px; height:54px; border-radius:50%; background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; color:#f87171; font-size:1.4rem;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h4 style="font-family:'Poppins',sans-serif; font-size:1rem; font-weight:700; color:var(--text-primary); margin-bottom:0.5rem;">Hapus Anggota Ini?</h4>
                <p style="font-size:0.83rem; color:var(--text-secondary); line-height:1.5; margin-bottom:0.8rem;">
                    Apakah Anda yakin ingin menghapus data <strong id="delete_nama_text" style="color:#f87171;"></strong> (<span id="delete_nim_text"></span>)?
                </p>
                <p style="font-size:0.75rem; color:#fca5a5; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.18); border-radius:8px; padding:0.6rem 0.8rem; line-height:1.4;">
                    <i class="fa-solid fa-circle-exclamation" style="color:#f87171; margin-right:4px;"></i>
                    Perhatian: Seluruh riwayat absensi terkait anggota ini juga akan dihapus permanen!
                </p>
            </div>
            <div class="modal-ftr" style="justify-content:center; gap:0.8rem; padding:1rem 1.5rem 1.3rem;">
                <button type="button" class="btn-m-cancel" onclick="closeDeleteAnggotaModal()">Batal</button>
                <button type="submit" class="btn-m-delete"><i class="fa-solid fa-trash-can" style="margin-right:0.4rem;"></i>Hapus Sekarang</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL GANTI PASSWORD ===== -->
<div class="modal-overlay" id="modalGantiPassword" onclick="if(event.target===this) closeModalGantiPassword()">
    <div class="modal-box" style="max-width:440px;">
        <div class="modal-hdr" style="background: linear-gradient(90deg, #0f274a, #1d4ed8);">
            <div class="modal-ttl"><i class="fa-solid fa-shield-halved"></i>Ganti Username & Password</div>
            <button type="button" class="modal-cls" onclick="closeModalGantiPassword()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.change_password') }}" method="POST">
            @csrf
            <div class="modal-bdy">
                <div class="modal-grp">
                    <label class="modal-lbl" for="pw_password_lama">Password Saat Ini</label>
                    <div style="position:relative;">
                        <input type="password" class="modal-input" id="pw_password_lama" name="password_lama" placeholder="Masukkan password saat ini..." required style="padding-right:2.8rem;">
                        <button type="button" onclick="toggleModalPw('pw_password_lama', this)" style="position:absolute; right:0.8rem; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748b; cursor:pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="pw_username_baru">Username Baru</label>
                    <input type="text" class="modal-input" id="pw_username_baru" name="username_baru" value="{{ session('admin_username', 'admin') }}" placeholder="Contoh: admin" required autocomplete="off">
                    <p class="modal-hint"><i class="fa-solid fa-circle-info" style="color:#38bdf8; margin-right:4px;"></i>Bisa tetap pakai username lama atau buat baru.</p>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="pw_password_baru">Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" class="modal-input" id="pw_password_baru" name="password_baru" placeholder="Minimal 4 karakter..." required style="padding-right:2.8rem;">
                        <button type="button" onclick="toggleModalPw('pw_password_baru', this)" style="position:absolute; right:0.8rem; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748b; cursor:pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="pw_password_baru_confirmation">Konfirmasi Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" class="modal-input" id="pw_password_baru_confirmation" name="password_baru_confirmation" placeholder="Ketik ulang password baru..." required style="padding-right:2.8rem;">
                        <button type="button" onclick="toggleModalPw('pw_password_baru_confirmation', this)" style="position:absolute; right:0.8rem; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748b; cursor:pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-ftr">
                <button type="button" class="btn-m-cancel" onclick="closeModalGantiPassword()">Batal</button>
                <button type="submit" class="btn-m-save"><i class="fa-solid fa-key" style="margin-right:0.4rem;"></i>Simpan Kredensial</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-dismiss alerts
    setTimeout(() => {
        const f = document.querySelector('.flash-msg');
        if (f) { f.style.transition = 'opacity 0.5s'; f.style.opacity = '0'; setTimeout(() => f.remove(), 500); }
        const err = document.querySelector('.flash-error');
        if (err) { err.style.transition = 'opacity 0.5s'; err.style.opacity = '0'; setTimeout(() => err.remove(), 500); }
    }, 5000);

    // Edit Modal functions
    function openEditAnggotaModal(id, nomor_induk, nama, peran) {
        const form = document.getElementById('formEditAnggota');
        form.action = "{{ url('/admin/anggota') }}/" + id;
        document.getElementById('edit_nomor_induk').value = nomor_induk;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_peran').value = peran;
        document.getElementById('modalEditAnggota').classList.add('show');
    }

    function closeEditAnggotaModal() {
        document.getElementById('modalEditAnggota').classList.remove('show');
    }

    // Delete Modal functions
    function openDeleteAnggotaModal(id, nama, nomor_induk) {
        const form = document.getElementById('formDeleteAnggota');
        form.action = "{{ url('/admin/anggota') }}/" + id;
        document.getElementById('delete_nama_text').textContent = nama;
        document.getElementById('delete_nim_text').textContent = nomor_induk;
        document.getElementById('modalDeleteAnggota').classList.add('show');
    }

    function closeDeleteAnggotaModal() {
        document.getElementById('modalDeleteAnggota').classList.remove('show');
    }

    // Ganti Password Modal functions
    function openModalGantiPassword() {
        document.getElementById('modalGantiPassword').classList.add('show');
    }

    function closeModalGantiPassword() {
        document.getElementById('modalGantiPassword').classList.remove('show');
    }

    function toggleModalPw(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-solid fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa-solid fa-eye';
        }
    }
</script>
</body>
</html>