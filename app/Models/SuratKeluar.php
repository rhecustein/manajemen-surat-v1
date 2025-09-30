<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
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
        'tanggal_kirim',
        'tujuan',
        'alamat_tujuan',
        'telepon_tujuan',
        'email_tujuan',
        'perihal',
        'isi_ringkas',
        'klasifikasi_id',
        'tingkat_keamanan',
        'sifat_surat',
        'file',
        'file_size',
        'file_type',
        'status_kirim',
        'status',
        'priority',
        'delivery_method',
        'tracking_number',
        'keywords',
        'user_id',
        'approved_by',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_kirim' => 'date',
        'approved_at' => 'datetime',
        'file_size' => 'integer',
    ];

    /**
     * Get the user that created this surat keluar
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that approved this surat keluar
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the klasifikasi
     */
    public function klasifikasi()
    {
        return $this->belongsTo(Klasifikasi::class);
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
     * Get email logs
     */
    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class, 'surat_id')->where('surat_type', 'surat_keluar');
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? asset('storage/surat-keluar/' . $this->file) : null;
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
     * Check if surat is approved
     */
    public function isApproved(): bool
    {
        return !is_null($this->approved_by) && !is_null($this->approved_at);
    }

    /**
     * Check if surat is sent
     */
    public function isSent(): bool
    {
        return $this->status_kirim === 'terkirim';
    }

    /**
     * Check if surat is draft
     */
    public function isDraft(): bool
    {
        return $this->status_kirim === 'draft';
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
        return match($this->status_kirim) {
            'draft' => 'text-gray-500',
            'terkirim' => 'text-green-500',
            'arsip' => 'text-blue-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Approve surat
     */
    public function approve(User $approver)
    {
        $this->update([
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);
    }

    /**
     * Send surat
     */
    public function send()
    {
        $this->update([
            'status_kirim' => 'terkirim',
            'tanggal_kirim' => now(),
        ]);
    }

    /**
     * Archive surat
     */
    public function archive()
    {
        $this->update(['status_kirim' => 'arsip']);
    }

    /**
     * Scope by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope by status kirim
     */
    public function scopeByStatusKirim($query, $statusKirim)
    {
        return $query->where('status_kirim', $statusKirim);
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
              ->orWhere('tujuan', 'like', "%{$search}%")
              ->orWhere('perihal', 'like', "%{$search}%")
              ->orWhere('keywords', 'like', "%{$search}%");
        });
    }

    /**
     * Scope approved
     */
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_by')
                    ->whereNotNull('approved_at');
    }

    /**
     * Scope pending approval
     */
    public function scopePendingApproval($query)
    {
        return $query->whereNull('approved_by')
                    ->where('status_kirim', 'draft');
    }

    /**
     * Scope sent
     */
    public function scopeSent($query)
    {
        return $query->where('status_kirim', 'terkirim');
    }

    /**
     * Scope draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status_kirim', 'draft');
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

        return sprintf('%03d/SK/%s', $nextNumber, $year);
    }
}

// ========================================
// Model - Disposisi
// ========================================

class Disposisi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surat_masuk_id',
        'dari_user_id',
        'kepada_user_id',
        'catatan',
        'instruksi',
        'due_date',
        'priority',
        'status',
        'tanggal_baca',
        'tanggal_selesai',
        'feedback',
        'is_forwarded',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'tanggal_baca' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'is_forwarded' => 'boolean',
    ];

    /**
     * Get the surat masuk
     */
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    /**
     * Get the user who created the disposisi
     */
    public function dariUser()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    /**
     * Get the user who receives the disposisi
     */
    public function kepadaUser()
    {
        return $this->belongsTo(User::class, 'kepada_user_id');
    }

    /**
     * Get the user who created this disposisi
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get bookmarks
     */
    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Check if disposisi is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && 
               $this->due_date->isPast() && 
               !in_array($this->status, ['diterima', 'selesai']);
    }

    /**
     * Check if disposisi is urgent
     */
    public function isUrgent(): bool
    {
        return in_array($this->priority, ['tinggi', 'urgent']);
    }

    /**
     * Check if disposisi is read
     */
    public function isRead(): bool
    {
        return !is_null($this->tanggal_baca);
    }

    /**
     * Check if disposisi is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'selesai' && !is_null($this->tanggal_selesai);
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
            'diajukan' => 'text-blue-500',
            'diproses' => 'text-yellow-500',
            'diterima' => 'text-green-500',
            'ditolak' => 'text-red-500',
            'selesai' => 'text-green-600',
            default => 'text-gray-500',
        };
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        if (!$this->isRead()) {
            $this->update([
                'tanggal_baca' => now(),
                'status' => 'diproses'
            ]);
        }
    }

    /**
     * Accept disposisi
     */
    public function accept($feedback = null)
    {
        $this->update([
            'status' => 'diterima',
            'tanggal_baca' => $this->tanggal_baca ?? now(),
            'feedback' => $feedback,
        ]);
    }

    /**
     * Reject disposisi
     */
    public function reject($feedback)
    {
        $this->update([
            'status' => 'ditolak',
            'tanggal_baca' => $this->tanggal_baca ?? now(),
            'feedback' => $feedback,
        ]);
    }

    /**
     * Complete disposisi
     */
    public function complete($feedback = null)
    {
        $this->update([
            'status' => 'selesai',
            'tanggal_selesai' => now(),
            'feedback' => $feedback,
        ]);
    }

    /**
     * Forward disposisi
     */
    public function forward()
    {
        $this->update(['is_forwarded' => true]);
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
     * Scope for specific user (kepada_user_id)
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('kepada_user_id', $userId);
    }

    /**
     * Scope from specific user (dari_user_id)
     */
    public function scopeFromUser($query, $userId)
    {
        return $query->where('dari_user_id', $userId);
    }

    /**
     * Scope unread
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('tanggal_baca');
    }

    /**
     * Scope overdue
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereNotIn('status', ['diterima', 'selesai']);
    }

    /**
     * Scope urgent
     */
    public function scopeUrgent($query)
    {
        return $query->whereIn('priority', ['tinggi', 'urgent']);
    }

    /**
     * Scope pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'diajukan');
    }

    /**
     * Scope in progress
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'diproses');
    }

    /**
     * Scope completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Scope forwarded
     */
    public function scopeForwarded($query)
    {
        return $query->where('is_forwarded', true);
    }

    /**
     * Get time remaining until due date
     */
    public function getTimeRemainingAttribute(): ?string
    {
        if (!$this->due_date) {
            return null;
        }

        $now = now();
        $dueDate = $this->due_date;

        if ($dueDate->isPast()) {
            return 'Terlambat ' . $dueDate->diffForHumans($now, true);
        }

        return 'Sisa ' . $dueDate->diffForHumans($now, true);
    }

    /**
     * Get response time (time between created and read)
     */
    public function getResponseTimeAttribute(): ?string
    {
        if (!$this->tanggal_baca) {
            return null;
        }

        return $this->created_at->diffForHumans($this->tanggal_baca, true);
    }

    /**
     * Get completion time (time between created and completed)
     */
    public function getCompletionTimeAttribute(): ?string
    {
        if (!$this->tanggal_selesai) {
            return null;
        }

        return $this->created_at->diffForHumans($this->tanggal_selesai, true);
    }
}