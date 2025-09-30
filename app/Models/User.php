<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'department',
        'position',
        'signature',
        'is_active',
        'last_login',
        'device_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is petugas
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Check if user is pimpinan
     */
    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    /**
     * Get surat masuk yang dibuat oleh user ini
     */
    public function suratMasuks()
    {
        return $this->hasMany(SuratMasuk::class);
    }

    /**
     * Get surat keluar yang dibuat oleh user ini
     */
    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class);
    }

    /**
     * Get surat keluar yang disetujui oleh user ini
     */
    public function approvedSuratKeluars()
    {
        return $this->hasMany(SuratKeluar::class, 'approved_by');
    }

    /**
     * Get disposisi yang dibuat oleh user ini
     */
    public function disposisisDibuat()
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    /**
     * Get disposisi yang diterima oleh user ini
     */
    public function disposisisDiterima()
    {
        return $this->hasMany(Disposisi::class, 'kepada_user_id');
    }

    /**
     * Get device sessions
     */
    public function deviceSessions()
    {
        return $this->hasMany(DeviceSession::class);
    }

    /**
     * Get notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get unread notifications
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Get bookmarks
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get digital signatures
     */
    public function digitalSignatures()
    {
        return $this->hasMany(DigitalSignature::class);
    }

    /**
     * Get log aktivitas
     */
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    /**
     * Get notification settings
     */
    public function notificationSettings()
    {
        return $this->hasOne(NotificationSetting::class);
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Default avatar using initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get signature URL
     */
    public function getSignatureUrlAttribute(): ?string
    {
        return $this->signature ? asset('storage/signatures/' . $this->signature) : null;
    }

    /**
     * Scope active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}