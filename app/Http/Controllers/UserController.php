<?php

namespace App\Http\Controllers;


use App\FriendRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function getHome(Request $request){
        return view('welcome');
    }

    public function postSignUp(Request $request){

        $this->validate($request, [
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'birth_date' => 'required',
            'gender' => 'required'
        ]);
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $password = bcrypt($request['password']);
        $birth_date = $request['birth_date'];
        $gender = $request['gender'];

        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = $password;
        $user->birth_date = $birth_date;
        $user->gender = $gender;

        $user->save();
        Auth::login($user);

        return redirect()->route('dashboard');

    }
    public function postSignIn(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password']
        ])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount(){
        return view('accounts.account-settings', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request){
        $this->validate($request, [
            'first_name' => 'required|max:120'
        ]);
        $user = Auth::user();
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        if($file){
            Storage::disk('local')->put($filename, File::get($file));
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename){
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
    
    public function getUserProfile($user_id = null){
        $auth_user = Auth::user();
        if(!is_null($user_id)){
            $other_user = User::find($user_id);
            $friendship = $this->friendship_status($auth_user, $other_user);
            return view('accounts.user-profile', [
                'user' => $other_user, 'friendship' => $friendship
            ]);
        }
        return view('accounts.user-profile', ['user' => $auth_user]);
    }

    public function postRemoveFriend($friend_id){
        $user = Auth::user();
        $user->friendsOfMine()->detach($friend_id);
        $user->friendOf()->detach($friend_id);
        return redirect()->route('dashboard');
    }

    public function postFriendRequest(Request $request){
        $user = Auth::user();
        $friend_request = new FriendRequest();
        $friend_request->user1 = $user->id;
        $friend_request->user2 = $request['friendId'];
        $friend_request->save();
        return response()->json(200);
    }

    public function postCancelRequest(Request $request){    // cancel own request
        $user = Auth::user();
        $friend_request = FriendRequest::where(['user1' => $user->id, 'user2' => $request['friendId']]);
        $friend_request->delete();
        return response()->json(200);
    }

    public function postDeleteRequest(Request $request){    // do not accept the request
        $user = Auth::user();
        $friend_request = FriendRequest::where(['user2' => $user->id, 'user1' => $request['friendId']]);
        $friend_request->delete();
        return response()->json(200);
    }

    public function postAddFriend($friend_id){
        $user = Auth::user();
        $user->friendsOfMine()->attach($friend_id);
        return redirect()->route('dashboard');
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
        $result = FriendRequest::where(['user1' => $user1->id, 'user2' => $user2->id])->get();
        if (count($result)  != 0){
            $friendship = 1;        // user 1 has pending request to user 2
            return $friendship;
        }

        $result = FriendRequest::where(['user1' => $user2->id, 'user2' => $user1->id])->get();
        if (count($result)  != 0){
            $friendship = 3;    // user 2 has pending request to user 1
            return $friendship;
        }
        return $friendship;

    }

    public function getUpdates(){
        return view('accounts.zone-updates');
    }


}

