@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h3>Sign Up</h3>
            <form action="{{ route('signup') }}" method="post">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password">
                </div>
                <div class="form-group">
                    <label for="birth_date">Birth date</label>
                    <input class="form-control" type="date" name="birth_date" id="birth_date">
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="gender" id="male" value="male" checked>Male
                    </label>
                    <label>
                        <input type="radio" name="gender" id="female" value="female">Female
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>

        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group">
                    <label for="email">Your E-Mail</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>


@endsection