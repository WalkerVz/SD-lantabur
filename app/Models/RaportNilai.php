<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'ipas',
        'olahraga',
        'alquran_hadist',
        'catatan_wali',
    ];

    public static function mapelList(): array
    {
        return [
            'bahasa_indonesia' => 'Bahasa Indonesia',
            'matematika' => 'Matematika',
            'pendidikan_pancasila' => 'Pendidikan Pancasila',
            'ipas' => 'IPAS',
            'olahraga' => 'Olahraga',
            'alquran_hadist' => "Al-Qur'an Hadist",
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
