<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TahunKelas extends Model
{
    protected $table = 'tahun_kelas';

    protected $fillable = ['tahun_ajaran', 'kelas', 'wali_kelas_id'];

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(StaffSdm::class, 'wali_kelas_id');
    }
}
