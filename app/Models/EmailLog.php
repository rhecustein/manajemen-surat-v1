<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'to_email',
        'from_email',
        'subject',
        'body',
        'status',
        'sent_at',
        'error_message',
        'surat_id',
        'surat_type',
        'template_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * Get the email template used
     */
    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    /**
     * Get the related surat (polymorphic)
     */
    public function surat()
    {
        if ($this->surat_type === 'surat_masuk') {
            return $this->belongsTo(SuratMasuk::class, 'surat_id');
        } elseif ($this->surat_type === 'surat_keluar') {
            return $this->belongsTo(SuratKeluar::class, 'surat_id');
        }
        
        return null;
    }

    /**
     * Check if email was sent successfully
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Check if email failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if email is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if email bounced
     */
    public function isBounced(): bool
    {
        return $this->status === 'bounced';
    }

    /**
     * Mark as sent
     */
    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'error_message' => null,
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Mark as bounced
     */
    public function markAsBounced($errorMessage = null)
    {
        $this->update([
            'status' => 'bounced',
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'sent' => 'text-green-500',
            'failed' => 'text-red-500',
            'bounced' => 'text-orange-500',
            'pending' => 'text-blue-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'sent' => 'fas fa-check-circle',
            'failed' => 'fas fa-times-circle',
            'bounced' => 'fas fa-exclamation-triangle',
            'pending' => 'fas fa-clock',
            default => 'fas fa-question-circle',
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
     * Scope sent emails
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope failed emails
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope pending emails
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope by surat type
     */
    public function scopeBySuratType($query, $suratType)
    {
        return $query->where('surat_type', $suratType);
    }

    /**
     * Scope by recipient
     */
    public function scopeToEmail($query, $email)
    {
        return $query->where('to_email', $email);
    }

    /**
     * Scope recent emails
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Create email log
     */
    public static function createLog(array $data): self
    {
        return self::create([
            'to_email' => $data['to'],
            'from_email' => $data['from'] ?? config('mail.from.address'),
            'subject' => $data['subject'],
            'body' => $data['body'],
            'status' => 'pending',
            'surat_id' => $data['surat_id'] ?? null,
            'surat_type' => $data['surat_type'] ?? null,
            'template_id' => $data['template_id'] ?? null,
        ]);
    }

    /**
     * Get delivery time (time between created and sent)
     */
    public function getDeliveryTimeAttribute(): ?string
    {
        if (!$this->sent_at) {
            return null;
        }

        return $this->created_at->diffForHumans($this->sent_at, true);
    }

    /**
     * Retry sending email
     */
    public function retry(): void
    {
        $this->update([
            'status' => 'pending',
            'error_message' => null,
        ]);
    }
}