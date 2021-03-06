<?php

namespace App\Http\Controllers;


use App\User;
use GuzzleHttp\Client;
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

        $recaptcha_token = $request['g-recaptcha-response'];
        if ($recaptcha_token){
            $guzzle_client = new Client();
            $recaptcha_response = $guzzle_client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => array(
                    'secret' => '6Lf_ACYTAAAAAJFGWKZsRWE8vjk3iqDSFnMpA-qW',
                    'response' => $recaptcha_token
                )
            ]);
            $result = json_decode($recaptcha_response->getBody()->getContents());
            if(!$result->success){      // verification failed
                return redirect()->back();
            }
        }

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

//    public function postRemoveFriend(Request $request){
//        $user = Auth::user();
//        $user->friendsOfMine()->detach($request['friendId']);
//        $user->friendOf()->detach($request['friendId']);
//        return response()->json(200);
//    }
//
//    public function postFriendRequest(Request $request){    // send request
//
//        $user = Auth::user();
//        $user->sentRequests()->attach($request['friendId']);
//        return response()->json(200);
//    }
//
//    public function postAcceptRequest(Request $request){    // accept the request
//        $user = Auth::user();
//        $user->receivedRequests()->detach($request['friendId']);
//        $user->friendsOfMine()->attach($request['friendId']);
//        return response()->json(200);
//    }
//
//
//    public function postCancelRequest(Request $request){    // cancel own request
//        $user = Auth::user();
//        $user->sentRequests()->detach($request['friendId']);
//        return response()->json(200);
//    }
//
//    public function postDeleteRequest(Request $request){    // do not accept the request
//        $user = Auth::user();
//        $user->receivedRequests()->detach($request['friendId']);
//        return response()->json(200);
//    }
//
//    protected function friendship_status($user1, $user2){
//        $friendship = 0;    // no one has added the other
//        $user1_friends = $user1->friends;
//        foreach ($user1_friends as $friend){
//            if($friend->id == $user2->id){
//                $friendship = 2;        // two users are friends
//                return $friendship;
//            }
//        }
//        $result = $user1->sentRequests()->where('user2', $user2->id)->first();
//        if (count($result)  != 0){
//            $friendship = 1;        // user 1 has pending request to user 2
//            return $friendship;
//        }
//
//        $result = $user2->sentRequests()->where('user2', $user1->id)->first();
//        if (count($result)  != 0){
//            $friendship = 3;    // user 2 has pending request to user 1
//            return $friendship;
//        }
//        return $friendship;
//
//    }

    public function getUpdates(){
        $user = Auth::user();
        $friend_requests = $user->receivedRequests()->get();
        $user_requests = array();
        foreach ($friend_requests as $friend_request){
            $user_id = $friend_request->id;
            $user = User::find($user_id);
            $user_requests[$user->id] = [$user->first_name, $user->last_name];
        }
        return view('accounts.zone-updates', ['user_requests' => $user_requests]);
    }


}

