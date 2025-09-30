<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'nama_web',
        'meta_description',
        'meta_keywords',
        'logo',
        'favicon',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'smtp_username',
        'smtp_password',
        'smtp_from_name',
        'smtp_from_address',
        'maintenance_mode',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'smtp_port' => 'integer',
    ];

    /**
     * Get setting by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value
     */
    public static function set($key, $value): self
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get logo URL
     */
    public static function getLogo(): ?string
    {
        $logo = self::get('logo');
        return $logo ? asset('storage/' . $logo) : null;
    }

    /**
     * Get favicon URL
     */
    public static function getFavicon(): ?string
    {
        $favicon = self::get('favicon');
        return $favicon ? asset('storage/' . $favicon) : null;
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode(): bool
    {
        return self::get('maintenance_mode', false);
    }
}