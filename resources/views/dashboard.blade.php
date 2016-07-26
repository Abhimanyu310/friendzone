@extends('layouts.master')

@section('content')
    @include('includes.message-block')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What do you have to say?</h3></header>
            <form action="{{ route('post.create') }}" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your Post"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>
    </section>

    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What other people say...</h3></header>
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <div class="media">
                        <div class="pull-left">
                            <img class="media-object img-circle" src="http://placehold.it/64x64" alt="">
                        </div>
                        <div class="media-body">
                            <p>
                                <a href="{{ route('user-profile', ['user_id' => $post->user->id]) }}">
                                    {{ $post->user->first_name }} {{ $post->user->last_name }}
                                </a>
                                <div class="info">
                                    Posted on {{ $post->created_at }}
                                </div>

                            </p>

                        </div>
                    </div>

                    <p class="post-body">{{ $post->body }}</p>

                    <div class="interaction">
                        <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ?
                         Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You liked this post'
                          : 'Like' : 'Like' }}</a> |
                        <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ?
                         Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You disliked this post'
                          : 'Dislike' : 'Dislike' }}</a> |
                        <a href="#commentstoggle{{ $post->id }}" class="comments" data-toggle="collapse">Comments</a>
                        @if(Auth::user() == $post->user)
                            |
                            <a href="#" class="edit">Edit</a> |
                            <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
                        @endif


                    </div>


                    <div class="collapse" id="commentstoggle{{ $post->id }}">
                        <div class="well">

                            @foreach($post->comments as $comment)
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="media-object img-circle" src="http://placehold.it/64x64" alt="">
                                    </div>
                                    <div class="media-body">
                                        <p>
                                            <a href="{{ route('user-profile', ['user_id' => $comment->user->id]) }}">
                                                {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                            </a>
                                            {{ $comment->body }}
                                            <small class="pull-right text-muted">{{ $comment->created_at }}</small>
                                        </p>

                                    </div>
                                </div>
                                <hr>
                            @endforeach



                            <h4>Leave a Comment:</h4>
                            <form method="post" action="{{ route('add.comment') }}">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="body"></textarea>
                                    <input type="hidden" name="postId" value="{{ $post->id }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Comment</button>
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                            </form>
                        </div>
                    </div>
                </article>

            @endforeach
        </div>
    </section>





    <!--Edit Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="post-body">Edit the post</label>
                        <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
        var urlLike = '{{ route('like') }}';
    </script>


@endsection