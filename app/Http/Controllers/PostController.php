<?php

namespace App\Http\Controllers;


use App\Dislike;
use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function getDashboard(Request $request){
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = Auth::user();

        return view('dashboard', ['posts' => $posts, 'user' => $user]);
    }

    public function getDeletePost($post_id){
        $post = Post::where('id', $post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Successfully deleted']);
    }

    public function postCreatePost(Request $request){
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->body = $request['body'];
        $message = 'There was an error';
        if($request->user()->posts()->save($post)){
            $message = 'Post successfully created';
        }

        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function postEditPost(Request $request){
        $this->validate($request, [
            'body' => 'required|max:1000|min:1'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }


    public function postLikePost(Request $request){
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $user = Auth::user();

        //check if already liked...then delete and return
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $like->forceDelete();
            return response()->json(['status' => 'unliked'], 200);
        }

        // check if disliked...then delete
        $dislike = $user->dislikes()->where('post_id', $post_id)->first();
        $toggle = null;
        if($dislike){
            $dislike->forceDelete();
            $toggle = true;

        }
        $like = new Like();
        $like->post()->associate($post);
        $like->user()->associate($user);
        $like->save();
        return response()->json(['status' => 'liked', 'toggle' => $toggle], 200);
    }

    public function postDislikePost(Request $request){
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $user = Auth::user();

        //check if already disliked...then delete and return
        $dislike = $user->dislikes()->where('post_id', $post_id)->first();
        if($dislike){
            $dislike->forceDelete();
            return response()->json(['status' => 'undisliked'], 200);
        }

        // check if liked...then delete
        $like = $user->likes()->where('post_id', $post_id)->first();
        $toggle = null;
        if($like){
            $like->forceDelete();
            $toggle = true;
        }
        $dislike = new Dislike();
        $dislike->post()->associate($post);
        $dislike->user()->associate($user);
        $dislike->save();
        return response()->json(['status' => 'disliked', 'toggle' => $toggle], 200);    }


}