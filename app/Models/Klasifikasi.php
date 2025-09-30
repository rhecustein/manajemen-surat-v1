<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama_klasifikasi',
    ];

    /**
     * Get surat masuk with this klasifikasi
     */
    public function suratMasuks()
    {
        return $this->hasMany(SuratMasuk::class);
    }

    /**
     * Get surat keluar with this klasifikasi
     */
    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class);
    }

    /**
     * Get total surat count
     */
    public function getTotalSuratAttribute(): int
    {
        return $this->suratMasuks()->count() + $this->suratKeluars()->count();
    }

    /**
     * Scope search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('kode', 'like', "%{$search}%")
              ->orWhere('nama_klasifikasi', 'like', "%{$search}%");
        });
    }

    /**
     * Get formatted display name
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->kode . ' - ' . $this->nama_klasifikasi;
    }
}