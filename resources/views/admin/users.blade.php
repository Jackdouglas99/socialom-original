@extends('layouts.master')

@section('title')
  User List
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
      <h3>All Users</h3>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>UUID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td><a href="{{route('admin.user', $user->id)}}">{{$user->id}}</a></td>
            <td>{{$user->username}}</td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            @if($user->role == 0)
              <td><span class="label label-primary">User</span></td>
            @elseif($user->role == 1)
              <td><span class="label label-primary">Administrator</span></td>
            @elseif($user->role == 2)
              <td><span class="label label-primary">Super Administrator</span></td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
