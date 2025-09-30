<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Disposisi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function klasifikasi()
    {
        return $this->belongsTo(Klasifikasi::class);
    }
    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class);
    }

}