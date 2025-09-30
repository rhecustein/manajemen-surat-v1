<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
        'title',
        'notes',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookmarked item
     */
    public function bookmarkable()
    {
        return $this->morphTo();
    }

    /**
     * Get display title
     */
    public function getDisplayTitleAttribute(): string
    {
        if ($this->title) {
            return $this->title;
        }

        $item = $this->bookmarkable;
        if (!$item) return 'Unknown Item';

        if ($item instanceof SuratMasuk) {
            return "Surat Masuk: {$item->nomor_surat}";
        } elseif ($item instanceof SuratKeluar) {
            return "Surat Keluar: {$item->nomor_surat}";
        } elseif ($item instanceof Disposisi) {
            return "Disposisi: {$item->suratMasuk->nomor_surat}";
        }

        return class_basename($item) . " #{$item->id}";
    }

    /**
     * Get bookmark icon
     */
    public function getIconAttribute(): string
    {
        $item = $this->bookmarkable;
        if (!$item) return 'fas fa-bookmark';

        return match(get_class($item)) {
            SuratMasuk::class => 'fas fa-inbox',
            SuratKeluar::class => 'fas fa-paper-plane',
            Disposisi::class => 'fas fa-share',
            default => 'fas fa-bookmark',
        };
    }

    /**
     * Create bookmark for user
     */
    public static function createFor($user, $item, $title = null, $notes = null): self
    {
        return self::updateOrCreate(
            [
                'user_id' => $user->id,
                'bookmarkable_type' => get_class($item),
                'bookmarkable_id' => $item->id,
            ],
            [
                'title' => $title,
                'notes' => $notes,
            ]
        );
    }

    /**
     * Check if user has bookmarked item
     */
    public static function isBookmarked($user, $item): bool
    {
        return self::where('user_id', $user->id)
                  ->where('bookmarkable_type', get_class($item))
                  ->where('bookmarkable_id', $item->id)
                  ->exists();
    }

    /**
     * Toggle bookmark
     */
    public static function toggle($user, $item, $title = null, $notes = null): bool
    {
        $bookmark = self::where('user_id', $user->id)
                       ->where('bookmarkable_type', get_class($item))
                       ->where('bookmarkable_id', $item->id)
                       ->first();

        if ($bookmark) {
            $bookmark->delete();
            return false; // Removed
        } else {
            self::createFor($user, $item, $title, $notes);
            return true; // Added
        }
    }

    /**
     * Scope by bookmarkable type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('bookmarkable_type', $type);
    }
}