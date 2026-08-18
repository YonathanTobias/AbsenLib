<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Absensi::with('anggota');

        if (!empty($this->request->search)) {
            $search = $this->request->search;
            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_induk', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($this->request->tgl)) {
            $query->whereDate('created_at', $this->request->tgl);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Waktu Masuk',
            'Nama Lengkap',
            'Nomor Induk',
            'Status / Peran',
        ];
    }

    private $rowNumber = 0;

    public function map($absensi): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $absensi->created_at->format('d/m/Y H:i') . ' WIB',
            $absensi->anggota->nama,
            "'" . $absensi->anggota->nomor_induk,
            $absensi->anggota->peran,
        ];
    }
}