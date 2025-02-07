<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'content'=> 'required|string|max:500',
        ]);

        $message = Message::create([
            'username' => $request->username,
            'content' => $request->content,
            'like' => 0
        ]);

        return response()->json(['message' => 'Message enregistré'],200);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'nb_message' => 'nullable|integer|min:1|max:50',
            'page' => 'nullable|integer|min:1'
        ]);

        $nb_message = $request->nb_message ?? 30;
        $message = Message::Latest()->paginate($nb_message)->toArray();
        return response()->json($message);
    }

    public function addLike(Request $request)
    {
        $request->validate([
            'message_id' => 'required'
        ]);
        $message_id = $request->message_id;
        $message = Message::where('id',$message_id)->increment('like');

        return response()->json(['message'=>'Like ajouté'],200);
    }
}
