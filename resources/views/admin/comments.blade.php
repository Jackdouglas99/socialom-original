@extends('layouts.master')

@section('title')
  Admin Dashboard
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
            <td><a href="#">{{$comment->id}}</a></td>
            <td>{{$comment->user->username}}</td>
            <td><a href="#">{{$comment->post->id}}</a></td>
            <td>{{$comment->content}}</td>
            <td>Coming Soon</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
