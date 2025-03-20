<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer'],
        ]);

        Chat::create([
            'message' => $request->message,
            'receiver_id' => $request->receiver_id,
            'sender_id' => auth()->id(),
        ]);

         //update seen status
         Chat::where('sender_id', $request->receiver_id)
         ->where('receiver_id', auth()->id())
         ->where('seen', 0)
         ->update(['seen' => 1]);

        $avatar = asset(auth()->user()->avatar);

        $senderId = auth()->id();
        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, $senderId))->toOthers();

        return response(['status' => 'success', 'msg_id' => $request->msg_temp_id]);
    }

    public function getConversation($senderId)
    {
        $receiverId = 1;

        //update seen status
        Chat::where('sender_id', $receiverId)
            ->where('receiver_id', auth()->id())
            ->where('seen', 0)
            ->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }
}