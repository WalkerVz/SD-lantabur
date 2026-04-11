<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $table = 'berita';

    protected $fillable = ['judul', 'kategori', 'isi', 'ringkasan', 'gambar', 'gambar_dua', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
