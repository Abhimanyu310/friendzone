<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function postSignUp(Request $request){

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
        return redirect()->back();

    }
    public function postSignIn(Request $request){

    }
}