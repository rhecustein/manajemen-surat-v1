<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_surat',
        'nomor_agenda',
        'tanggal_surat',
        'tanggal_terima',
        'pengirim',
        'alamat_pengirim',
        'telepon_pengirim',
        'email_pengirim',
        'perihal',
        'isi_ringkas',
        'klasifikasi_id',
        'tingkat_keamanan',
        'sifat_surat',
        'file',
        'file_size',
        'file_type',
        'status',
        'status_baca',
        'priority',
        'due_date',
        'keywords',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima' => 'date',
        'due_date' => 'date',
        'file_size' => 'integer',
    ];

    /**
     * Get the user that created this surat masuk
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the klasifikasi
     */
    public function klasifikasi()
    {
        return $this->belongsTo(Klasifikasi::class);
    }

    /**
     * Get disposisi for this surat masuk
     */
    public function disposisis()
    {
        return $this->hasMany(Disposisi::class);
    }

    /**
     * Get attachments
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Get digital signatures
     */
    public function digitalSignatures()
    {
        return $this->morphMany(DigitalSignature::class, 'surat');
    }

    /**
     * Get bookmarks
     */
    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? asset('storage/surat-masuk/' . $this->file) : null;
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): ?string
    {
        if (!$this->file_size) {
            return null;
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if surat is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'selesai';
    }

    /**
     * Check if surat is urgent
     */
    public function isUrgent(): bool
    {
        return in_array($this->priority, ['tinggi', 'urgent']) || 
               in_array($this->sifat_surat, ['segera', 'sangat_segera']);
    }

    /**
     * Check if surat is confidential
     */
    public function isConfidential(): bool
    {
        return in_array($this->tingkat_keamanan, ['rahasia', 'sangat_rahasia']);
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'rendah' => 'text-gray-500',
            'sedang' => 'text-blue-500',
            'tinggi' => 'text-orange-500',
            'urgent' => 'text-red-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'baru' => 'text-blue-500',
            'diproses' => 'text-yellow-500',
            'selesai' => 'text-green-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Scope by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope by klasifikasi
     */
    public function scopeByKlasifikasi($query, $klasifikasiId)
    {
        return $query->where('klasifikasi_id', $klasifikasiId);
    }

    /**
     * Scope search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nomor_surat', 'like', "%{$search}%")
              ->orWhere('pengirim', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%")
              ->orWhere('keywords', 'like', "%{$search}%");
        });
    }

    /**
     * Scope unread
     */
    public function scopeUnread($query)
    {
        return $query->where('status_baca', 'belum');
    }

    /**
     * Scope overdue
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('status', '!=', 'selesai');
    }

    /**
     * Scope urgent
     */
    public function scopeUrgent($query)
    {
        return $query->whereIn('priority', ['tinggi', 'urgent'])
                    ->orWhereIn('sifat_surat', ['segera', 'sangat_segera']);
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update(['status_baca' => 'sudah']);
    }

    /**
     * Mark as archived
     */
    public function archive()
    {
        $this->update(['status_baca' => 'arsip']);
    }

    /**
     * Generate next nomor agenda
     */
    public static function generateNomorAgenda(): string
    {
        $year = date('Y');
        $lastNumber = self::whereYear('created_at', $year)
                         ->whereNotNull('nomor_agenda')
                         ->orderBy('nomor_agenda', 'desc')
                         ->first();

        if ($lastNumber && preg_match('/(\d+)/', $lastNumber->nomor_agenda, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf('%03d/SM/%s', $nextNumber, $year);
    }
}
