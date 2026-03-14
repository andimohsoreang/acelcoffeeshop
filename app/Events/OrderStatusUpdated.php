<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Order $order)
    {
    //
    }

    public function broadcastOn(): array
    {
        return [
            // Channel Admin (Public untuk percobaan realtime LAN ini)
            new Channel('admin-orders'),
            // Channel Publik per order (siapapun yang hafal order_code bisa listen)
            new Channel('order.' . $this->order->order_code),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'id'             => $this->order->id,
            'order_code'     => $this->order->order_code,
            'status'         => $this->order->status,
            'status_label'   => $this->order->status_label,
            'updated_at'     => $this->order->updated_at->format('H:i'),
            'payment_status' => $this->order->payment?->status,
            'confirmed_at'   => $this->order->confirmed_at?->format('H:i'),
            'completed_at'   => $this->order->completed_at?->format('H:i'),
        ];
    }
}