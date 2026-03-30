<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SdmExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function __construct(
        protected Collection $rows
    ) {}

    public function collection(): Collection
    {
        return $this->rows->map(function ($r) {
            return [
                $r->nama ?? '',
                $r->jabatan ?? '',
                $r->bidang_studi ?? '',
                $r->niy ?? '',
                $r->email ?? '',
                $r->nomor_handphone ?? '',
                $r->jenis_kelamin ?? '',
                $r->tempat_lahir ?? '',
                $r->tanggal_lahir ? \Carbon\Carbon::parse($r->tanggal_lahir)->format('Y-m-d') : '',
                $r->agama ?? '',
                $r->alamat ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'Jabatan', 'Bidang Studi', 'NIY', 'Email', 'Nomor HP', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF47663D'],
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            'A1:K1' => ['font' => ['color' => ['argb' => 'FFFFFFFF']]],
            'A:K' => [
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
        return [
            'A' => 30, 'B' => 24, 'C' => 18, 'D' => 16,
            'E' => 28, 'F' => 16, 'G' => 14, 'H' => 18,
            'I' => 14, 'J' => 12, 'K' => 40,
        ];
    }
}
