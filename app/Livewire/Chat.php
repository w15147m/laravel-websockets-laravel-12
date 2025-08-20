<?php
namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage;
    public $messages;
    public $user = null;
    public $loginID;

    public function mount()
    {
        $this->user = User::where('id', Auth::id())->first();
        $this->users = User::where('id', '!=', Auth::id())->get();
        $this->selectedUser = $this->users->first();
        $this->loginID = Auth::id(); // Fix: Assign to property, not local variable
        $this->loadMessages();
    }

    private function loadMessages()
    {
        $this->messages = ChatMessage::query()
            ->where(function ($q) {
                $q->where("sender_id", Auth::id())
                    ->where("receiver_id", $this->selectedUser->id);
            })
            ->orWhere(function ($q) {
                $q->where("sender_id", $this->selectedUser->id)
                    ->where("receiver_id", Auth::id());
            })->get();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat');
    }

    public function submit()
    {
        if (! $this->newMessage) {
            return;
        }

        $message = ChatMessage::create([
            "sender_id"   => $this->user->id,
            "receiver_id" => $this->selectedUser->id,
            "message"     => $this->newMessage,
        ]);

        $this->messages->push($message);
        $this->newMessage = '';
        broadcast(new MessageSent($message));
    }

    public function getListeners()
    {
        return [
            // Fix: Correct syntax and channel name
            "echo-private:chat.{$this->loginID},MessageSent" => "newChatMessageNotification",
        ];
    }

    public function newChatMessageNotification($message)
    {
        \Log::info('New message received:', $message); // Better logging

        if ($message['sender_id'] == $this->selectedUser->id) {
            $messageObj = ChatMessage::find($message['id']); // Fix: Typo in model name
            $this->messages->push($messageObj);
        }
    }
}
