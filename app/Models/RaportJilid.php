<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaportJilid extends Model
{
    protected $table = 'raport_jilid';
    protected $fillable = [
        'siswa_id', 'tahun_ajaran', 'semester',
        'jilid', 'deskripsi', 'guru', 'materi',
    ];
    protected $casts = ['materi' => 'array'];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
