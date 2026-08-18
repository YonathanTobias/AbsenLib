<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Absensi;
use App\Exports\AbsensiExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnggotaExport;

class AbsensiController extends Controller
{
    // Halaman Form Absensi Utama
    public function index()
    {
        $absensi = Absensi::with('anggota')->latest()->take(10)->get();
        return view('absensi.index', compact('absensi'));
    }

    // Proses Absen (Hanya Masukkan NIM/NIP)
    public function store(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required|string',
        ], [
            'nomor_induk.required' => 'Nomor Induk (NIM/NIP) wajib diisi.',
        ]);

        // Cari anggota berdasarkan nomor_induk
        $anggota = Anggota::where('nomor_induk', $request->nomor_induk)->first();

        // Jika nomor_induk belum terdaftar
        if (!$anggota) {
            return redirect()->back()
                ->withInput()
                ->with('error_not_found', 'NIM/NIP tidak ditemukan. Silakan registrasi terlebih dahulu.');
        }

        // Catat Absensi
        Absensi::create([
            'anggota_id' => $anggota->id,
        ]);

        return redirect()->route('absensi.index')
            ->with('success', "Selamat Datang, {$anggota->nama}! Absensi Anda berhasil dicatat.");
    }

    // Process Registrasi Anggota Baru
    public function registerStore(Request $request)
    {
        $validated = $request->validate([
        'nomor_induk' => 'required|string|unique:anggotas,nomor_induk',
        'nama'        => 'required|string|max:255',
        // Opsi validasi peran diperbarui:
        'peran'       => 'required|in:Mahasiswa,Dosen/Staff,Umum',
    ], [
        'nomor_induk.required' => 'NIM/NIP/NIS wajib diisi.',
        'nomor_induk.unique'   => 'NIM/NIP/NIS ini sudah terdaftar sebelumnya.',
        'nama.required'        => 'Nama lengkap wajib diisi.',
        'peran.required'       => 'Pilih status/peran Anda.',
    ]);

    $anggota = Anggota::create($validated);

    Absensi::create([
        'anggota_id' => $anggota->id,
    ]);

    return redirect()->route('absensi.index')
        ->with('success', "Registrasi berhasil! Absensi untuk {$anggota->nama} telah dicatat.");
    }

    // Rekap Admin
    public function admin(Request $request)
    {
        $query = Absensi::with('anggota');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_induk', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('tgl')) {
            $query->whereDate('created_at', $request->tgl);
        }

        $absensi = $query->latest()->get();
        $totalData = $absensi->count();

        return view('absensi.admin', compact('absensi', 'totalData'));
    }

    // Download Excel
    public function export(Request $request)
    {
        $namaFile = 'rekap_pengunjung_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new AbsensiExport($request), $namaFile);
    }

    // Halaman Kelola Data Anggota (Admin)
    public function anggota(Request $request)
    {
        $query = \App\Models\Anggota::query();

        // Filter berdasarkan Nama atau Nomor Induk
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('nomor_induk', 'LIKE', "%{$search}%");
            });
        }

    // Filter berdasarkan Peran
    if ($request->filled('peran')) {
        $query->where('peran', $request->peran);
    }

    $anggotas = $query->latest()->get();
    $totalAnggota = $anggotas->count();

    return view('absensi.admin_anggota', compact('anggotas', 'totalAnggota'));
}

    // Tampilkan Form Input Password
    public function loginForm()
    {
        if (session('admin_authenticated')) {
            return redirect()->route('absensi.admin');
        }
        return view('absensi.admin_login');
    }

    // Proses Verifikasi Password
    public function loginProcess(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ], [
            'password.required' => 'Password wajib diisi.',
        ]);

        // SET PASSWORD ADMIN DI SINI (Misal: admin123)
        $passwordBenar = 'admin123';

        if ($request->password === $passwordBenar) {
            session(['admin_authenticated' => true]);
            return redirect()->route('absensi.admin')->with('success', 'Berhasil masuk sebagai Admin!');
        }

        return redirect()->back()->with('error', 'Password yang Anda masukkan salah!');
    }

    // Logout Admin
    public function logout()
    {
        session()->forget('admin_authenticated');
        return redirect()->route('absensi.index')->with('success', 'Berhasil keluar dari mode Admin.');
    }

    // Tambahkan method ini di dalam AbsensiController:
    public function exportAnggota(Request $request)
    {
        $namaFile = 'master_data_anggota_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new AnggotaExport($request), $namaFile);
    }

    // Proses Simpan Absensi Manual oleh Admin
    public function storeManual(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required|exists:anggotas,nomor_induk',
            'tanggal'     => 'required|date',
            'jam'         => 'required',
        ], [
            'nomor_induk.required' => 'NIM / Nomor Induk wajib diisi.',
            'nomor_induk.exists'   => 'NIM / Nomor Induk belum terdaftar di sistem. Silakan daftarkan dulu.',
            'tanggal.required'     => 'Tanggal wajib diisi.',
            'jam.required'         => 'Jam wajib diisi.',
        ]);

        // Cari data anggota berdasarkan nomor induk
        $anggota = \App\Models\Anggota::where('nomor_induk', $request->nomor_induk)->first();

        // Gabungkan tanggal dan jam menjadi format datetime (YYYY-MM-DD HH:MM:SS)
        $createdAt = $request->tanggal . ' ' . $request->jam . ':00';

        // Simpan data absensi dengan waktu kustom
        \App\Models\Absensi::create([
            'anggota_id' => $anggota->id,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        return redirect()->route('absensi.admin')
            ->with('success', "Kehadiran untuk {$anggota->nama} ({$anggota->nomor_induk}) berhasil ditambahkan secara manual!");
    }
}