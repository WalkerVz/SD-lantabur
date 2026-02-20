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
        $activeMapelIds = MasterMapel::where('kelas', $this->kelas)
            ->where('is_aktif', true)
            ->pluck('id')
            ->toArray();

        if (empty($activeMapelIds)) {
            return true;
        }

        $filledMapelIds = $this->mapelNilai()
            ->whereNotNull('nilai')
            ->pluck('mapel_id')
            ->toArray();

        // Check if all active mapels are filled
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
                if ($mn->nilai !== null) {
                    $totalNilai += (float) $mn->nilai;
                    $jumlahMapel++;
                }
            }
        }

        return $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
    }
}
