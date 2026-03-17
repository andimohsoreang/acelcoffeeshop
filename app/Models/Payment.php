<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'method', 'amount', 'status',
        'proof_image', 'notes', 'verified_by',
        'verified_at', 'reject_reason'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class , 'verified_by');
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
                'cash' => 'Tunai',
                'qris' => 'QRIS',
                default => $this->method,
            };
    }

    public function getProofImageUrlAttribute(): ?string
    {
        return $this->proof_image
            ? asset('storage/' . $this->proof_image)
            : null;
    }
}