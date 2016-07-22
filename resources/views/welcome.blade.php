@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')

    @if($errors->has('password'))
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->get('password') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <h3>Sign Up</h3>
            <form action="{{ route('signup') }}" method="post">

                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name">First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name"
                           value="{{ Request::old('first_name') }}">
                    @if ($errors->has('first_name'))
                        <span class="help-block">{{$errors->first('first_name')}}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <label for="last_name">Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name"
                           value="{{ Request::old('last_name') }}">
                    @if ($errors->has('last_name'))
                        <span class="help-block">{{$errors->first('last_name')}}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">E-Mail</label>
                    <input class="form-control" type="email" name="email" id="email"
                           value="{{ Request::old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">{{$errors->first('email')}}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="confirm_password">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                    <label for="birth_date">Birth date</label>
                    <input class="form-control" type="date" name="birth_date" id="birth_date">
                    @if ($errors->has('birth_date'))
                        <span class="help-block">{{$errors->first('birth_date')}}</span>
                    @endif
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="gender" id="male" value="male" checked>Male
                    </label>
                    <label>
                        <input type="radio" name="gender" id="female" value="female"
                                {{ Request::old('gender') == 'female' ? 'checked' : ''}}>Female
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>

        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your E-Mail</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>


@endsection