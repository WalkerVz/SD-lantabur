<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTahunAjaran extends Model
{
    protected $table = 'master_tahun_ajaran';

    protected $fillable = ['nama', 'is_aktif', 'urutan'];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public static function getAktif(): ?string
    {
        $row = static::where('is_aktif', true)->first();

        return $row?->nama;
    }

    public static function getListForDropdown(): array
    {
        $fromMaster = static::orderBy('urutan')->orderByDesc('nama')->pluck('nama')->all();
        $fromEnrollment = \App\Models\Enrollment::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran')->all();
        $fromRaport = \App\Models\RaportNilai::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran')->all();
        
        $merged = array_unique(array_merge($fromMaster, $fromEnrollment, $fromRaport));
        rsort($merged);

        if (empty($merged)) {
            return [static::getFallback()];
        }

        return array_values($merged);
    }

    /**
     * Get fallback tahun ajaran based on academic year cycle (July-June)
     * 
     * @return string Format: YY/YY (e.g., "25/26")
     */
    public static function getFallback(): string
    {
        $y = (int) date('y');
        $m = (int) date('n');
        
        // Academic year runs from July to June
        // If current month is Jan-Jun, we're in the second half of academic year
        if ($m < 7) {
            return ($y - 1) . '/' . $y; // e.g., if Feb 26, return 25/26
        }
        
        // If current month is Jul-Dec, we're in the first half of new academic year
        return $y . '/' . ($y + 1); // e.g., if Aug 26, return 26/27
    }
}
