<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FriendController extends Controller
{
    public function postRemoveFriend(Request $request){
        $user = Auth::user();
        $user->friendsOfMine()->detach($request['friendId']);
        $user->friendOf()->detach($request['friendId']);
        return response()->json(200);
    }

    public function postFriendRequest(Request $request){    // send request

        $user = Auth::user();
        $user->sentRequests()->attach($request['friendId']);
        return response()->json(200);
    }

    public function postAcceptRequest(Request $request){    // accept the request
        $user = Auth::user();
        $user->receivedRequests()->detach($request['friendId']);
        $user->friendsOfMine()->attach($request['friendId']);
        return response()->json(200);
    }


    public function postCancelRequest(Request $request){    // cancel own request
        $user = Auth::user();
        $user->sentRequests()->detach($request['friendId']);
        return response()->json(200);
    }

    public function postDeleteRequest(Request $request){    // do not accept the request
        $user = Auth::user();
        $user->receivedRequests()->detach($request['friendId']);
        return response()->json(200);
    }

    protected function friendship_status($user1, $user2){
        $friendship = 0;    // no one has added the other
        $user1_friends = $user1->friends;
        foreach ($user1_friends as $friend){
            if($friend->id == $user2->id){
                $friendship = 2;        // two users are friends
                return $friendship;
            }
        }
        $result = $user1->sentRequests()->where('user2', $user2->id)->first();
        if (count($result)  != 0){
            $friendship = 1;        // user 1 has pending request to user 2
            return $friendship;
        }

        $result = $user2->sentRequests()->where('user2', $user1->id)->first();
        if (count($result)  != 0){
            $friendship = 3;    // user 2 has pending request to user 1
            return $friendship;
        }
        return $friendship;

    }
}






