@extends('layouts.master')

@section('title')
    User - #{{$user->id}}
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
                Username: <a href="{{route('profile', $user->username)}}" target="_blank">{{$user->username}}</a>
            </div>
            <div class="well">
                First Name: {{$user->first_name}}
            </div>
            <div class="well">
                Last Name: {{$user->last_name}}
            </div>
            <div class="well">
                Email: <a href="mailto:{{$user->email}}">{{$user->email}}</a>
            </div>
            <div class="well">
                Role:
                @if($user->role == 0)
                    <span class="label label-primary">User</span>
                @elseif($user->role == 1)
                    <span class="label label-primary">Admin</span>
                @elseif($user->role == 2)
                    <span class="label label-primary">Super Admin</span>
                @endif
            </div>
            <div class="well">
                Created: {{$user->created_at}}<br>
                Last Updated: {{$user->updated_at}}
            </div>
        </div>
    </div>
@endsection
