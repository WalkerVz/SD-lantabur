<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMateriJilid extends Model
{
    protected $table = 'master_materi_jilid';

    protected $fillable = ['jilid', 'materi', 'urutan'];

    /**
     * Get distinct jilid names for dropdown.
     */
    public static function getJilidList(): array
    {
        return static::select('jilid')
            ->distinct()
            ->orderByRaw("
                CASE jilid
                    WHEN 'I' THEN 1
                    WHEN 'II' THEN 2
                    WHEN 'III' THEN 3
                    WHEN 'IV' THEN 4
                    WHEN 'V' THEN 5
                    WHEN 'VI' THEN 6
                    ELSE 99
                END ASC, jilid ASC
            ")
            ->pluck('jilid')
            ->toArray();
    }
}
