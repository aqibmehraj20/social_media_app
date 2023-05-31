<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->likes = 0;
        $comment->dislikes = 0;
        $comment->post_id = $validatedData['post_id'];
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function likeComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $comment = Comment::findOrFail($validatedData['comment_id']);
        $comment->likes++;
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function dislikeComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $comment = Comment::findOrFail($validatedData['comment_id']);
        $comment->dislikes++;
        $comment->save();

        return response()->json(['success' => true]);
    }
}
