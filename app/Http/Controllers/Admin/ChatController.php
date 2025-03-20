<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $senders = Chat::select('sender_id')
        ->where('receiver_id', $userId)
        ->where('sender_id', '!=', $userId)
        ->selectRaw('MAX(created_at) as last_message_date')
        ->groupBy('sender_id')
        ->orderBy('last_message_date', 'desc')
        ->get();

        return view('admin.chat.index', compact('senders'));
    }

    public function getConversation($senderId)
    {
        $receiverId = auth()->id();

        //update seen status
        Chat::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('seen', 0)
            ->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

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
        Chat::where('sender_id',$request->receiver_id)
            ->where('receiver_id',auth()->id())
            ->where('seen',0)
            ->update(['seen' => 1]);

        $avatar = asset(auth()->user()->avatar);
        $senderId = auth()->id();
        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, $senderId))->toOthers();

        return response(['status' => 'success', 'msg_id' => $request->msg_temp_id]);
    }
}