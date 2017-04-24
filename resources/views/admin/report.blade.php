@extends('layouts.master')

@section('title')
    Report - #{{$report->id}}
@endsection

@section('content')
    <style>.row.content {height: 550px}.sidenav {background-color: #f1f1f1;height: 100%;}@media screen and (max-width: 767px) {.row.content {height: auto;}}</style>
    <div class="row content">
        @include('admin.includes.sidebar')
        <div class="col-sm-9">
            <div class="well">
                Reported: <a href="{{route('admin.user', $report->reported)}}">{{\App\User::where('id', $report->reported)->first()->first_name}} {{\App\User::where('id', $report->reported)->first()->last_name}}</a><br>
                Reporter: <a href="{{route('admin.user', $report->reporter)}}">{{\App\User::where('id', $report->reporter)->first()->first_name}} {{\App\User::where('id', $report->reporter)->first()->last_name}}</a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        Status:
                        @if($report->status == 0)
                            <td><span class="label label-primary">New</span></td>
                        @elseif($report->status == 1)
                            <td><span class="label label-primary">Resolved</span></td>
                        @elseif($report->status == 2)
                            <td><span class="label label-primary">Spam</span></td>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well">
                        Reason:
                        @if($report->reason == 0)
                            <td>It's annoying or not interesting</td>
                        @elseif($report->reason == 1)
                            <td>I think it shouldn't be on Socialom</td>
                        @elseif($report->reason == 2)
                            <td>It's spam</td>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($report->post->user->profile_img == NULL)
                        <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 30px; height: 30px; !important;">
                    @else
                        <img src="{{$report->post->user->profile_img}}" alt="Profile img" style="width: 30px; height: 30px; !important;">
                    @endif
                    <a href="{{route('admin.user', $report->post->user->id)}}">
                        {{$report->post->user->first_name}} {{$report->post->user->last_name}}
                    </a>
                    <small>at: {{$report->post->updated_at}}</small>
                    <a href="{{route('admin.post', $report->post->id)}}" class="btn btn-primary btn-sm pull-right">View Post</a>
                </div>
                <div class="panel-body">
                    {{$report->post->body}}
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Comments</div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($report->post->comments as $comment)
                            <li class="list-group-item">
                                @if($report->post->user->profile_img == NULL)
                                    <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 30px; height: 30px; !important;">
                                @else
                                    <img src="{{$report->post->user->profile_img}}" alt="Profile img" style="width: 30px; height: 30px; !important;">
                                @endif
                                <a href="{{route('admin.user', $comment->user->id)}}">
                                    {{$comment->user->first_name}} {{$comment->user->last_name}}
                                </a>
                                {{$comment->content}}
                                <a href="{{route('admin.comment', $comment->id)}}" class="btn btn-primary btn-sm pull-right">View Comment</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Report Actions</div>
                <div class="panel-body">
                    <form action="{{route('report.update', $report->id)}}" method="post">
                        {{csrf_field()}}
                        <select class="form-control" name="status">
                            <option value="2">Spam</option>
                            <option value="1">Remove post and resolve</option>
                        </select><br>
                        <button class="btn btn-primary btn-md">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
