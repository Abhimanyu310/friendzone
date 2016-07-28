@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
{{--TODO Add Notifications stuff..Controller--}}
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Zone requests</h3>
                @foreach($user_requests as $user_id => $user_name)
                    <div class="well" data-userid="{{ $user_id }}">
                        <a href="{{ route('user-profile',
                        ['user_id' => $user_id]) }}">{{ $user_name[0] }}
                            {{ $user_name[1] }}</a> wants to add you to their zone
                        <button type="button" class="btn btn-success btn-sm">
                            <span class="glyphicon glyphicon-ok accept-request-notification"></span>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm">
                            <span class="glyphicon glyphicon-remove delete-request-notification"></span>
                        </button>
                    </div>
                @endforeach

            </div>

            <div class="col-md-6">
                <h3>Notifications</h3>
                <div class="well">
                    asda
                </div>
            </div>
        </div>
    </div>

    <script>
        var token = '{{ Session::token() }}';
        var urlDeleteRequest = '{{ route('delete.request') }}';
        var urlAcceptRequest = '{{ route('accept.request') }}';

    </script>

@endsection

@section('styles')
    <script src="{{ URL::to('src/js/zone-updates.js') }}"></script>
@endsection


