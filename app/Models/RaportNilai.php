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
        'bahasa_indonesia',
        'matematika',
        'pendidikan_pancasila',
        'alquran_hadist',
        'deskripsi_pai',
        'deskripsi_literasi',
        'deskripsi_sains',
        'deskripsi_adab',
        'catatan_wali',
        'sakit',
        'izin',
        'tanpa_keterangan',
    ];

    public static function mapelList(): array
    {
        return [
            'bahasa_indonesia' => 'Bahasa Indonesia',
            'matematika' => 'Matematika',
            'pendidikan_pancasila' => 'Pendidikan Pancasila',
            'alquran_hadist' => "Al-Qur'an Hadist",
        ];
    }

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
        $nilai = [];
        if (!empty($this->bahasa_indonesia)) $nilai[] = $this->bahasa_indonesia;
        if (!empty($this->matematika)) $nilai[] = $this->matematika;
        if (!empty($this->pendidikan_pancasila)) $nilai[] = $this->pendidikan_pancasila;
        if (!empty($this->alquran_hadist)) $nilai[] = $this->alquran_hadist;

        return count($nilai) > 0 ? array_sum($nilai) / count($nilai) : 0;
    }
}
