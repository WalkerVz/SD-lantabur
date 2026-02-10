<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaportPraktik extends Model
{
    protected $table = 'raport_praktik';

    protected $fillable = [
        'raport_id',
        'section',
        'kategori',
        'kkm',
        'nilai',
        'deskripsi',
    ];

    public function raportNilai(): BelongsTo
    {
        return $this->belongsTo(RaportNilai::class, 'raport_id');
    }
}
