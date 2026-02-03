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
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'agama',
        'spesialisasi_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function spesialisasi(): BelongsTo
    {
        return $this->belongsTo(Spesialisasi::class);
    }
}
