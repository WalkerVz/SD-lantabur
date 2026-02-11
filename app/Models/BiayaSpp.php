<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaSpp extends Model
{
    protected $table = 'biaya_spp';

    protected $fillable = ['tahun_ajaran', 'kelas', 'nominal'];

    protected $casts = [
        'nominal' => 'decimal:0',
    ];

    public static function getNominal(string $tahunAjaran, int $kelas): float
    {
        $row = self::where('tahun_ajaran', $tahunAjaran)->where('kelas', $kelas)->first();
        return $row ? (float) $row->nominal : 0;
    }
}
