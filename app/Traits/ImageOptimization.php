<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageOptimization
{
    /**
     * Optimize, resize, and store image as WEBP.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int|null $maxWidth
     * @param int $quality (1-100)
     * @return string|null
     */
    protected function optimizeAndStore(UploadedFile $file, string $directory, ?int $maxWidth = 1200, int $quality = 80): ?string
    {
        try {
            $imageInfo = getimagesize($file->getRealPath());
            if (!$imageInfo) return $file->store($directory, 'public');

            $width = $imageInfo[0];
            $height = $imageInfo[1];
            $type = $imageInfo[2];

            // Create image from source
            $srcImage = null;
            switch ($type) {
                case IMAGETYPE_JPEG: $srcImage = imagecreatefromjpeg($file->getRealPath()); break;
                case IMAGETYPE_PNG: $srcImage = imagecreatefrompng($file->getRealPath()); break;
                case IMAGETYPE_GIF: $srcImage = imagecreatefromgif($file->getRealPath()); break;
                case IMAGETYPE_WEBP: $srcImage = imagecreatefromwebp($file->getRealPath()); break;
                default: return $file->store($directory, 'public');
            }

            if (!$srcImage) return $file->store($directory, 'public');

            // Handle transparency for PNG/GIF
            if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
                imagepalettecopy($srcImage, imagecreatetruecolor($width, $height));
                imagefill($srcImage, 0, 0, imagecolorallocatealpha($srcImage, 0, 0, 0, 127));
                imagealphablending($srcImage, true);
                imagesavealpha($srcImage, true);
            }

            // Resize if needed
            if ($maxWidth && $width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = floor($height * ($maxWidth / $width));
                $destImage = imagecreatetruecolor($newWidth, $newHeight);
                
                // Keep transparency if applicable
                imagealphablending($destImage, false);
                imagesavealpha($destImage, true);
                
                imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($srcImage);
                $srcImage = $destImage;
            }

            // Generate filename
            $filename = Str::random(40) . '.webp';
            $tempPath = tempnam(sys_get_temp_dir(), 'img_');
            
            // Save as WebP
            imagewebp($srcImage, $tempPath, $quality);
            imagedestroy($srcImage);

            // Move to storage
            $path = $directory . '/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($tempPath));
            
            // Clean up temp file
            unlink($tempPath);

            return $path;
        } catch (\Exception $e) {
            report($e);
            // Fallback to standard Laravel storage if something goes wrong
            return $file->store($directory, 'public');
        }
    }
}
