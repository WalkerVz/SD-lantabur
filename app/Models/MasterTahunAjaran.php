<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTahunAjaran extends Model
{
    protected $table = 'master_tahun_ajaran';

    protected $fillable = ['nama', 'is_aktif', 'urutan'];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public static function getAktif(): ?string
    {
        $row = static::where('is_aktif', true)->first();

        return $row?->nama;
    }

    public static function getListForDropdown(): array
    {
        return static::orderBy('urutan')->orderByDesc('nama')->pluck('nama')->all();
    }
}
