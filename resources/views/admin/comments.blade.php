@extends('layouts.master')

@section('title')
  Comment List
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
      <h3>All Comments</h3>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>UCID</th>
            <th>User</th>
            <th>UPID</th>
            <th>Contnent</th>
            <th>Reports</th>
          </tr>
        </thead>
        <tbody>
          @foreach($comments as $comment)
          <tr>
            <td><a href="{{route('admin.comment', $comment->id)}}">{{$comment->id}}</a></td>
            <td>{{$comment->user->username}}</td>
            <td><a href="{{route('admin.post', $comment->post->id)}}">{{$comment->post->id}}</a></td>
            <td>{{$comment->content}}</td>
            <td>Coming Soon</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
