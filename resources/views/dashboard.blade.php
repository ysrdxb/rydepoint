<h1>Your Conversations</h1>
<ul>
    @foreach ($conversations as $conversation)
        <li>
            <a href="{{ route('chat', ['conversationId' => $conversation->id]) }}">
                Conversation with {{ $conversation->user_one_id === auth()->id() ? 'User ' . $conversation->user_two_id : 'User ' . $conversation->user_one_id }}
            </a>
        </li>
    @endforeach
</ul>
