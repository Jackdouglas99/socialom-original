@extends('layouts.master')

@section('title')
    Profile
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
            <i class="fa fa-check" aria-hidden="true" data-toggle="tooltip" title="This user is verified."></i>
        </h1>
    </div><br>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Intro
                </div>
                <div class="panel-body">
                    About:
                </div>
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
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <div class="panel-body" id="postText">
                        <p class="postContent">
                            {{$post->body}}
                        </p>
                    </div>
                    <div class="panel-footer post">
                        <div class="interaction">
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a> |
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'  }}</a>
                            @if(Auth::user() == $post->user)
                                <a href="#" class="edit">Edit</a>
                                <a href="{{route('post.delete', ['post_id' => $post->id])}}">Delete</a>
                            @endif
                        </div>
                    </div>
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