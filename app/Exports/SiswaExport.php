<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function __construct(
        protected Collection $rows
    ) {}

    public function collection(): Collection
    {
        return $this->rows->map(function ($r) {
            $siswa = $r->siswa ?? $r;
            if (! is_object($siswa) || ! isset($siswa->nama)) {
                return ['', '', '', '', '', '', '', '', ''];
            }
            $kelas = $r->kelas ?? ($siswa->kelas ?? null);
            $tanggal = $siswa->tanggal_lahir ?? null;
            $tanggalStr = $tanggal ? (is_object($tanggal) ? $tanggal->format('d/m/Y') : (string) $tanggal) : '';
            return [
                $siswa->nama ?? '',
                $kelas ? "Kelas {$kelas}" : '',
                $siswa->nis ?? '',
                $siswa->nisn ?? '',
                $siswa->jenis_kelamin ?? '',
                $siswa->tempat_lahir ?? '',
                $tanggalStr,
                $siswa->alamat ?? '',
                $siswa->agama ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'Kelas', 'NIS', 'NISN', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Agama'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF47663D'],
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            'A1:I1' => ['font' => ['color' => ['argb' => 'FFFFFFFF']]],
            'A:I' => [
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFCCCCCC'],
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 30, 'B' => 10, 'C' => 14, 'D' => 14, 'E' => 14, 'F' => 18, 'G' => 14, 'H' => 35, 'I' => 12];
    }
}
