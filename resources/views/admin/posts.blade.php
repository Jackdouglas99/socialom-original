@extends('layouts.master')

@section('title')
  Post List
@endsection

@section('content')
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}

    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }

    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;}
    }
  </style>
  <div class="row content">
    @include('admin.includes.sidebar')
    <div class="col-sm-9">
      <h3>All Posts</h3>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>UPID</th>
            <th>User</th>
            <th>Post Content</th>
            <th># Likes</th>
            <th># Comments</th>
            <th>Reports</th>
          </tr>
        </thead>
        <tbody>
          @foreach($posts as $post)
          <tr>
            <td><a href="{{route('admin.post', $post->id)}}">{{$post->id}}</a></td>
            <td>{{$post->user->username}}</td>
            <td>{{$post->body}}</td>
            <td>{{count($post->likes)}}</td>
            <td>{{count($post->comments)}}</td>
            <td>Coming Soon</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
