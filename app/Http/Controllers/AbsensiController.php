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

    // Helper: Ambil kredensial admin (dari file JSON atau fallback)
    private function getAdminCredentials()
    {
        $path = storage_path('app/admin_credential.json');
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (!empty($data['username']) && !empty($data['password'])) {
                return $data;
            }
        }

        return [
            'username' => env('ADMIN_USERNAME', 'admin'),
            'password' => env('ADMIN_PASSWORD', 'admin123'),
        ];
    }

    // Helper: Verifikasi password (mendukung Hash bcrypt maupun plaintext fallback)
    private function verifyAdminPassword($inputPassword, $storedPassword)
    {
        if (str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$')) {
            return \Illuminate\Support\Facades\Hash::check($inputPassword, $storedPassword);
        }
        return hash_equals($storedPassword, $inputPassword);
    }

    // Proses Verifikasi Username & Password
    public function loginProcess(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $creds = $this->getAdminCredentials();

        // Cek username DAN password sekaligus (hindari user enumeration)
        if ($request->username === $creds['username'] && $this->verifyAdminPassword($request->password, $creds['password'])) {
            session([
                'admin_authenticated' => true,
                'admin_username'      => $request->username,
                'admin_login_at'      => now()->toDateTimeString(),
            ]);
            return redirect()->route('absensi.admin')->with('success', 'Selamat datang, ' . $request->username . '! Anda berhasil masuk.');
        }

        // Delay kecil untuk mencegah brute-force
        sleep(1);

        return redirect()->back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password yang Anda masukkan salah!');
    }

    // Update Kredensial / Password Admin dari Dashboard
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama'          => 'required',
            'username_baru'          => 'required|string|min:3|max:50',
            'password_baru'          => 'required|string|min:4|confirmed',
        ], [
            'password_lama.required'  => 'Password saat ini wajib diisi.',
            'username_baru.required'  => 'Username baru wajib diisi.',
            'username_baru.min'       => 'Username minimal 3 karakter.',
            'password_baru.required'  => 'Password baru wajib diisi.',
            'password_baru.min'       => 'Password baru minimal 4 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $creds = $this->getAdminCredentials();

        if (!$this->verifyAdminPassword($request->password_lama, $creds['password'])) {
            return redirect()->back()->withErrors(['password_lama' => 'Password saat ini yang Anda masukkan salah!']);
        }

        $newCreds = [
            'username'   => $request->username_baru,
            'password'   => \Illuminate\Support\Facades\Hash::make($request->password_baru),
            'updated_at' => now()->toDateTimeString(),
        ];

        // Simpan ke storage/app/admin_credential.json
        file_put_contents(storage_path('app/admin_credential.json'), json_encode($newCreds, JSON_PRETTY_PRINT));

        // Update session username aktif
        session(['admin_username' => $request->username_baru]);

        return redirect()->back()->with('success', 'Kredensial admin (username & password) berhasil diperbarui!');
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

    // Update Data Anggota
    public function updateAnggota(Request $request, $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);

        $validated = $request->validate([
            'nomor_induk' => 'required|string|unique:anggotas,nomor_induk,' . $id,
            'nama'        => 'required|string|max:255',
            'peran'       => 'required|in:Mahasiswa,Dosen/Staff,Umum',
        ], [
            'nomor_induk.required' => 'NIM/NIP/NIS wajib diisi.',
            'nomor_induk.unique'   => 'NIM/NIP/NIS ini sudah dipakai anggota lain.',
            'nama.required'        => 'Nama lengkap wajib diisi.',
            'peran.required'       => 'Status/peran wajib dipilih.',
        ]);

        $anggota->update($validated);

        return redirect()->route('absensi.admin.anggota')
            ->with('success', "Data anggota {$anggota->nama} berhasil diperbarui!");
    }

    // Hapus Data Anggota
    public function destroyAnggota($id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        $nama    = $anggota->nama;

        // Hapus juga semua riwayat absensi anggota ini
        $anggota->absensis()->delete();
        $anggota->delete();

        return redirect()->route('absensi.admin.anggota')
            ->with('success', "Anggota {$nama} beserta seluruh riwayat absensinya berhasil dihapus.");
    }

    // Update Data Kehadiran / Absensi
    public function updateAbsensi(Request $request, $id)
    {
        $absensi = \App\Models\Absensi::findOrFail($id);

        $request->validate([
            'nomor_induk' => 'required|exists:anggotas,nomor_induk',
            'tanggal'     => 'required|date',
            'jam'         => 'required',
        ], [
            'nomor_induk.required' => 'NIM / Nomor Induk wajib diisi.',
            'nomor_induk.exists'   => 'NIM / Nomor Induk tidak ditemukan di sistem.',
            'tanggal.required'     => 'Tanggal wajib diisi.',
            'jam.required'         => 'Jam wajib diisi.',
        ]);

        $anggota = \App\Models\Anggota::where('nomor_induk', $request->nomor_induk)->first();
        $createdAt = $request->tanggal . ' ' . $request->jam . ':00';

        $absensi->anggota_id = $anggota->id;
        $absensi->created_at = $createdAt;
        $absensi->updated_at = now();
        $absensi->save();

        return redirect()->route('absensi.admin')
            ->with('success', "Data kehadiran untuk {$anggota->nama} berhasil diperbarui!");
    }

    // Hapus Data Kehadiran / Absensi
    public function destroyAbsensi($id)
    {
        $absensi = \App\Models\Absensi::with('anggota')->findOrFail($id);
        $nama = $absensi->anggota->nama ?? 'Pengunjung';
        $waktu = $absensi->created_at->format('d/m/Y H:i');

        $absensi->delete();

        return redirect()->route('absensi.admin')
            ->with('success', "Data kehadiran {$nama} pada {$waktu} WIB berhasil dihapus.");
    }
}