<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RaportNilai extends Model
{
    protected $table = 'raport_nilai';

    protected $fillable = [
        'siswa_id',
        'kelas',
        'semester',
        'tahun_ajaran',
        'catatan_wali',
        'sakit',
        'izin',
        'tanpa_keterangan',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function praktik(): HasMany
    {
        return $this->hasMany(RaportPraktik::class, 'raport_id');
    }

    public function mapelNilai(): HasMany
    {
        return $this->hasMany(RaportMapelNilai::class, 'raport_id');
    }

    public function isLengkap(): bool
    {
        return $this->isLengkapUmum() && $this->isLengkapPraktik();
    }

    public function isLengkapUmum(): bool
    {
        // Cache active mapels per class
        static $activeMapelsCache = [];
        if (!isset($activeMapelsCache[$this->kelas])) {
            $activeMapelsCache[$this->kelas] = MasterMapel::where('kelas', $this->kelas)
                ->where('is_aktif', true)
                ->pluck('id')
                ->toArray();
        }
        $activeMapelIds = $activeMapelsCache[$this->kelas];

        $filledMapelIds = $this->mapelNilai
            ->filter(fn($m) => !is_null($m->nilai) && $m->nilai !== '')
            ->pluck('mapel_id')
            ->toArray();

        foreach ($activeMapelIds as $id) {
            if (!in_array($id, $filledMapelIds)) {
                return false;
            }
        }

        if ($this->sakit === null || $this->izin === null || $this->tanpa_keterangan === null) {
            return false;
        }

        return true;
    }

    public function isLengkapPraktik(): bool
    {
        // Cache master subjects to avoid repeated queries
        static $masterPraktikCache = null;
        if ($masterPraktikCache === null) {
            $masterPraktikCache = MasterPraktik::all(['section', 'kategori']);
        }

        foreach ($masterPraktikCache as $master) {
            $filled = $this->praktik->where('section', $master->section)
                ->where('kategori', $master->kategori)
                ->filter(fn($p) => !is_null($p->nilai) && $p->nilai !== '')
                ->first();

            if (!$filled) {
                return false;
            }
        }

        return true;
    }

    public function hitungRataRata(): float
    {
        $totalNilai = 0;
        $jumlahMapel = 0;

        // 1. Ambil dari mapel dinamis (tabel raport_mapel_nilai)
        // Pastikan load 'mapelNilai' agar tidak N+1 jika dipanggil di loop
        $dinamis = $this->mapelNilai; 
        
        if ($dinamis->isNotEmpty()) {
            foreach ($dinamis as $mn) {
                // Asumsi nilai tersimpan
                if ($mn->nilai !== null && $mn->nilai !== '') {
                    $totalNilai += (float) $mn->nilai;
                    $jumlahMapel++;
                }
            }
        }

        return $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
    }

    public function getStatusRataanAttribute(): array
    {
        $rataan = $this->hitungRataRata();
        if($rataan >= 85) return ['bg' => 'bg-green-50 border-green-100', 'text' => 'text-green-700', 'label' => 'text-green-500'];
        if($rataan >= 75) return ['bg' => 'bg-blue-50 border-blue-100', 'text' => 'text-blue-700', 'label' => 'text-blue-500'];
        if($rataan >= 65) return ['bg' => 'bg-amber-50 border-amber-100', 'text' => 'text-amber-700', 'label' => 'text-amber-500'];
        return ['bg' => 'bg-red-50 border-red-100', 'text' => 'text-red-700', 'label' => 'text-red-500'];
    }

    public function getStatusKehadiranAttribute(): array
    {
        $sakit = $this->sakit ?? 0;
        $izin = $this->izin ?? 0;
        $alfa = $this->tanpa_keterangan ?? 0;
        $totalKetidakhadiran = $sakit + $izin + $alfa;
        
        if($totalKetidakhadiran == 0) return ['bg' => 'bg-green-50 border-green-100', 'text' => 'text-green-700', 'label' => 'text-green-500'];
        if($totalKetidakhadiran <= 5) return ['bg' => 'bg-amber-50 border-amber-100', 'text' => 'text-amber-700', 'label' => 'text-amber-500'];
        return ['bg' => 'bg-red-50 border-red-100', 'text' => 'text-red-700', 'label' => 'text-red-500'];
    }
}
