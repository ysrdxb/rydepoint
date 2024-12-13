<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    private $userId;
    public $conversations = [];
    public $selectedConversation = null;
    public $messages = [];
    public $messageText = '';
    public $vendorId = null;

    public function mount($encryptedId)
    {
        $this->userId = decrypt($encryptedId);
        if (Auth::id() !== $this->userId) {
            abort(403);
        }

        $this->vendorId = $userId;
        $this->loadConversations();

        if ($vendorId) {
            $this->startOrSelectConversation($vendorId);
        }
    }

    public function loadConversations()
    {
        $this->conversations = Conversation::where('user1_id', $this->userId)
            ->orWhere('user2_id', $this->userId)
            ->with(['user1', 'user2'])
            ->latest()
            ->get();
    }

    public function startOrSelectConversation($vendorId)
    {
        $vendor = User::find($vendorId);
        if (!$vendor) {
            session()->flash('error', 'The selected vendor does not exist.');
            return;
        }

        $conversation = Conversation::where(function ($query) use ($vendorId) {
            $query->where('user1_id', $this->userId)->where('user2_id', $vendorId);
        })->orWhere(function ($query) use ($vendorId) {
            $query->where('user1_id', $vendorId)->where('user2_id', $this->userId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => $this->userId,
                'user2_id' => $vendorId,
            ]);
        }

        $this->selectConversation($conversation->id);
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversation = Conversation::find($conversationId);

        if ($this->selectedConversation) {
            $this->messages = $this->selectedConversation->messages()
                ->with('sender')
                ->oldest()
                ->get();
        } else {
            $this->messages = [];
        }
    }

    public function sendMessage()
    {
        if (empty($this->messageText)) {
            return;
        }

        if (!$this->selectedConversation) {
            $conversation = Conversation::firstOrCreate(
                [
                    ['user1_id', '=', $this->userId],
                    ['user2_id', '=', $this->vendorId],
                ],
                [
                    'user1_id' => $this->userId,
                    'user2_id' => $this->vendorId,
                ]
            );

            $this->selectedConversation = $conversation;
            $this->loadConversations();
        }

        $message = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => $this->userId,
            'message' => $this->messageText,
        ]);

        $this->messages[] = $message->load('sender');
        $this->messageText = '';
    }

    public function render()
    {
        return view('livewire.chat', [
            'conversations' => $this->conversations,
            'messages' => $this->messages,
        ]);
    }
}
