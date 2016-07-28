<?php

namespace App\Http\Controllers;


use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function postAddComment(Request $request){
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $user = Auth::user();
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $comment = new Comment();
        $comment->body = $request['body'];
        $comment->user()->associate($user);
        $comment->post()->associate($post);
        $comment->save();

        return response()->json([
            'body' => $comment->body,
            'id' => $comment->id,
            'created_at' => $comment->created_at->diffForHumans(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name
        ], 200);
    }

    public function postDeleteComment(Request $request){
        $comment_id = $request['commentId'];
        $comment = Comment::find($comment_id);
        if (!$comment){
            return null;
        }
        $comment->delete();
        return response()->json(200);
    }
}