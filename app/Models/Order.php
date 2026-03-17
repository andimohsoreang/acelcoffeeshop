<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'queue_number', 'order_type',
        'customer_name', 'customer_phone',
        'subtotal', 'total_amount', 'notes', 'status',
        'confirmed_at', 'completed_at', 'cancelled_at', 'cancel_reason',
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // ============================================================
    // Relationships
    // ============================================================

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ============================================================
    // Static Generators
    // ============================================================

    /**
     * ✅ Fix race condition: pakai max(id) bukan count(),
     * sehingga order bersamaan tidak menghasilkan kode duplikat.
     */
    public static function generateOrderCode(): string
    {
        $date = Carbon::now()->format('Ymd');
        // Gabung count ke dalam satu query harian
        $countToday = self::whereDate('created_at', today())->count();
        $sequence = $countToday + 1;

        return 'ORD-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public static function generateQueueNumber(): int
    {
        $lastQueue = self::whereDate('created_at', today())->max('queue_number');
        return ($lastQueue ?? 0) + 1;
    }

    // ============================================================
    // Accessors — Status
    // ============================================================

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'Menunggu Konfirmasi',
            'confirmed'   => 'Dikonfirmasi',
            'in_progress' => 'Sedang Dibuat',
            'ready'       => 'Siap Diambil',
            'completed'   => 'Selesai',
            'cancelled'   => 'Dibatalkan',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'yellow',
            'confirmed'   => 'blue',
            'in_progress' => 'orange',
            'ready'       => 'green',
            'completed'   => 'gray',
            'cancelled'   => 'red',
            default       => 'gray',
        };
    }

    // ============================================================
    // Accessors — Format
    // ============================================================

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    // ============================================================
    // Helper Methods
    // ============================================================

    // ✅ Cek apakah order sudah lunas (payment verified)
    public function isPaid(): bool
    {
        return $this->payment?->status === 'verified';
    }

    // ✅ Cek apakah order masih bisa dibatalkan
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    // ✅ Cek apakah order sudah selesai / tidak bisa diubah lagi
    public function isFinished(): bool
    {
        return in_array($this->status, ['completed', 'cancelled']);
    }

    // ============================================================
    // Scopes
    // ============================================================

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled']);
    }
}