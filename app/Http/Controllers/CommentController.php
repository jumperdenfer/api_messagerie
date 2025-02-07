<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function sendComment(Request $request)
    {
        $request->validate([
            'message_id'=>'required|exists:messages,id',
            'username'=> 'required|string|max:50',
            'content'=> 'required|string|max:500'
        ]);

        Comment::create([
            'message_id' => $request->message_id,
            'username' => $request->username,
            'content' => $request->content
        ]);

        return response()->json(['message'=>'commentaire ajouté'],200);
    }

    public function getComments(Request $request)
    {
        $request->validate([
            'message_id'=> 'required|exists:messages,id',
            'nb_comment' => 'nullable|integer|min:1|max:50',
            'page' => 'nullable|integer|min:1'
        ]);
        $nb_comment = $request->nb_comment ?? 30;
        $comments = Comment::where('message_id',$request->message_id)
            ->latest()
            ->paginate($nb_comment);
        return response()->json($comments);
    }
}
