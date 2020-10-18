<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Chat;
use App\Events\ChatMessage;

class ChatController extends Controller
{
    public function getUserConversationById(Request $request)
    {
    	$userId = $request->input('id');
    	$authUserId = $request->user()->id;
    	$chats = Chat::whereIn('sender_id', [$authUserId, $userId])
    		->whereIn('receiver_id', [$authUserId, $userId])
    		->orderBy('created_at', 'asc')
    		->get();

    		return response(['data' => $chats], 200);
    }

    public function addChatToConversation(Request $request)
    {
    	$senderId = $request->user()->id;
    	$receiverId = $request->input('receiver_id');
    	$message = $request->input('message');

    	$data = [
    		'sender_id' => $senderId,
    		'receiver_id' => $receiverId,
    		'message' => $message,
    		'read' => 0
    	];

    	$chat = Chat::create($data);

    	$finalData = Chat::where('id', $chat->id)->first();

    	//event(new ChatMessage($chat));

    	return response(['data' => $finalData], 201);
    }

    function getChatNotifications(Request $request)
    {
        $chatNotifications = Chat::where('read', 0)
            ->where('receiver_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

            return response(['data' => $chatNotifications], 200);
    }

}
