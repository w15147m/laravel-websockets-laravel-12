<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Broadcasting\PrivateChannel;

// We use ShouldBroadcastNow for real-time delivery
class NewChatMessage extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ChatMessage $message)
    {
        //
    }


    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }


    public function broadcastOn(): array
    {
        // Broadcast on a private channel specific to the receiver's ID
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
        ];
    }


    public function toBroadcast($notifiable): array
    {
        return [
            "id" => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
        ];
    }


    public function toDatabase($notifiable): array
    {
        $sender = $this->message->sender;

        return [
            'message_id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $sender ? $sender->name : 'Unknown User',
            'preview' => Str::limit($this->message->message, 50),
            'url' => route('chat', ['user' => $sender->id]),
        ];
    }
}
