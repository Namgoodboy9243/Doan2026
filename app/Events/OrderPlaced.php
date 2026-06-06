<?php

namespace App\Events;

use App\Models\order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('admin-notifications');
    }

    /**
     * Tên sự kiện được phát đi
     */
    public function broadcastAs()
    {
        return 'OrderPlaced';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'name' => $this->order->name,
            'email' => $this->order->email,
            'phone' => $this->order->phone,
            'address' => $this->order->address,
            'status' => $this->order->status,
            'created_at' => $this->order->created_at ? $this->order->created_at->toDateTimeString() : null,
        ];
    }
}
