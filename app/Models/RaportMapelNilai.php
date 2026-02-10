<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaportMapelNilai extends Model
{
    protected $table = 'raport_mapel_nilai';

    protected $fillable = [
        'raport_id',
        'mapel_id',
        'nilai',
        'deskripsi',
    ];

    public function raport(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RaportNilai::class, 'raport_id');
    }

    public function mapel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MasterMapel::class, 'mapel_id');
    }
}
