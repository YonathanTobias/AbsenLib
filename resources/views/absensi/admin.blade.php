<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran — Admin Perpustakaan STIKes Panti Waluya</title>
    <meta name="description" content="Dashboard admin untuk melihat rekap kehadiran pengunjung perpustakaan STIKes Panti Waluya Malang.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #4f46e5;
            --secondary: #7c3aed;
            --accent: #06b6d4;
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

        /* ===== SIDEBAR/TOPBAR LAYOUT ===== */
        .layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #090e1a;
            border-right: 1px solid var(--dark-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform 0.3s;
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
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            color: #fff;
            flex-shrink: 0;
        }
        .sidebar-logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }
        .sidebar-logo-sub {
            font-size: 0.65rem;
            font-weight: 400;
            color: var(--text-muted);
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.2rem 0.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .sidebar-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            padding: 0.5rem 0.7rem 0.3rem;
            margin-top: 0.5rem;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.65rem 0.9rem;
            border-radius: 10px;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: var(--text-primary); }
        .nav-link.active {
            background: linear-gradient(90deg, rgba(79,70,229,0.2), rgba(124,58,237,0.1));
            color: #a5b4fc;
            border: 1px solid rgba(79,70,229,0.2);
            font-weight: 600;
        }
        .nav-link .nav-icon { width: 18px; text-align: center; font-size: 0.88rem; }

        .sidebar-footer {
            padding: 1rem 0.8rem;
            border-top: 1px solid var(--dark-border);
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }
        .sidebar-footer-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 0.9rem;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar-footer-back { color: var(--text-secondary); }
        .sidebar-footer-back:hover { background: rgba(255,255,255,0.05); color: var(--text-primary); }
        .sidebar-logout-form { width: 100%; }
        .sidebar-logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 0.9rem;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.15);
            color: #f87171;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .sidebar-logout-btn:hover { background: rgba(239,68,68,0.2); }

        /* ===== MAIN AREA ===== */
        .main-area {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: rgba(15,23,42,0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--dark-border);
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-left h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .topbar-left p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
        .admin-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(79,70,229,0.12);
            border: 1px solid rgba(79,70,229,0.2);
            border-radius: 50px;
            padding: 0.4rem 0.9rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: #a5b4fc;
        }
        .admin-badge .admin-avatar {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
            color: #fff;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content { padding: 2rem; }

        /* Flash message */
        .flash-msg {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: 12px;
            padding: 0.85rem 1rem;
            color: #6ee7b7;
            font-size: 0.84rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }

        /* Stat Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            padding: 1.2rem 1.3rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--stat-accent, linear-gradient(90deg, #4f46e5, #7c3aed));
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .stat-icon-wrap {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .stat-info {}
        .stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.2rem;
        }
        .stat-label { font-size: 0.73rem; color: var(--text-muted); font-weight: 500; }

        /* Filter Card */
        .filter-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.2rem;
        }
        .filter-form {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-input-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        .filter-input-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            pointer-events: none;
        }
        .filter-input {
            width: 100%;
            padding: 0.65rem 0.9rem 0.65rem 2.5rem;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            outline: none;
            transition: all 0.2s;
        }
        .filter-input:focus {
            border-color: var(--primary);
            background: rgba(79,70,229,0.06);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .filter-input::placeholder { color: var(--text-muted); }
        .filter-date {
            padding: 0.65rem 0.9rem;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            outline: none;
            transition: all 0.2s;
            min-width: 160px;
            color-scheme: dark;
        }
        .filter-date:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .filter-btn-group { display: flex; gap: 0.5rem; }
        .btn-filter {
            display: flex; align-items: center; gap: 0.4rem;
            padding: 0.65rem 1.1rem;
            font-size: 0.83rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s;
            white-space: nowrap;
        }
        .btn-filter-primary {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            color: #fff;
        }
        .btn-filter-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(79,70,229,0.35); }
        .btn-filter-reset {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-secondary);
            text-decoration: none;
        }
        .btn-filter-reset:hover { background: rgba(255,255,255,0.1); color: var(--text-primary); }
        .btn-filter-excel {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.2);
            color: #6ee7b7;
            text-decoration: none;
        }
        .btn-filter-excel:hover { background: rgba(16,185,129,0.2); transform: translateY(-1px); }
        .btn-filter-manual {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            color: #fff;
        }
        .btn-filter-manual:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(79,70,229,0.35); }

        /* Table Card */
        .table-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            overflow: hidden;
        }
        .table-card-header {
            padding: 1rem 1.3rem;
            border-bottom: 1px solid var(--dark-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table-card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .table-card-title i { color: #818cf8; }
        .result-count {
            font-size: 0.75rem;
            color: var(--text-muted);
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--dark-border);
            border-radius: 50px;
            padding: 0.2rem 0.7rem;
        }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th {
            padding: 0.75rem 1rem;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--dark-border);
            background: rgba(255,255,255,0.02);
            text-align: left;
        }
        .data-table thead th:first-child { padding-left: 1.3rem; }
        .data-table thead th:last-child { padding-right: 1.3rem; }

        .data-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: background 0.18s;
        }
        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: rgba(79,70,229,0.06); }
        .data-table td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            font-size: 0.85rem;
        }
        .data-table td:first-child { padding-left: 1.3rem; }
        .data-table td:last-child { padding-right: 1.3rem; }

        /* Row number */
        .row-num {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: rgba(79,70,229,0.12);
            border: 1px solid rgba(79,70,229,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: #818cf8;
        }

        /* Datetime cell */
        .dt-cell { display: flex; flex-direction: column; gap: 0.1rem; }
        .dt-date { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }
        .dt-time { font-size: 0.73rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.3rem; }

        /* Name cell */
        .name-cell { display: flex; align-items: center; gap: 0.65rem; }
        .avatar-sm {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .name-bold { font-weight: 600; color: var(--text-primary); }

        /* NIM chip */
        .nim-chip {
            display: inline-block;
            padding: 0.2rem 0.65rem;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 6px;
            font-size: 0.78rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #a5b4fc;
        }

        /* Badge peran */
        .badge-peran {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-mahasiswa { background: rgba(6,182,212,0.12); color: #67e8f9; border: 1px solid rgba(6,182,212,0.2); }
        .badge-dosen     { background: rgba(16,185,129,0.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.2); }
        .badge-umum      { background: rgba(148,163,184,0.1); color: #94a3b8; border: 1px solid rgba(148,163,184,0.15); }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-icon-wrap {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: rgba(79,70,229,0.1);
            border: 1px solid rgba(79,70,229,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            color: #818cf8;
            margin: 0 auto 1rem;
        }
        .empty-title { font-family: 'Poppins',sans-serif; font-size: 1rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.4rem; }
        .empty-sub { font-size: 0.82rem; color: var(--text-muted); }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
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
            background: linear-gradient(90deg, #1e1b4b, #312e81);
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
        .modal-input:focus { border-color: #6366f1; background:rgba(79,70,229,0.07); box-shadow:0 0 0 3px rgba(79,70,229,0.12); }
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
            color:#fff; background:linear-gradient(90deg,#4f46e5,#7c3aed);
            border:none; border-radius:10px; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all 0.25s;
        }
        .btn-m-save:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(79,70,229,0.4); }

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
        .btn-m-delete {
            padding:0.6rem 1.3rem; font-size:0.83rem; font-weight:700;
            color:#fff; background:linear-gradient(90deg,#dc2626,#ef4444);
            border:none; border-radius:10px; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all 0.25s;
        }
        .btn-m-delete:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(239,68,68,0.4); }

        .flash-error { display:flex; align-items:center; gap:0.65rem; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:12px; padding:0.85rem 1rem; color:#fca5a5; font-size:0.84rem; font-weight:500; margin-bottom:1.5rem; animation:slideDown 0.3s ease; }

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
            background: rgba(79,70,229,0.15);
            border-color: rgba(79,70,229,0.3);
            color: #a5b4fc;
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
            <a href="{{ route('absensi.admin') }}" class="nav-link active">
                <i class="fa-solid fa-list-check nav-icon"></i>
                Rekap Kehadiran
            </a>
            <a href="{{ route('absensi.admin.anggota') }}" class="nav-link">
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
                <i class="fa-solid fa-arrow-left" style="width:16px; text-align:center;"></i>
                Form Absensi
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket" style="width:16px; text-align:center;"></i>
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
                <h1>Rekap Kehadiran</h1>
                <p>{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="topbar-right">
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
                <div class="stat-card" style="--stat-accent: linear-gradient(90deg,#4f46e5,#7c3aed);">
                    <div class="stat-icon-wrap" style="background:rgba(79,70,229,0.15);">
                        <i class="fa-solid fa-users" style="color:#818cf8;"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalData }}</div>
                        <div class="stat-label">Total Data Ditemukan</div>
                    </div>
                </div>
                <div class="stat-card" style="--stat-accent: linear-gradient(90deg,#06b6d4,#3b82f6);">
                    <div class="stat-icon-wrap" style="background:rgba(6,182,212,0.15);">
                        <i class="fa-solid fa-calendar-day" style="color:#67e8f9;"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $absensi->filter(fn($a) => $a->created_at->isToday())->count() }}</div>
                        <div class="stat-label">Kehadiran Hari Ini</div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <form method="GET" action="{{ route('absensi.admin') }}">
                    <div class="filter-form">
                        <div class="filter-input-wrap">
                            <i class="fa-solid fa-magnifying-glass filter-input-icon"></i>
                            <input type="text" name="search" class="filter-input" placeholder="Cari nama atau NIM/NIP..." value="{{ request('search') }}">
                        </div>
                        <input type="date" name="tgl" class="filter-date" value="{{ request('tgl') }}">
                        <div class="filter-btn-group">
                            <button type="submit" class="btn-filter btn-filter-primary">
                                <i class="fa-solid fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('absensi.admin') }}" class="btn-filter btn-filter-reset" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                            <a href="{{ route('absensi.export', request()->query()) }}" class="btn-filter btn-filter-excel">
                                <i class="fa-solid fa-file-excel"></i> Excel
                            </a>
                            <button type="button" class="btn-filter btn-filter-manual" onclick="document.getElementById('modalTambahAbsen').classList.add('show')">
                                <i class="fa-solid fa-plus"></i> Absen Manual
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <div class="table-card-header">
                    <div class="table-card-title">
                        <i class="fa-solid fa-table-list"></i>
                        Data Kehadiran Pengunjung
                    </div>
                    <span class="result-count">{{ $totalData }} data</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Waktu Masuk</th>
                                <th>Nama Lengkap</th>
                                <th>Nomor Induk</th>
                                <th>Status / Peran</th>
                                <th style="width:100px; text-align:center;">Aksi</th>
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
                                    $colors = ['#4f46e5','#7c3aed','#0891b2','#059669','#dc2626','#d97706','#be185d'];
                                    $color = $colors[crc32($nama) % count($colors)];
                                    $badgeClass = match($peran) {
                                        'Mahasiswa'   => 'badge-mahasiswa',
                                        'Dosen/Staff' => 'badge-dosen',
                                        default       => 'badge-umum',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="row-num">{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="dt-cell">
                                            <span class="dt-date">{{ $item->created_at->format('d/m/Y') }}</span>
                                            <span class="dt-time"><i class="fa-regular fa-clock"></i>{{ $item->created_at->format('H:i') }} WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="name-cell">
                                            <div class="avatar-sm" style="background:{{ $color }};">{{ $initials }}</div>
                                            <span class="name-bold">{{ $nama }}</span>
                                        </div>
                                    </td>
                                    <td><span class="nim-chip">{{ $item->anggota->nomor_induk ?? '-' }}</span></td>
                                    <td><span class="badge-peran {{ $badgeClass }}">{{ $peran }}</span></td>
                                    <td>
                                        <div class="action-btn-group">
                                            <button type="button" class="btn-action btn-action-edit"
                                                onclick="openEditAbsenModal({{ $item->id }}, '{{ addslashes($item->anggota->nomor_induk ?? '') }}', '{{ $item->created_at->format('Y-m-d') }}', '{{ $item->created_at->format('H:i') }}')"
                                                title="Edit Kehadiran">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-action-delete"
                                                onclick="openDeleteAbsenModal({{ $item->id }}, '{{ addslashes($nama) }}', '{{ addslashes($item->anggota->nomor_induk ?? '-') }}', '{{ $item->created_at->format('d/m/Y H:i') }}')"
                                                title="Hapus Kehadiran">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon-wrap"><i class="fa-solid fa-folder-open"></i></div>
                                            <div class="empty-title">Data tidak ditemukan</div>
                                            <div class="empty-sub">Tidak ada data kehadiran yang sesuai filter.</div>
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

<!-- ===== MODAL TAMBAH ABSEN MANUAL ===== -->
<div class="modal-overlay" id="modalTambahAbsen" onclick="if(event.target===this) this.classList.remove('show')">
    <div class="modal-box">
        <div class="modal-hdr">
            <div class="modal-ttl"><i class="fa-solid fa-clock-rotate-left"></i>Tambah Kehadiran Manual</div>
            <button class="modal-cls" onclick="document.getElementById('modalTambahAbsen').classList.remove('show')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('absensi.admin.store_manual') }}" method="POST">
            @csrf
            <div class="modal-bdy">
                <div class="modal-grp">
                    <label class="modal-lbl" for="manual_nomor_induk">NIM / NIP / Nomor Induk</label>
                    <input type="text" class="modal-input" id="manual_nomor_induk" name="nomor_induk" placeholder="Masukkan NIM terdaftar..." required autocomplete="off">
                    <p class="modal-hint"><i class="fa-solid fa-circle-info" style="color:#818cf8; margin-right:4px;"></i>Pastikan NIM sudah terdaftar di Data Anggota.</p>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="manual_tanggal">Tanggal</label>
                    <input type="date" class="modal-input" id="manual_tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="manual_jam">Jam</label>
                    <input type="time" class="modal-input" id="manual_jam" name="jam" value="{{ date('H:i') }}" required>
                </div>
            </div>
            <div class="modal-ftr">
                <button type="button" class="btn-m-cancel" onclick="document.getElementById('modalTambahAbsen').classList.remove('show')">Batal</button>
                <button type="submit" class="btn-m-save"><i class="fa-solid fa-save" style="margin-right:0.4rem;"></i>Simpan Kehadiran</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL EDIT ABSEN ===== -->
<div class="modal-overlay" id="modalEditAbsen" onclick="if(event.target===this) closeEditAbsenModal()">
    <div class="modal-box">
        <div class="modal-hdr">
            <div class="modal-ttl"><i class="fa-solid fa-pen-to-square"></i>Edit Data Kehadiran</div>
            <button type="button" class="modal-cls" onclick="closeEditAbsenModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEditAbsen" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-bdy">
                <div class="modal-grp">
                    <label class="modal-lbl" for="edit_nomor_induk">NIM / NIP / Nomor Induk</label>
                    <input type="text" class="modal-input" id="edit_nomor_induk" name="nomor_induk" placeholder="Masukkan NIM terdaftar..." required autocomplete="off">
                    <p class="modal-hint"><i class="fa-solid fa-circle-info" style="color:#818cf8; margin-right:4px;"></i>Pastikan NIM sudah terdaftar di Data Anggota.</p>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="edit_tanggal">Tanggal</label>
                    <input type="date" class="modal-input" id="edit_tanggal" name="tanggal" required>
                </div>
                <div class="modal-grp">
                    <label class="modal-lbl" for="edit_jam">Jam</label>
                    <input type="time" class="modal-input" id="edit_jam" name="jam" required>
                </div>
            </div>
            <div class="modal-ftr">
                <button type="button" class="btn-m-cancel" onclick="closeEditAbsenModal()">Batal</button>
                <button type="submit" class="btn-m-save"><i class="fa-solid fa-check" style="margin-right:0.4rem;"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL KONFIRMASI HAPUS ABSEN ===== -->
<div class="modal-overlay" id="modalDeleteAbsen" onclick="if(event.target===this) closeDeleteAbsenModal()">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-hdr" style="background: linear-gradient(90deg, #7f1d1d, #991b1b);">
            <div class="modal-ttl"><i class="fa-solid fa-triangle-exclamation"></i>Konfirmasi Hapus Kehadiran</div>
            <button type="button" class="modal-cls" onclick="closeDeleteAbsenModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formDeleteAbsen" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-bdy" style="text-align:center; padding:1.8rem 1.5rem 1.2rem;">
                <div style="width:54px; height:54px; border-radius:50%; background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; color:#f87171; font-size:1.4rem;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h4 style="font-family:'Poppins',sans-serif; font-size:1rem; font-weight:700; color:var(--text-primary); margin-bottom:0.5rem;">Hapus Riwayat Kehadiran Ini?</h4>
                <p style="font-size:0.83rem; color:var(--text-secondary); line-height:1.5; margin-bottom:0.8rem;">
                    Apakah Anda yakin ingin menghapus data kehadiran <strong id="delete_absen_nama" style="color:#f87171;"></strong> (<span id="delete_absen_nim"></span>) pada <span id="delete_absen_waktu" style="color:#a5b4fc; font-weight:600;"></span> WIB?
                </p>
                <p style="font-size:0.75rem; color:#fca5a5; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.18); border-radius:8px; padding:0.6rem 0.8rem; line-height:1.4;">
                    <i class="fa-solid fa-circle-exclamation" style="color:#f87171; margin-right:4px;"></i>
                    Data riwayat kehadiran ini akan dihapus permanen dari sistem.
                </p>
            </div>
            <div class="modal-ftr" style="justify-content:center; gap:0.8rem; padding:1rem 1.5rem 1.3rem;">
                <button type="button" class="btn-m-cancel" onclick="closeDeleteAbsenModal()">Batal</button>
                <button type="submit" class="btn-m-delete"><i class="fa-solid fa-trash-can" style="margin-right:0.4rem;"></i>Hapus Sekarang</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL GANTI PASSWORD ===== -->
<div class="modal-overlay" id="modalGantiPassword" onclick="if(event.target===this) closeModalGantiPassword()">
    <div class="modal-box" style="max-width:440px;">
        <div class="modal-hdr" style="background: linear-gradient(90deg, #312e81, #4c1d95);">
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
                    <p class="modal-hint"><i class="fa-solid fa-circle-info" style="color:#818cf8; margin-right:4px;"></i>Bisa tetap pakai username lama atau buat baru.</p>
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

    // Edit Absen Modal functions
    function openEditAbsenModal(id, nomor_induk, tanggal, jam) {
        const form = document.getElementById('formEditAbsen');
        form.action = "{{ url('/admin/absensi') }}/" + id;
        document.getElementById('edit_nomor_induk').value = nomor_induk;
        document.getElementById('edit_tanggal').value = tanggal;
        document.getElementById('edit_jam').value = jam;
        document.getElementById('modalEditAbsen').classList.add('show');
    }

    function closeEditAbsenModal() {
        document.getElementById('modalEditAbsen').classList.remove('show');
    }

    // Delete Absen Modal functions
    function openDeleteAbsenModal(id, nama, nomor_induk, waktu) {
        const form = document.getElementById('formDeleteAbsen');
        form.action = "{{ url('/admin/absensi') }}/" + id;
        document.getElementById('delete_absen_nama').textContent = nama;
        document.getElementById('delete_absen_nim').textContent = nomor_induk;
        document.getElementById('delete_absen_waktu').textContent = waktu;
        document.getElementById('modalDeleteAbsen').classList.add('show');
    }

    function closeDeleteAbsenModal() {
        document.getElementById('modalDeleteAbsen').classList.remove('show');
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