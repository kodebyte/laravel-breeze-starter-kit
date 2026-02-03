<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Handle Image Upload with Auto-WebP Conversion
     *
     * @param UploadedFile $file The file object
     * @param string $folder The destination folder (e.g. 'banners')
     * @param int|null $width Resize width (optional, null = original)
     * @param int $quality WebP Quality (default 80)
     * @return string The stored file path
     */
    public function upload(UploadedFile $file, string $folder, ?int $width = null, int $quality = 80): string
    {
        // 1. Handle SVG (Vector) - Save directly
        if ($file->getClientOriginalExtension() === 'svg') {
            return $file->store($folder, 'public');
        }

        // 2. Generate Hash Filename with .webp extension
        $filename = $file->hashName(); // random.jpg
        $filename = pathinfo($filename, PATHINFO_FILENAME) . '.webp'; // random.webp
        $path = $folder . '/' . $filename;

        // 3. Process Image
        $image = Image::read($file);

        // 4. Resize Logic (Maintain Aspect Ratio)
        if ($width) {
            $image->scale(width: $width);
        }

        // 5. Encode to WebP
        $encoded = $image->toWebp(quality: $quality);

        // 6. Store to Public Disk
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Delete Image from Storage
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}