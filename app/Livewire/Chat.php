<?php
namespace App\Livewire;

use App\Events\MassageSend;
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
        $this->user         = User::where('id', Auth::id())->first();
        $this->users        = User::where('id', '!=', Auth::id())->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();
        $loginID = Auth::id();

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

        $massage = ChatMessage::create([
            "sender_id"   => $this->user->id,
            "receiver_id" => $this->selectedUser->id,
            "message"     => $this->newMessage,
        ]);
        $this->messages->push($massage);
        $this->newMessage = '';
    }



}
