<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffSdm extends Model
{
    protected $table = 'staff_sdm';

    protected $fillable = [
        'nama',
        'jabatan',
        'email',
        'foto',
        'nomor_handphone',
        'spesialisasi_id',
    ];

    public function spesialisasi(): BelongsTo
    {
        return $this->belongsTo(Spesialisasi::class);
    }
}
