@extends('layouts.master')

@section('title')
    Messages
@endsection

@section('content')
    @include('includes.message-block')
    <style>
        #floating-button{
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #2780e3;
            position: fixed;
            bottom: 30px;
            right: 30px;
            cursor: pointer;
            box-shadow: 0px 2px 5px #666;
        }
        #floating-button:hover{
            color: #ffffff;
            background: #286090;
        }
        .plus:visited {
            text-decoration: none;
        }
        .plus{
            color: #ffffff;
            position: absolute;
            top: 0;
            display: block;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 0;
            margin: 0;
            line-height: 55px;
            font-size: 38px;
            font-family: 'Roboto';
            font-weight: 300;
            animation: plus-out 0.3s;
            transition: all 0.3s;
        }
        .plus:hover{
            color: #ffffff;
            text-decoration: none;
        }
        #container-floating{
            position: fixed;
            width: 70px;
            height: 70px;
            bottom: 30px;
            right: 30px;
            z-index: 50px;
        }
    </style>
    <div class="row">
        <div class="col-md-10">
            @foreach($chats as $chat)
                @if($chat->user_id_from == Auth::user()->id)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            @if(\App\User::where('id', $chat->user_id_to)->first()->profile_img == NULL)
                                <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 242px; height: 200px; !important;">
                            @else
                                <img src="{{$post->user->profile_img}}" alt="Profile img" style="width: 242px; height: 200px; !important;">
                            @endif
                            <div class="caption">
                                <h3>{{\App\User::where('id', $chat->user_id_to)->first()->username}}</h3>
                                <p><a href="{{route('messages.get.chat', $chat->id)}}" class="btn btn-primary" role="button">View Chat</a> <a href="{{route('messages.chat.delete', $chat->id)}}" class="btn btn-danger" role="button">Delete Chat</a></p>
                            </div>
                        </div>
                    </div>
                @elseif($chat->user_id_to == Auth::user()->id)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            @if(\App\User::where('id', $chat->user_id_from)->first()->profile_img == NULL)
                                <img src="https://cdn.jackdouglas.co.uk/male-placehold.png" alt="" style="width: 242px; height: 200px; !important;">
                            @else
                                <img src="{{$post->user->profile_img}}" alt="Profile img" style="width: 242px; height: 200px; !important;">
                            @endif
                            <div class="caption">
                                <h3>{{\App\User::where('id', $chat->user_id_from)->first()->username}}</h3>
                                <p><a href="{{route('messages.get.chat', $chat->id)}}" class="btn btn-primary" role="button">View Chat</a> <a href="{{route('messages.chat.delete', $chat->id)}}" class="btn btn-danger" role="button">Delete Chat</a></p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div id="container-floating">
        <div id="floating-button" data-toggle="tooltip" data-placement="left" data-original-title="Create" onclick="newmail()">
            <a href="{{route('messages.new.chat')}}" class="plus">+</a>
        </div>
    </div>
@endsection
