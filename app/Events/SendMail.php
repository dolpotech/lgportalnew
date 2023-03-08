<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * For Notification Instance
     *
     * @var Notification
     */
    public $emails;
    public $title;
    public $description;
    /**
     * Create a new event instance.
     *
     * @param $emails
     * @param $title
     * @param $description
     * @return void
     */
    public function __construct($emails, $title, $description)
    {
        $this->emails = $emails;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
//        return new PrivateChannel('channel-name');
    }
}
