@extends('layouts.master')

@section('title')
    Messages
@endsection

@section('content')
    @include('includes.message-block')
    <style>
        .message-body {
            margin: 0 !important;
            padding: 0 !important;
            width: auto;
            height: auto;
        }
        .message-main-receiver {
            /*padding: 10px 20px;*/
            max-width: 60%;
        }
        .message-main-sender {
            padding: 3px 20px !important;
            margin-left: 40% !important;
            max-width: 60%;
        }
        .message-text {
            margin: 0 !important;
            padding: 5px !important;
            word-wrap:break-word;
            font-weight: 200;
            font-size: 14px;
            padding-bottom: 0 !important;
        }
        .message-time {
            margin: 0 !important;
            margin-left: 50px !important;
            font-size: 12px;
            text-align: right;
            color: #9a9a9a;

        }
        .receiver {
            width: auto !important;
            padding: 4px 10px 7px !important;
            border-radius: 10px 10px 10px 0;
            background: #f1f0f0;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            word-wrap: break-word;
            display: inline-block;
        }
        .sender {
            float: right;
            width: auto !important;
            color: #ffffff;
            background: #0084ff;
            border-radius: 10px 10px 0 10px;
            padding: 4px 10px 7px !important;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            display: inline-block;
            word-wrap: break-word;
        }
    </style>
    <ol class="breadcrumb">
        <li><a href="{{route('messages.index')}}">Messages</a></li>
        <li class="active">
            @if($chat->user_id_from == Auth::user()->id)
                {{\App\User::where('id', $chat->user_id_to)->first()->username}}
            @elseif($chat->user_id_to == Auth::user()->id)
                {{\App\User::where('id', $chat->user_id_from)->first()->username}}
            @endif
        </li>
    </ol>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($chat->user_id_from == Auth::user()->id)
                        {{\App\User::where('id', $chat->user_id_to)->first()->username}}
                    @elseif($chat->user_id_to == Auth::user()->id)
                        {{\App\User::where('id', $chat->user_id_from)->first()->username}}
                    @endif
                </div>
                <div class="panel-body">
                    @foreach($messages as $message)
                        @if($message->user_id != Auth::user()->id)
                            <div class="row message-body">
                                <div class="col-sm-12 message-main-receiver">
                                    <div class="receiver">
                                        <div class="message-text">
                                            {{$message->message}}
                                        </div>
                                        <span class="message-time pull-right">{{$message->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        @elseif($message->user_id == Auth::user()->id)
                            <div class="row message-body">
                                <div class="col-sm-12 message-main-sender">
                                    <div class="sender">
                                        <div class="message-text">
                                            {{$message->message}}
                                        </div>
                                        <span class="message-time pull-right">{{$message->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="panel-footer">
                    <form action="{{route('messages.chat.send', $chat->id)}}" method="post">
                        {{csrf_field()}}
                        <input type="text" class="form-control" name="message" placeholder="Write your message">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($chat->user_id_from == Auth::user()->id)
                        {{\App\User::where('id', $chat->user_id_to)->first()->username}}
                    @elseif($chat->user_id_to == Auth::user()->id)
                        {{\App\User::where('id', $chat->user_id_from)->first()->username}}
                    @endif
                </div>
                <div class="panel-body">
                    @if($chat->user_id_from == Auth::user()->id)
                        <a href="{{route('profile', \App\User::where('id', $chat->user_id_to)->first()->username)}}">http://socialom.tk/p/{{\App\User::where('id', $chat->user_id_to)->first()->username}}</a>
                    @elseif($chat->user_id_to == Auth::user()->id)
                        <a href="{{route('profile', \App\User::where('id', $chat->user_id_from)->first()->username)}}">http://socialom.tk/p/{{\App\User::where('id', $chat->user_id_from)->first()->username}}</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection