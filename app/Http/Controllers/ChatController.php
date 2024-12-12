<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'message' => $request->message,
        ]);
    
        broadcast(new NewMessage($message))->toOthers();
    
        return response()->json(['message' => $message]);
    }
    
    public function getMessages($userId)
    {
        return Message::where(function ($query) use ($userId) {
            $query->where('from_user_id', auth()->id())
                  ->where('to_user_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('from_user_id', $userId)
                  ->where('to_user_id', auth()->id());
        })->orderBy('created_at')->get();
    }
    
}
