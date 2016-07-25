@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">

                <div class="card hovercard">
                    <div class="cardheader"  style="background:  url('{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}');background-size: cover">

                    </div>
                    <div class="avatar">
                        <img alt="" src="{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}">
                    </div>
                    <div class="info">
                        <div class="title">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </div>
                    </div>

                </div>

            </div>

            <div class="btn-pref btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" id="bio" class="btn btn-primary" href="#bio-tab" data-toggle="tab">
                        <div class="hidden-xs">Bio</div>
                    </button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="posts" class="btn btn-default" href="#posts-tab" data-toggle="tab">
                        <div class="hidden-xs">Posts</div>
                    </button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="friends" class="btn btn-default" href="#friends-tab" data-toggle="tab">
                        <div class="hidden-xs">Friends</div>
                    </button>
                </div>
            </div>


            <div class="tab-content">
                <div class="tab-pane fade in active" id="bio-tab">
                    <h3>This is tab 1</h3>
                </div>
                <div class="tab-pane fade in" id="posts-tab">
                    <h3>This is tab 2</h3>
                </div>
                <div class="tab-pane fade in" id="friends-tab">
                    <h3>This is tab 3</h3>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('styles')
    <script src="{{ URL::to('src/js/user-profile.js') }}"></script>
@endsection