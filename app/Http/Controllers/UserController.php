<?php

namespace App\Http\Controllers;


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
            $user_friends = $auth_user->friends;
            $friendship = false;
            foreach ($user_friends as $friend){
                if($friend->id == $other_user->id){
                    $friendship = true;
                    break;
                }
            }
            return view('accounts.user-profile', [
                'user' => $other_user, 'friendship' => $friendship
            ]);
        }
        return view('accounts.user-profile', ['user' => $auth_user]);
    }

    public function postRemoveFriend($friend_id){

    }

    public function postAddFriend($friend_id){
        $user = Auth::user();
        $user->friendsOfMine()->attach($friend_id);
        return redirect()->route('dashboard');
    }

}