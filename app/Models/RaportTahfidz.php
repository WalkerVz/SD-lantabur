<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportTahfidz extends Model
{
    use HasFactory;

    protected $table = 'raport_tahfidz';

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran',
        'semester',
        'materi',
        'deskripsi',
        'guru'
    ];

    protected $casts = [
        'materi' => 'array',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
