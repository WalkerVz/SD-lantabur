<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPraktik extends Model
{
    protected $table = 'master_praktik';
    protected $fillable = ['section', 'kategori', 'kkm', 'urutan'];
}
