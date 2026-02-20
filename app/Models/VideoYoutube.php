<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoYoutube extends Model
{
    protected $table = 'video_youtube';
    protected $fillable = ['judul', 'youtube_id', 'deskripsi', 'urutan', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    /**
     * Ekstrak YouTube ID dari berbagai format URL:
     * - https://www.youtube.com/watch?v=VIDEO_ID
     * - https://youtu.be/VIDEO_ID
     * - https://www.youtube.com/shorts/VIDEO_ID
     * - VIDEO_ID langsung (11 karakter)
     */
    public static function extractYoutubeId(string $url): ?string
    {
        $url = trim($url);

        // Jika sudah berupa ID langsung (11 karakter alfanumerik/hyphen/underscore)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Pola umum YouTube URL
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
