<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;
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
        'spp',
        'biaya_seragam',
        'biaya_sarana_prasarana',
        'biaya_kegiatan_tahunan',
    ];

    /**
     * Mapping dari jenis_pembayaran ke kolom biaya siswa.
     * Untuk SPP gunakan spp (biaya per bulan).
     */
    public static array $BIAYA_JENIS_MAP = [
        'spp'                => 'spp',
        'seragam'            => 'biaya_seragam',
        'sarana_prasarana'   => 'biaya_sarana_prasarana',
        'kegiatan_tahunan'   => 'biaya_kegiatan_tahunan',
    ];

    /**
     * Ambil total tagihan untuk jenis pembayaran tertentu berdasarkan data siswa.
     */
    public function getTotalTagihan(string $jenis): int
    {
        $col = self::$BIAYA_JENIS_MAP[$jenis] ?? null;
        if (!$col) return 0;
        return (int) ($this->{$col} ?? 0);
    }

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

    public function raportTahfidz(): HasMany
    {
        return $this->hasMany(RaportTahfidz::class);
    }

    public function raportJilid(): HasMany
    {
        return $this->hasMany(RaportJilid::class);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Relationship to MasterKelas based on tingkat
     */
    public function kelasMaster()
    {
        return $this->belongsTo(\App\Models\MasterKelas::class, 'kelas', 'tingkat');
    }

    /**
     * Get formatted class name with surah name
     */
    public static function getNamaKelas($kelas): string
    {
        static $cache = [];

        if (!isset($cache[$kelas])) {
            $master = \App\Models\MasterKelas::where('tingkat', $kelas)->first();
            $cache[$kelas] = ($master && $master->nama_surah)
                ? "Kelas {$kelas} {$master->nama_surah}"
                : "Kelas {$kelas}";
        }

        return $cache[$kelas];
    }
}
