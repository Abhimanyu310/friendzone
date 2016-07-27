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

//    public function postLikePost(Request $request){
//        $post_id = $request['postId'];
//        $is_like = $request['isLike'] === 'true';       //true means clicked on like, false = click dislike
//        $update = false;
//        $post = Post::find($post_id);
//        if (!$post){
//            return null;
//        }
//        $user = Auth::user();
//        $like = $user->likes()->where('post_id', $post_id)->first();    //find if an entry
//        if ($like){                         // if a user has already liked or disliked
//            $already_like = $like->like;    // true means we already like it. false means already disliked
//            $update = true;                 // we have an entry so gonna update it
//            if ($already_like == $is_like){     // we liked and again clicked on it or vice versa
//                $like->delete();            // undo the like or dislike
//                return null;
//            }
//        } else {     // no entry for user in like or the user now clicked on the other button(update)
//            $like = new Like();
//        }
//        $like->like = $is_like;
//        $like->user_id = $user->id;
//        $like->post_id = $post->id;
//        if ($update){       // user clicked on other button(update)
//            $like->update();
//        } else{
//            $like->save();      // there was no entry so new created
//        }
//        return null;
//
//    }


    public function postLikePost(Request $request){
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $user = Auth::user();
        // check if disliked...then delete
        $dislike = $user->dislikes()->where('post_id', $post_id)->first();
        if($dislike){
            $dislike->delete();
        }
        $like = new Like();
        $like->post()->associate($post);
        $like->user()->associate($user);
        $like->save();
        return null;
    }

    public function postDislikePost(Request $request){
        $post_id = $request['postId'];
        $post = Post::find($post_id);
        if (!$post){
            return null;
        }
        $user = Auth::user();
        // check if liked...then delete
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $like->delete();
        }
        $dislike = new Dislike();
        $dislike->post()->associate($post);
        $dislike->user()->associate($user);
        $dislike->save();
        return null;
    }


}