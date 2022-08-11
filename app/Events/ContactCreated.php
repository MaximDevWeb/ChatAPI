<?php

namespace App\Events;

use App\Models\Contact;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    private int $contact_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($login, $contact_id)
    {
        $this->message = "Пользователь $login добавил Вас в Контакты";
        $this->contact_id = $contact_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('contacts');
    }

    public function broadcastAs()
    {
        return 'contacts.created.' . $this->contact_id;
    }
}
