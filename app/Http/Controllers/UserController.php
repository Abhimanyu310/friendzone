<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDashboard(Request $request){
        return view('dashboard');
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
}