<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DeviceSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'device_type',
        'device_name',
        'browser_name',
        'os_name',
        'ip_address',
        'user_agent',
        'is_active',
        'last_activity',
        'login_at',
        'logout_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'last_activity' => 'datetime',
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if session is online
     */
    public function isOnline(): bool
    {
        return $this->is_active && 
               $this->last_activity && 
               $this->last_activity->diffInMinutes(now()) <= 5;
    }

    /**
     * Check if session is mobile
     */
    public function isMobile(): bool
    {
        return in_array($this->device_type, ['mobile', 'tablet']);
    }

    /**
     * Get session duration
     */
    public function getSessionDurationAttribute(): ?string
    {
        if (!$this->login_at) {
            return null;
        }

        $endTime = $this->logout_at ?? $this->last_activity ?? now();
        return $this->login_at->diffForHumans($endTime, true);
    }

    /**
     * Get device icon
     */
    public function getDeviceIconAttribute(): string
    {
        return match($this->device_type) {
            'mobile' => 'fas fa-mobile-alt',
            'tablet' => 'fas fa-tablet-alt',
            'desktop' => 'fas fa-desktop',
            default => 'fas fa-globe',
        };
    }

    /**
     * Get location from IP (simplified)
     */
    public function getLocationAttribute(): string
    {
        // In real implementation, you might use a GeoIP service
        if ($this->ip_address === '127.0.0.1' || $this->ip_address === '::1') {
            return 'Local';
        }
        return 'Unknown Location';
    }

    /**
     * Scope active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by device type
     */
    public function scopeByDevice($query, $deviceType)
    {
        return $query->where('device_type', $deviceType);
    }

    /**
     * Scope online sessions (active in last 5 minutes)
     */
    public function scopeOnline($query)
    {
        return $query->where('is_active', true)
                    ->where('last_activity', '>=', now()->subMinutes(5));
    }

    /**
     * Update last activity
     */
    public function updateActivity()
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * End session
     */
    public function endSession()
    {
        $this->update([
            'is_active' => false,
            'logout_at' => now(),
        ]);
    }

    /**
     * Parse user agent to get device info
     */
    public static function parseUserAgent($userAgent): array
    {
        $deviceType = 'web';
        $deviceName = 'Unknown Device';
        $browserName = 'Unknown Browser';
        $osName = 'Unknown OS';

        // Simple user agent parsing (you might want to use a library like WhichBrowser)
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            $deviceType = 'mobile';
            if (preg_match('/iPad/', $userAgent)) {
                $deviceType = 'tablet';
                $deviceName = 'iPad';
            } elseif (preg_match('/iPhone/', $userAgent)) {
                $deviceName = 'iPhone';
            } elseif (preg_match('/Android/', $userAgent)) {
                $deviceName = 'Android Device';
            }
        }

        // Browser detection
        if (preg_match('/Chrome/', $userAgent)) {
            $browserName = 'Chrome';
        } elseif (preg_match('/Firefox/', $userAgent)) {
            $browserName = 'Firefox';
        } elseif (preg_match('/Safari/', $userAgent)) {
            $browserName = 'Safari';
        } elseif (preg_match('/Edge/', $userAgent)) {
            $browserName = 'Edge';
        }

        // OS detection
        if (preg_match('/Windows/', $userAgent)) {
            $osName = 'Windows';
        } elseif (preg_match('/Mac/', $userAgent)) {
            $osName = 'macOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $osName = 'Linux';
        } elseif (preg_match('/Android/', $userAgent)) {
            $osName = 'Android';
        } elseif (preg_match('/iOS/', $userAgent)) {
            $osName = 'iOS';
        }

        return [
            'device_type' => $deviceType,
            'device_name' => $deviceName,
            'browser_name' => $browserName,
            'os_name' => $osName,
        ];
    }
}