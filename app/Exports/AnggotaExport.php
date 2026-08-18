<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnggotaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Anggota::query();

        // Filter berdasarkan Nama atau Nomor Induk
        if (!empty($this->request->search)) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_induk', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan Peran
        if (!empty($this->request->peran)) {
            $query->where('peran', $this->request->peran);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Induk (NIM/NIP)',
            'Nama Lengkap',
            'Status / Peran',
            'Tanggal Registrasi',
        ];
    }

    private $rowNumber = 0;

    public function map($anggota): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            "'" . $anggota->nomor_induk, // Menggunakan petik agar format NIM/NIP tidak menjadi angka scientific di Excel
            $anggota->nama,
            $anggota->peran,
            $anggota->created_at->format('d/m/Y H:i') . ' WIB',
        ];
    }
}