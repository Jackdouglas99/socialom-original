@extends('layouts.master')

@section('title')
    Comment - #{{$comment->id}}
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
            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        Post ID: <a href="{{route('admin.post', $comment->post->id)}}">{{$comment->post->id}}</a><br>
                        Posted By: <a href="{{route('admin.user', $comment->post->user->id)}}">{{$comment->post->user->first_name}} {{$comment->post->user->last_name}}</a><br>
                        On: {{$comment->post->created_at}}
                        Content: {{$comment->post->body}}<br>
                    </div>
                    <div class="well">
                        Comment ID: {{$comment->id}}<br>
                        Created on: {{$comment->created_at}}<br>
                        Posted By: <a href="{{route('admin.user', $comment->user->id)}}">{{$comment->user->first_name}} {{$comment->user->last_name}}</a>
                        Content: {{$comment->content}}<br>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Admin Actions</div>
                        <div class="panel-body">
                            <a href="{{route('admin.comment.delete', $comment->id)}}" class="btn btn-danger">Delete comment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
