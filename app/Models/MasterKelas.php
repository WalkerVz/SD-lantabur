<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKelas extends Model
{
    protected $table = 'master_kelas';
    
    protected $fillable = ['tingkat', 'nama_surah'];

    /**
     * Wali kelas sekarang dikelola per tahun ajaran di model TahunKelas
     */
}
