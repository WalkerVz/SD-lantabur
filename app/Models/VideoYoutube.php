<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoYoutube extends Model
{
    use HasFactory;
    protected $table = 'video_youtube';
    protected $fillable = ['judul', 'youtube_id', 'url_asli', 'deskripsi', 'urutan', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    public static function extractYoutubeId(string $url): ?string
    {
        $url = trim($url);

        // Jika sudah berupa ID langsung (11 karakter alfanumerik/hyphen/underscore)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Pola umum YouTube URL
        $patterns = [
            // Handle watch?v=... (bisa di awal atau di tengah query string)
            '/[?&]v=([a-zA-Z0-9_-]{11})/',
            // Handle shorts, live, embed, and youtu.be
            '/(?:youtube\.com\/(?:shorts\/|live\/|embed\/)|youtu\.be\/|youtube-nocookie\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public function getThumbnailUrlAttribute(): string
    {
        return "https://img.youtube.com/vi/{$this->youtube_id}/mqdefault.jpg";
    }

    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube-nocookie.com/embed/{$this->youtube_id}?rel=0&modestbranding=1";
    }
}
