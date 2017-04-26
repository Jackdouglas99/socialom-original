@extends('layouts.master')

@section('title')
    New Chat
@endsection

@section('content')
    @include('includes.message-block')
    <ol class="breadcrumb">
        <li><a href="{{route('messages.index')}}">Messages</a></li>
        <li class="active">New message</li>
    </ol>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">New Chat</div>
            <div class="panel-body">
                <form action="{{route('messages.new.chat.post')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
                        @if(isset($username))
                            <input type="text" name="username" class="form-control" placeholder="Username"  value="{{$username}}" autofocus>
                        @else
                            <input type="text" name="username" class="form-control" placeholder="Username"  value="{{Request::old('username')}}" autofocus>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('message') ? 'has-error' : ''}}">
                        <textarea name="message" class="form-control" cols="30" rows="10" placeholder="message" style="max-width: 100%;">{{Request::old('message')}}</textarea>
                    </div>
                    <button class="btn btn-md btn-primary" type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
@endsection