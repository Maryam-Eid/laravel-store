<?php

namespace App\Events;

use App\Models\Delivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lat;

    public $lng;

    protected $delivery;

    /**
     * Create a new event instance.
     */
    public function __construct(Delivery $delivery, $lat, $lng)
    {
        $this->delivery = $delivery;
        $this->lat = (float)$lat;
        $this->lng = (float)$lng;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('deliveries.' . $this->delivery->order_id);
    }

    public function broadcastWith(): array
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }

    public function broadcastAs(): string
    {
        return 'location-updated';
    }
}
