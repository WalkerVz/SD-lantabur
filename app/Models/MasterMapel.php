<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMapel extends Model
{
    protected $table = 'master_mapel';

    protected $fillable = [
        'nama',
        'kelas',
        'kkm',
        'urutan',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function nilai(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RaportMapelNilai::class, 'mapel_id');
    }
}
