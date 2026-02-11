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
<<<<<<< HEAD
        $nilai = [];
        if (!empty($this->bahasa_indonesia)) $nilai[] = $this->bahasa_indonesia;
        if (!empty($this->matematika)) $nilai[] = $this->matematika;
        if (!empty($this->pendidikan_pancasila)) $nilai[] = $this->pendidikan_pancasila;
        if (!empty($this->alquran_hadist)) $nilai[] = $this->alquran_hadist;

        return count($nilai) > 0 ? array_sum($nilai) / count($nilai) : 0;
=======
        $totalNilai = 0;
        $jumlahMapel = 0;

        // 1. Ambil dari mapel dinamis (tabel raport_mapel_nilai)
        $dinamis = $this->mapelNilai;
        if ($dinamis->isNotEmpty()) {
            foreach ($dinamis as $mn) {
                if ($mn->nilai !== null) {
                    $totalNilai += (float) $mn->nilai;
                    $jumlahMapel++;
                }
            }
        }

        return $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
>>>>>>> 181316f8c3a15389bc8238409e5a1cddc033c03f
    }
}
