<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surat_id',
        'surat_type',
        'signature_data',
        'signature_hash',
        'signed_at',
        'ip_address',
        'device_info',
        'is_valid',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'is_valid' => 'boolean',
    ];

    /**
     * Get the user who signed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the signed surat (polymorphic)
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
     * Verify signature hash
     */
    public function verifySignature($data): bool
    {
        $expectedHash = hash('sha256', $data . $this->user_id . $this->signed_at);
        return hash_equals($this->signature_hash, $expectedHash);
    }

    /**
     * Create digital signature
     */
    public static function createSignature($user, $surat, $signatureData): self
    {
        $suratType = $surat instanceof SuratMasuk ? 'surat_masuk' : 'surat_keluar';
        $signedAt = now();
        $hash = hash('sha256', $signatureData . $user->id . $signedAt);

        return self::create([
            'user_id' => $user->id,
            'surat_id' => $surat->id,
            'surat_type' => $suratType,
            'signature_data' => $signatureData,
            'signature_hash' => $hash,
            'signed_at' => $signedAt,
            'ip_address' => request()->ip(),
            'device_info' => request()->userAgent(),
        ]);
    }

    /**
     * Invalidate signature
     */
    public function invalidate()
    {
        $this->update(['is_valid' => false]);
    }

    /**
     * Scope valid signatures
     */
    public function scopeValid($query)
    {
        return $query->where('is_valid', true);
    }

    /**
     * Scope by surat type
     */
    public function scopeBySuratType($query, $type)
    {
        return $query->where('surat_type', $type);
    }
}