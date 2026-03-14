<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrisSetting extends Model
{
    protected $fillable = [
        'image', 'merchant_name', 'is_active', 'uploaded_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class , 'uploaded_by');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public static function getActive(): ?self
    {
        return self::where('is_active', true)->latest()->first();
    }
}