<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_available',
        'is_featured',
        'is_newcomer',
        'rating_avg',
        'rating_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'is_newcomer' => 'boolean',
        'rating_avg' => 'decimal:2',
    ];

    // ============================================================
    // Boots
    // ============================================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });

        // ✅ Update slug juga saat nama diubah
        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    /**
     * Generate a unique slug, appending a numeric suffix if the base slug already exists.
     * E.g.: "test" → "test-2" → "test-3" ...
     */
    public static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $base = \Illuminate\Support\Str::slug($name);
        $slug = $base;
        $count = 2;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }

    // ============================================================
    // Relationships
    // ============================================================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ============================================================
    // Accessors
    // ============================================================

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-product.png');
    }

    // ============================================================
    // Scopes
    // ============================================================

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNewcomer($query)
    {
        return $query->where('is_newcomer', true);
    }

    // ============================================================
    // Helper Methods
    // ============================================================

    /**
     * ✅ Fix: sebelumnya query 2x ke DB (avg + count terpisah).
     * Sekarang 1x query dengan selectRaw.
     * Dipanggil setelah approve/reject review.
     */
    public function updateRatingCache(): void
    {
        $stats = $this->reviews()
            ->approved()
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->first();

        $this->update([
            'rating_avg' => $stats->avg_rating ?? 0,
            'rating_count' => $stats->total_reviews ?? 0,
        ]);
    }
}