<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kontak extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'instansi',
        'tipe',
    ];

    /**
     * Get display name with instansi
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->instansi ? "{$this->nama} ({$this->instansi})" : $this->nama;
    }

    /**
     * Scope by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipe', $type);
    }

    /**
     * Scope search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('instansi', 'like', "%{$search}%");
        });
    }

    /**
     * Get clients
     */
    public function scopeClients($query)
    {
        return $query->where('tipe', 'client');
    }

    /**
     * Get partners
     */
    public function scopePartners($query)
    {
        return $query->where('tipe', 'rekanan');
    }

    /**
     * Get internal contacts
     */
    public function scopeInternal($query)
    {
        return $query->where('tipe', 'internal');
    }
}