@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card hovercard">
                    <div class="cardheader"  style="background:  url('{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}');background-size: cover">

                    </div>
                    <div class="avatar">
                        <img alt="" src="{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}">
                    </div>

                    <div class="info">
                        <div class="title" data-userid="{{ $user->id }}">
                            {{ $user->first_name }} {{ $user->last_name }}
                            <br>
                            @if(Auth::user()->id != $user->id)
                                @if($friendship == 2)
                                    <button type="button" class="btn btn-danger remove-friend">Remove from zone</button>
                                @elseif($friendship == 0)
                                    <button type="button" class="btn btn-info add-friend">Add to Zone</button>
                                @else
                                    <button type="button" class="btn btn-warning pending">Zone request pending</button>
                                    <button type="button" class="btn btn-danger cancel-request">Cancel zone request</button>

                                @endif

                            @endif



                        </div>
                    </div>

                </div>

            </div>

            <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group">
                <div class="btn-group" role="group" title="Bio">
                    <button type="button" id="bio" class="btn btn-primary" href="#bio-tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <div class="hidden-xs">Bio</div>
                    </button>
                </div>
                <div class="btn-group" role="group" title="Posts">
                    <button type="button" id="posts" class="btn btn-default" href="#posts-tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-list"></span>
                        <div class="hidden-xs">Posts</div>
                    </button>
                </div>
                <div class="btn-group" role="group" title="Friends">
                    <button type="button" id="friends" class="btn btn-default" href="#friends-tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-user"></span>
                        <div class="hidden-xs">Friends</div>
                    </button>
                </div>
            </div>



            <div class="tab-content">
                <div class="tab-pane fade in active" id="bio-tab">
                    <h3>User info</h3>
                </div>
                <div class="tab-pane fade in" id="posts-tab">
                    <h3>All posts</h3>
                </div>
                <div class="tab-pane fade in" id="friends-tab">
                    <h3>List of friends</h3>
                </div>
            </div>


        </div>
    </div>

    <script>
        var token = '{{ Session::token() }}';
        var urlFriendRequest = '{{ route('friend.request') }}';

    </script>

@endsection

@section('styles')
    <script src="{{ URL::to('src/js/user-profile.js') }}"></script>
@endsection