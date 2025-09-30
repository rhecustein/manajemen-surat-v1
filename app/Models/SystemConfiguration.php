<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class SystemConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'key',
        'value',
        'description',
        'data_type',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get configuration value with proper casting
     */
    public function getTypedValue()
    {
        return match($this->data_type) {
            'integer' => (int) $this->value,
            'boolean' => (bool) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Get configuration by group and key
     */
    public static function get($group, $key, $default = null)
    {
        $cacheKey = "config.{$group}.{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($group, $key, $default) {
            $config = self::where('group_name', $group)
                         ->where('key', $key)
                         ->first();
            
            return $config ? $config->getTypedValue() : $default;
        });
    }

    /**
     * Set configuration value
     */
    public static function set($group, $key, $value, $description = null, $dataType = 'string')
    {
        $config = self::updateOrCreate(
            ['group_name' => $group, 'key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'description' => $description,
                'data_type' => $dataType,
            ]
        );

        // Clear cache
        Cache::forget("config.{$group}.{$key}");
        
        return $config;
    }

    /**
     * Get all configurations by group
     */
    public static function getGroup($group)
    {
        return self::where('group_name', $group)->get()
                  ->pluck('value', 'key')
                  ->toArray();
    }

    /**
     * Scope by group
     */
    public function scopeByGroup($query, $group)
    {
        return $query->where('group_name', $group);
    }

    /**
     * Scope public configurations
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}