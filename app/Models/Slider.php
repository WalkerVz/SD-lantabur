<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];
}
