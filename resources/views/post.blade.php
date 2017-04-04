@extends('layouts.master')

@section('title')
    Post
@endsection

@section('content')
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
@endsection
