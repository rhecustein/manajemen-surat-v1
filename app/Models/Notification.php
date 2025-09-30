<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'action_url',
        'icon',
        'priority',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if notification is read
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if notification is unread
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Check if notification is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if notification is urgent
     */
    public function isUrgent(): bool
    {
        return in_array($this->priority, ['high', 'urgent']);
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        if ($this->isUnread()) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Mark as unread
     */
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Get icon with default
     */
    public function getIconAttribute($value): string
    {
        if ($value) {
            return $value;
        }

        return match($this->type) {
            'surat_masuk' => 'fas fa-inbox',
            'surat_keluar' => 'fas fa-paper-plane',
            'disposisi' => 'fas fa-share',
            'approval' => 'fas fa-check-circle',
            'reminder' => 'fas fa-bell',
            'system' => 'fas fa-cog',
            default => 'fas fa-info-circle',
        };
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'text-gray-500',
            'normal' => 'text-blue-500',
            'high' => 'text-orange-500',
            'urgent' => 'text-red-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Get time ago
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Scope unread
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope read
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope urgent
     */
    public function scopeUrgent($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope not expired
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope expired
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Create notification for user
     */
    public static function createForUser(User $user, array $data): self
    {
        return self::create(array_merge($data, ['user_id' => $user->id]));
    }

    /**
     * Create notification for multiple users
     */
    public static function createForUsers($users, array $data): void
    {
        $notifications = collect($users)->map(function ($user) use ($data) {
            return array_merge($data, [
                'user_id' => is_object($user) ? $user->id : $user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        })->toArray();

        self::insert($notifications);
    }

    /**
     * Create surat masuk notification
     */
    public static function suratMasukCreated(SuratMasuk $suratMasuk, $users = null): void
    {
        $users = $users ?? User::where('role', 'admin')->get();
        
        self::createForUsers($users, [
            'type' => 'surat_masuk',
            'title' => 'Surat Masuk Baru',
            'message' => "Surat masuk baru dari {$suratMasuk->pengirim} dengan perihal: {$suratMasuk->perihal}",
            'data' => [
                'surat_masuk_id' => $suratMasuk->id,
                'nomor_surat' => $suratMasuk->nomor_surat,
            ],
            'action_url' => route('surat-masuk.show', $suratMasuk),
            'priority' => $suratMasuk->isUrgent() ? 'urgent' : 'normal',
        ]);
    }

    /**
     * Create disposisi notification
     */
    public static function disposisiCreated(Disposisi $disposisi): void
    {
        self::createForUser($disposisi->kepadaUser, [
            'type' => 'disposisi',
            'title' => 'Disposisi Baru',
            'message' => "Anda mendapat disposisi dari {$disposisi->dariUser->name}",
            'data' => [
                'disposisi_id' => $disposisi->id,
                'surat_masuk_id' => $disposisi->surat_masuk_id,
            ],
            'action_url' => route('disposisi.show', $disposisi),
            'priority' => $disposisi->isUrgent() ? 'urgent' : 'normal',
        ]);
    }
}