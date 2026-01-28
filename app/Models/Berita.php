<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = ['judul', 'kategori', 'isi', 'gambar', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
