<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKelas extends Model
{
    protected $table = 'master_kelas';
    
    // Hanya tingkat dan nama_surah - wali_kelas_id sudah dipindah ke TahunKelas
    protected $fillable = ['tingkat', 'nama_surah', 'wali_kelas_id'];

    public function waliKelas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StaffSdm::class, 'wali_kelas_id');
    }
}
