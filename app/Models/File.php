<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;


class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_file',
        'path',
        'tipe',
        'fileable',
        'ukuran',
    ];

    /**
     * Get file URL
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = (int) $this->ukuran;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipe', $type);
    }
}