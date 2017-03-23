@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-4">
            <ul class="nav nav-pills nav-stacked nav-fixed-top">
                <li role="presentation">
                    <a href="/">
                        @if(Auth::user()->profile_img == NULL)
                            <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 30px; height: 30px; !important;">
                        @else
                            <img src="{{Auth::user()->profile_img}}" alt="Profile img" style="width: 30px; height: 30px; !important;">
                        @endif
                        {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                    </a>
                </li>
                <li role="presentation" class="active"><a>News Feed</a></li>
                <li role="presentation" class="disabled"><a>Messages</a></li>
            </ul>
            <a href="" class="text-muted">Terms</a> - <a href="" class="text-muted">Privacy</a><p class="text-muted">&copy; Jack Douglas 2017</p>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{route('post.create')}}" method="post">
                        {{csrf_field()}}
                        <textarea class="form-control" name="body" rows="5" style="max-width: 100%;" placeholder="Write a new post"></textarea><br>
                        <input type="submit" name="post" class="btn btn-sm btn-primary" style="margin-right: 10px; !important;" value="Post"><span class="text-muted"><i class="fa fa-camera" aria-hidden="true"></i> Photo/Video</span>
                    </form>
                </div>
            </div>
            @foreach($posts as $post)
                <div class="panel panel-default" data-postid="{{$post->id}}" data-postBody="{{$post->body}}">
                    <div class="panel-heading">
                        @if($post->user->profile_img == NULL)
                            <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 30px; height: 30px; !important;">
                        @else
                        <img src="{{$post->user->profile_img}}" alt="Profile img" style="width: 30px; height: 30px; !important;">
                        @endif
                        <a href="{{route('profile', $post->user->username)}}">
                            {{$post->user->first_name}} {{$post->user->last_name}}
                        </a>
                        <small>at: {{$post->updated_at}}</small>
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <div class="panel-body" id="postText">
                        <p class="postContent">
                        {{$post->body}}
                        </p>
                    </div>
                    <div class="panel-footer post">
                        <div class="interaction">
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a>
                            @if (!count($post->comments))
                                <a role="button" data-toggle="collapse" href="#no-comments-{{$post->id}}" aria-expanded="false" aria-controls="no-comments-{{$post->id}}">Comment</a>
                            @endif
                            @if(Auth::user() == $post->user)
                                <a href="#" class="edit">Edit</a>
                                <a href="{{route('post.delete', ['post_id' => $post->id])}}">Delete</a>
                            @endif
                        </div>
                    </div>
                    @if (count($post->comments))
                        @foreach($post->comments as $comment)
                            <div class="panel-body">
                                {{$comment->content}}
                            </div>
                            <div class="panel-footer">
                                <input type="text" class="form-control" placeholder="Write a comment">
                            </div>
                        @endforeach
                    @else
                        <div class="collapse" id="no-comments-{{$post->id}}">
                            <div class="panel-footer">
                                <input type="text" class="form-control" placeholder="Write a comment">
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Post</h4>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <div class="form-group">
                                    <label for="post-body">Edit the Post</label>
                                    <textarea name="post-body" id="post-body" class="form-control" rows="5"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var token = "{{csrf_token()}}";
        var urlLike = '{{ route('like') }}';
    </script>
@endsection