<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 👇 tambahkan property public agar data Order bisa diakses
    public function __construct(public Order $order)
    {
    //
    }

    // 👇 tentukan channel broadcast (siapa yang mendengarkan)
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-orders'),
        ];
    }

    // 👇 nama event yang didengarkan di frontend
    public function broadcastAs(): string
    {
        return 'order.placed';
    }

    // 👇 data yang dikirim ke frontend via WebSocket
    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'order_code' => $this->order->order_code,
            'queue_number' => $this->order->queue_number,
            'customer_name' => $this->order->customer_name,
            'order_type' => $this->order->order_type,
            'total_amount' => $this->order->total_amount,
            'status' => $this->order->status,
            'created_at' => $this->order->created_at->format('H:i'),
            'items_count' => $this->order->items->count(),
        ];
    }
}