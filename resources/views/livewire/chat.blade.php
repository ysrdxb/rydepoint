<div class="container-fluid chat-page">
    <div class="row chat-container shadow-sm">
        <div class="col-3 chat-sidebar bg-light p-3">
            <h5 class="sidebar-title">Conversations</h5>
            <ul class="conversation-list list-unstyled">
                @foreach($conversations as $conversation)
                    <li wire:click="selectConversation({{ $conversation->id }})"
                        class="conversation-item {{ $selectedConversation && $selectedConversation->id === $conversation->id ? 'active' : '' }}">
                        <a href="javascript:void(0)" class="conversation-link">
                            {{ $conversation->user1_id === Auth::id() ? $conversation->user2->name : $conversation->user1->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-9 chat-area bg-white d-flex flex-column">
            @if ($selectedConversation)
                <div class="chat-header bg-primary text-white p-3">
                    <h6 class="m-0">
                        Chat with
                        {{ $selectedConversation->user1_id === Auth::id() ? $selectedConversation->user2->name : $selectedConversation->user1->name }}
                    </h6>
                </div>
                <div class="chat-messages flex-grow-1 p-3 overflow-auto">
                    @foreach($messages as $message)
                        <div class="message-item {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }} mb-3">
                            <div class="message-sender text-muted mb-1">
                                {{ $message->sender->name }}
                            </div>
                            <div class="message-content p-2 rounded">
                                <p class="m-0">{{ $message->message }}</p>
                            </div>
                            <div class="message-time text-muted small mt-1">
                                {{ $message->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="chat-input bg-light p-3 d-flex align-items-center">
                    <input type="text" wire:model="messageText" class="form-control" placeholder="Type a message...">
                    <button wire:click="sendMessage" class="btn btn-primary ml-2">Send</button>
                </div>
            @else
                <div class="no-conversation text-center d-flex flex-grow-1 justify-content-center align-items-center">
                    <p class="text-muted">Select a conversation to start chatting</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('head')
<style>
.chat-page {
    height: 100vh;
    background: #f0f2f5;
}
.chat-container {
    height: 100%;
    display: flex;
}
.chat-sidebar {
    border-right: 1px solid #ddd;
    overflow-y: auto;
}
.sidebar-title {
    font-weight: bold;
    margin-bottom: 20px;
    color: #6c757d;
}
.conversation-item {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}
.conversation-item:hover,
.conversation-item.active {
    background-color: #e0e0e0;
    color: #007bff;
}
.conversation-link {
    text-decoration: none;
    color: inherit;
    display: block;
    font-weight: bold;
}
.chat-header {
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}
.chat-messages {
    overflow-y: auto;
    background: #f0f2f5;
    padding: 15px;
}
.message-item {
    max-width: 60%;
}
.message-item.sent {
    margin-left: auto;
    text-align: right;
}
.message-item.received {
    margin-right: auto;
    text-align: left;
}
.message-sender {
    font-size: 0.85rem;
    font-weight: bold;
    color: #6c757d;
}
.message-content {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 10px;
    word-wrap: break-word;
}
.message-item.sent .message-content {
    background-color: #dcf8c6;
    color: #000;
}
.message-item.received .message-content {
    background-color: #ffffff;
    color: #000;
    border: 1px solid #ddd;
}
.message-time {
    font-size: 0.75rem;
    color: #8c8c8c;
    text-align: right;
}
.message-item.received .message-time {
    text-align: left;
}
.chat-input {
    border-top: 1px solid #ddd;
}
.chat-input input {
    border-radius: 20px;
    padding: 10px;
}
.chat-input button {
    border-radius: 20px;
    padding: 10px 20px;
}
</style>
@endpush
