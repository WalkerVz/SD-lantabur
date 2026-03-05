<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMateriTahfidz extends Model
{
    protected $table = 'master_materi_tahfidz';

    protected $fillable = ['jilid', 'materi', 'urutan'];

    public static function getJilidList(): array
    {
        return static::select('jilid')
            ->distinct()
            ->orderBy('urutan')
            ->pluck('jilid')
            ->toArray();
    }
}
