<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'aktivitas',
        'user_id',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model
     */
    public function model()
    {
        $modelClass = $this->model_type;
        if (class_exists($modelClass)) {
            return $modelClass::find($this->model_id);
        }
        return null;
    }

    /**
     * Create history record
     */
    public static function log($model, $activity, $userId = null): self
    {
        return self::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'aktivitas' => $activity,
            'user_id' => $userId ?? auth()->id(),
        ]);
    }

    /**
     * Scope by model
     */
    public function scopeForModel($query, $model)
    {
        return $query->where('model_type', get_class($model))
                    ->where('model_id', $model->id);
    }

    /**
     * Scope recent
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}