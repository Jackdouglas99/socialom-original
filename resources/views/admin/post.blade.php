@extends('layouts.master')

@section('title')
    User - #{{$post->id}}
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
                Posted By: <a href="{{route('profile', $post->user->username)}}">{{$post->user->first_name}} {{$post->user->last_name}}</a>
            </div>
            <div class="well">
                Created: {{$post->created_at}}<br>
                Last updated: {{$post->updated_at}}
            </div>
            <div class="well">
                Like Count: {{count($post->likes)}}<br>
                Comment Count: {{count($post->comments)}}
            </div>
            <div class="well">
                Email: <a href="mailto:{{$post->user->email}}">{{$post->user->email}}</a>
            </div>
            <div class="well">
                Content: {{$post->body}}
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Comments</div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($post->comments as $comment)
                            <li class="list-group-item">
                                @if($post->user->profile_img == NULL)
                                    <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 30px; height: 30px; !important;">
                                @else
                                    <img src="{{$post->user->profile_img}}" alt="Profile img" style="width: 30px; height: 30px; !important;">
                                @endif
                                <a href="{{route('admin.user', $comment->user->id)}}">
                                    {{$comment->user->first_name}} {{$comment->user->last_name}}
                                </a>
                                {{$comment->content}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
