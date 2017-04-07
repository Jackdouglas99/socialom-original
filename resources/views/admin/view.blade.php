@extends('layouts.master')

@section('title')
  Admin Dashboard
@endsection

@section('content')
  <style>
    .row.content {height: 550px}
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>
  <div class="row content">
    @include('admin.includes.sidebar')
    <div class="col-sm-9">
      <div class="well">
        <h4>Administration Dashboard</h4>
        <p>Here are some of the sites stats</p>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <h4>Posts</h4>
            <p>{{$post_count}}</p>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Users</h4>
            <p>{{$user_count}}</p>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Comments</h4>
            <p>{{$comment_count}}</p>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Likes</h4>
            <p>{{$like_count}}</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="well">
            <h4>Recent Posts</h4>
            @foreach($posts_recent as $recent_post)
              <div class="well">
                {{$recent_post->body}}
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <h4>Recent Comments</h4>
            @foreach($comments_recent as $recent_comment)
              <div class="well">
                {{$recent_comment->content}}
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-sm-4">
          <div class="well">
            <h4>Recent Users</h4>
            @foreach($users_recent as $recent_user)
              <div class="well">
                {{$recent_user->username}}
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
