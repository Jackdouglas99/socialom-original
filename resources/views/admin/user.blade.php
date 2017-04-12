@extends('layouts.master')

@section('title')
    User - #{{$user->id}}
@endsection

@section('content')
    @include('admin.includes.message-block')
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
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Account Details</div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">Username: <a href="{{route('profile', $user->username)}}" target="_blank">{{$user->username}}</a></li>
                                <li class="list-group-item">Name: {{$user->first_name}} {{$user->last_name}}</li>
                                <a href="mailto:{{$user->email}}" class="list-group-item">Email: {{$user->email}}</a>
                                <li class="list-group-item">
                                    Role:
                                    @if($user->role == 0)
                                        User
                                    @elseif($user->role == 1)
                                        Admin
                                    @elseif($user->role == 2)
                                        Super Admin
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    Created: {{$user->created_at}}<br>
                                    Last Updated: {{$user->updated_at}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Admin Actions
                        </div>
                        <div class="panel-body">
                            <form action="{{route('admin.update.user', $user->id)}}" method="post">
                                {{csrf_field()}}
                                @if($user->suspended == 0)
                                    <button type="submit" class="btn btn-danger btn-md" name="suspend">Suspend User</button>
                                @elseif($user->suspended == 1)
                                    <button type="submit" class="btn btn-danger btn-md" name="unsuspend">Un-Suspend User</button>
                                @endif
                            </form>
                        </div>
                    </div>
                    @if(Auth::user()->role === 2)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Super Admin Actions
                            </div>
                            <div class="panel-body">
                                <form action="{{route('super.admin.update.user', $user->id)}}" method="post" class="form-inline">
                                    {{csrf_field()}}
                                    <select name="role" id="" class="form-control">
                                        @if($user->role == 0)
                                            <option value="0" selected>User</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Super Admin</option>
                                        @elseif($user->role == 1)
                                            <option value="0">User</option>
                                            <option value="1" selected>Admin</option>
                                            <option value="2">Super Admin</option>
                                        @elseif($user->role == 2)
                                            <option value="0">User</option>
                                            <option value="1">Admin</option>
                                            <option value="2" selected>Super Admin</option>
                                        @endif
                                    </select>
                                    <button class="btn btn-primary btn-md" type="submit">Save</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
