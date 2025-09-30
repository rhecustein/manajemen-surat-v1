<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'original_name',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'extension',
        'is_main',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'is_main' => 'boolean',
    ];

    /**
     * Get the parent attachable model
     */
    public function attachable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who uploaded this attachment
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get file URL
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get download URL
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('attachments.download', $this->id);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if file is PDF
     */
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    /**
     * Check if file is document
     */
    public function isDocument(): bool
    {
        return in_array($this->mime_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ]);
    }

    /**
     * Get file icon
     */
    public function getIconAttribute(): string
    {
        if ($this->isImage()) {
            return 'fas fa-image text-green-500';
        }
        
        if ($this->isPdf()) {
            return 'fas fa-file-pdf text-red-500';
        }

        return match($this->extension) {
            'doc', 'docx' => 'fas fa-file-word text-blue-500',
            'xls', 'xlsx' => 'fas fa-file-excel text-green-500',
            'ppt', 'pptx' => 'fas fa-file-powerpoint text-orange-500',
            'zip', 'rar' => 'fas fa-file-archive text-yellow-500',
            'txt' => 'fas fa-file-alt text-gray-500',
            default => 'fas fa-file text-gray-500',
        };
    }

    /**
     * Check if file exists
     */
    public function fileExists(): bool
    {
        return Storage::exists($this->file_path);
    }

    /**
     * Delete file from storage
     */
    public function deleteFile(): bool
    {
        if ($this->fileExists()) {
            return Storage::delete($this->file_path);
        }
        return true;
    }

    /**
     * Scope by attachable type
     */
    public function scopeForModel($query, $modelType)
    {
        return $query->where('attachable_type', $modelType);
    }

    /**
     * Scope main attachments
     */
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }

    /**
     * Scope images
     */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    /**
     * Scope documents
     */
    public function scopeDocuments($query)
    {
        return $query->whereIn('mime_type', [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ]);
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Delete file when attachment is deleted
        static::deleting(function ($attachment) {
            $attachment->deleteFile();
        });
    }

    /**
     * Create attachment from uploaded file
     */
    public static function createFromUpload($file, $attachable, $isMain = false, $uploadedBy = null): self
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();
        
        // Generate unique filename
        $fileName = time() . '_' . str_replace(' ', '_', $originalName);
        
        // Store file
        $path = $file->storeAs('attachments', $fileName, 'public');

        return self::create([
            'attachable_type' => get_class($attachable),
            'attachable_id' => $attachable->id,
            'original_name' => $originalName,
            'file_name' => $fileName,
            'file_path' => $path,
            'file_size' => $size,
            'mime_type' => $mimeType,
            'extension' => $extension,
            'is_main' => $isMain,
            'uploaded_by' => $uploadedBy ?? auth()->id(),
        ]);
    }
}