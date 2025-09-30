<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'web_push',
        'mobile_push',
        'sms',
        'triggers',
        'email_default',
        'webhook_url',
        'frequency',
        'quiet_hours_start',
        'quiet_hours_end',
        'timezone',
    ];

    protected $casts = [
        'email' => 'boolean',
        'web_push' => 'boolean',
        'mobile_push' => 'boolean',
        'sms' => 'boolean',
        'triggers' => 'array',
        'quiet_hours_start' => 'datetime:H:i',
        'quiet_hours_end' => 'datetime:H:i',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if in quiet hours
     */
    public function isInQuietHours(): bool
    {
        if (!$this->quiet_hours_start || !$this->quiet_hours_end) {
            return false;
        }

        $now = now($this->timezone)->format('H:i');
        $start = $this->quiet_hours_start->format('H:i');
        $end = $this->quiet_hours_end->format('H:i');

        return $now >= $start && $now <= $end;
    }

    /**
     * Check if trigger is enabled
     */
    public function isTriggerEnabled($trigger): bool
    {
        $triggers = $this->triggers ?? [];
        return in_array($trigger, $triggers);
    }

    /**
     * Get default settings
     */
    public static function getDefaults(): array
    {
        return [
            'email' => true,
            'web_push' => true,
            'mobile_push' => false,
            'sms' => false,
            'triggers' => [
                'surat_masuk_created',
                'disposisi_received',
                'surat_keluar_approval',
                'deadline_reminder',
            ],
            'frequency' => 'realtime',
            'timezone' => 'Asia/Jakarta',
        ];
    }

    /**
     * Create default settings for user
     */
    public static function createForUser(User $user): self
    {
        return self::create(array_merge(
            ['user_id' => $user->id],
            self::getDefaults()
        ));
    }

    /**
     * Get or create settings for user
     */
    public static function forUser(User $user): self
    {
        return self::firstOrCreate(
            ['user_id' => $user->id],
            self::getDefaults()
        );
    }

    /**
     * Scope global settings
     */
    public function scopeGlobal($query)
    {
        return $query->whereNull('user_id');
    }
}