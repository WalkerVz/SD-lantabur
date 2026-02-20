<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'kelas',
        'nis',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'agama',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function raportNilai(): HasMany
    {
        return $this->hasMany(RaportNilai::class);
    }

    public function infoPribadi(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(InfoPribadiSiswa::class);
    }

    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get formatted class name with surah name
     */
    public static function getNamaKelas(int $kelas): string
    {
        $master = \App\Models\MasterKelas::where('tingkat', $kelas)->first();
        if ($master && $master->nama_surah) {
            return "Kelas {$kelas} {$master->nama_surah}";
        }

        return "Kelompok Belajar {$kelas}";
    }
}
