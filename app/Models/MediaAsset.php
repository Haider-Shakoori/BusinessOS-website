<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaAsset extends Model
{
    protected $fillable = [
        'created_by', 'disk', 'original_path', 'webp_path', 'avif_path',
        'original_name', 'mime_type', 'size_bytes', 'width', 'height',
        'alt_text', 'caption',
    ];

    public function bestPath(): string
    {
        return $this->avif_path ?: ($this->webp_path ?: $this->original_path);
    }

    public function url(?string $format = null): string
    {
        $path = match ($format) {
            'avif' => $this->avif_path,
            'webp' => $this->webp_path,
            default => $this->original_path,
        };

        return Storage::disk($this->disk)->url($path ?: $this->bestPath());
    }
}
