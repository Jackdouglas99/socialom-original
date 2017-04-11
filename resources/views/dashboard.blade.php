@extends('layouts.master')

@section('title')
Socialom
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-4">
            <ul class="nav nav-pills nav-stacked nav-fixed-top">
                <li role="presentation">
                    <a href="{{route('profile', Auth::user()->username)}}">
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
            <a href="{{route('terms')}}" class="text-muted">Terms</a> - <a href="{{route('privacy')}}" class="text-muted">Privacy</a><br><p class="text-muted">&copy; <a href="https://www.jackdouglas.co.uk" class="text-muted">Jack Douglas</a> 2017</p>
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
                            @if($post->user_id != Auth::user()->id)
                                <div class="pull-right">
                                    <a href="#" data-toggle="modal" data-target="#report-{{$post->id}}" href="#report-{{$post->id}}">Report post</a>
                                </div>
                            @endif
                    </div>
                    <div class="panel-body" id="postText">
                        <p class="postContent">
                        {{$post->body}}
                        </p>
                    </div>
                    <div class="panel-footer post">
                        <div class="interaction">
                            @if(count($post->likes))
                                @if(count($post->likes) == 1)
                                    <a data-toggle="modal" data-target="#{{$post->id}}" href="#{{$post->id}}">{{count($post->likes)}} Like</a>
                                @else
                                    <a data-toggle="modal" data-target="#{{$post->id}}" href="#{{$post->id}}">{{count($post->likes)}} Likes</a>
                                @endif
                            @endif
                            @if(!count(Auth::user()->likes()->where('post_id', $post->id)->first()))
                                <a href="{{route('like', $post->id)}}">Like</a>
                            @else
                                <a href="{{route('unlike', $post->id)}}">Unlike</a>
                            @endif
                            @if (!count($post->comments))
                                <a role="button" data-toggle="collapse" href="#no-comments-{{$post->id}}" aria-expanded="false" aria-controls="no-comments-{{$post->id}}">Comment</a>
                            @endif
                            @if(Auth::user() == $post->user)
                                <a href="#" class="edit">Edit</a>
                                <a href="{{route('post.delete', ['post_id' => $post->id])}}">Delete</a>
                            @endif
                        </div>
                    </div>
                    <div class="modal fade" id="report-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                </div>
                                <form action="{{route('send-report', $post->id)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        Why are you reporting this post?
                                        <div class="radio">
                                            <label><input type="radio" name="report" id="0" value="0" checked>It's annoying or not interesting</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="report" id="1" value="1">I think it shouldn't be on Socialom</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="report" id="2" value="2">It's spam</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="list-group">
                              @foreach($post->likes as $like)
                                <a href="{{route('profile', \App\User::where('id', $like->user_id)->first()->username)}}" target="_blank" class="list-group-item">
                                  {{\App\User::where('id', $like->user_id)->first()->username}}
                                </a>
                                @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if (count($post->comments))
                        <ul class="list-group">
                            @foreach($post->comments as $comment)
                                <li class="list-group-item">
                                    @if($post->user->profile_img == NULL)
                                        <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 30px; height: 30px; !important;">
                                    @else
                                    <img src="{{$post->user->profile_img}}" alt="Profile img" style="width: 30px; height: 30px; !important;">
                                    @endif
                                    <a href="{{route('profile', $comment->user->username)}}">
                                        {{$comment->user->first_name}} {{$comment->user->last_name}}
                                    </a>
                                    {{$comment->content}}
                                </li>
                            @endforeach
                        </ul>
                        <div class="panel-footer">
                            <form action="{{route('addcomment')}}" method="post" style="margin-bottom: 0px; !important;">
                                {{csrf_field()}}
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <input type="text" class="form-control" placeholder="Write a comment" name="comment">
                            </form>
                        </div>
                    @else
                        <div class="collapse" id="no-comments-{{$post->id}}">
                            <div class="panel-footer">
                                <form action="{{route('addcomment')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="text" class="form-control" placeholder="Write a comment" name="comment">
                                </form>
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
    </script>
@endsection
