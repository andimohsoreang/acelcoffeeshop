<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class Review extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'customer_name',
        'customer_phone',
        'rating',
        'comment',
        'is_approved',
        'approved_at',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    // ============================================================
    // Boots
    // ============================================================

    protected static function boot()
    {
        parent::boot();

        // ✅ Validasi rating 1–5 di level model
        $validateRating = function ($review) {
            if ($review->rating < 1 || $review->rating > 5) {
                throw new InvalidArgumentException('Rating harus antara 1 sampai 5.');
            }
        };

        static::creating($validateRating);
        static::updating($validateRating);
    }

    // ============================================================
    // Relationships
    // ============================================================

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ============================================================
    // Scopes
    // ============================================================

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    // ============================================================
    // Accessors
    // ============================================================

    // Tampilan bintang: ★★★★☆
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating)
            . str_repeat('☆', 5 - $this->rating);
    }
}