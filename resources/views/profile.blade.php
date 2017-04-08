@extends('layouts.master')

@section('title')
    Profile - {{$user->username}}
@endsection

@section('content')
    <style>
        .cover-container{
            height:300px;
            background-image: url(
            @if($user->profile_banner == NULL)
                https://placehold.it/1170x300
            @else
                {{$user->profile_banner}}
            @endif
            );
            margin-top: -10px;
        }
        .cover-container a img {
            margin-top: 20px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 10px solid rgba(255,255,255,0.3);
        }
        .profile-name{
            color: #fff;
            text-rendering: optimizelegibility;
            text-shadow: 0 0 3px rgba(0,0,0,.8);
            font-size: 40px;
        }
    </style>
    <div class="row text-center cover-container">
        <a>
            @if($user->profile_img == NULL)
                @if($user->gender == 0)
                    <img src="https://cdn.jackdouglas.co.uk/female-placehold.png">
                @else
                    <img src="https://cdn.jackdouglas.co.uk/male-placehold.png">
                @endif
            @else
                <img src="{{$user->profile_img}}" alt="">
            @endif
        </a>
        <h1 class="profile-name">
            {{$user->first_name}} {{$user->last_name}}
        </h1>
    </div><br>
    @if($user->id != Auth::user()->id)
        @if(!count($friends))
            @if(count($friendRequest))
                @foreach($friendRequest as $fr)
                    @if($fr->uid1 == Auth::user()->id)
                        <div class="panel panel-default">
                            <div class="panel-heading">Do you know {{$user->first_name}}</div>
                            <div class="panel-body">
                                <form action="{{route('cancel.friend.request')}}" method="post" class="form-inline">
                                    @if($user->gender == 0)
                                        To see what she shares with friends, Send her a friend request.
                                    @else
                                        To see what he shares with friends, Send him a friend request.
                                    @endif
                                    {{csrf_field()}}
                                    <input type="hidden" name="frid" value="{{$fr->id}}">
                                    <button type="submit" name="add-friend" class="btn btn-sm btn-danger pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> Cancel Friend Request</button>
                                </form>
                            </div>
                        </div>
                    @elseif($fr->uid2 == Auth::user()->id)
                        <div class="panel panel-default">
                            <div class="panel-heading">Do you know {{$user->first_name}}</div>
                            <div class="panel-body">
                                {{$user->first_name}} has sent you a friend request. Do you know them?
                                <a href="{{route('accept.friend.request', $fr->id)}}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> Accept Friend Request</a>
                                <a href="{{route('decline.friend.request', $fr->id)}}" class="btn btn-sm btn-danger pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> Decline Friend Request</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">Do you know {{$user->first_name}}</div>
                    <div class="panel-body">
                        <form action="{{route('send.friend.request')}}" method="post" class="form-inline">
                            @if($user->gender == 0)
                                To see what she shares with friends, Send her a friend request.
                            @else
                                To see what he shares with friends, Send him a friend request.
                            @endif
                            {{csrf_field()}}
                            <input type="hidden" name="uid2" value="{{$user->id}}">
                            <button type="submit" name="add-friend" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> Send Friend Request</button>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Intro
                </div>
                <div class="panel-body">
                    About:
                    @if($user->about != null)
                        {{$user->about}}
                    @else
                        @if($user->id == Auth::user()->id)
                            To set your bio go to your account settings. Or <a href="{{route('account')}}">Click Here</a>
                        @endif
                    @endif
                </div>
                @if($user->id != Auth::user()->id)
                  @if(Auth::user()->role != 0)
                    <div class="panel-body">
                      @if(Auth::user()->role == 1)
                        <a href="#" class="btn btn-primary">View Reports</a>
                      @elseif(Auth::user()->role == 2)
                        <a href="#" class="btn btn-primary">Edit Profile</a> <a href="#" class="btn btn-primary">View Reports</a>
                      @endif
                    </div>
                  @endif
                @endif
            </div>
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
        </div>
    </div>
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
@endsection
