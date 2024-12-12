<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $conversations = [];
    public $selectedConversation = null; // Stores the selected conversation model
    public $messages = []; // Stores messages of the selected conversation
    public $messageText = ''; // The text of the message to be sent
    public $vendorId = null; // The ID of the vendor for initializing a chat

    public function mount($vendorId = null)
    {
        $this->vendorId = $vendorId; // Set vendor ID if passed
        $this->loadConversations();

        if ($vendorId) {
            $this->startOrSelectConversation($vendorId);
        }
    }

    public function loadConversations()
    {
        $userId = Auth::id();
    
        $this->conversations = Conversation::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->with(['user1', 'user2'])
            ->latest()
            ->get();
    } 

    public function startOrSelectConversation($vendorId)
    {
        $userId = Auth::id();

        // Ensure the vendor exists
        $vendor = User::find($vendorId);
        if (!$vendor) {
            session()->flash('error', 'The selected vendor does not exist.');
            return;
        }

        // Check if a conversation already exists
        $conversation = Conversation::where(function ($query) use ($userId, $vendorId) {
            $query->where('user1_id', $userId)->where('user2_id', $vendorId);
        })->orWhere(function ($query) use ($userId, $vendorId) {
            $query->where('user1_id', $vendorId)->where('user2_id', $userId);
        })->first();

        // Create a new conversation if none exists
        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => $userId,
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
            $userId = Auth::id();
            $vendorId = $this->vendorId;
    
            if (!$vendorId) {
                session()->flash('error', 'No vendor selected for the conversation.');
                return;
            }
    
            $conversation = Conversation::firstOrCreate(
                [
                    ['user1_id', '=', $userId],
                    ['user2_id', '=', $vendorId],
                ],
                [
                    'user1_id' => $userId,
                    'user2_id' => $vendorId,
                ]
            );
    
            $this->selectedConversation = $conversation;
            $this->loadConversations();
        }
    
        $message = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => Auth::id(),
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
