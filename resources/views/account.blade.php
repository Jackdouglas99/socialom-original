@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
    <section class="row">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Your Account</h3></header>
            <form action="{{route('account.save')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" id="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}" id="last_name">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" value="{{$user->username}}" id="username">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" class="form-control" value="{{$user->email}}" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image (only .jpg) Coming Soon</label>
                    <input type="file" name="profile_image" class="form-control" id="profile_image" disabled>
                </div>
                <div class="form-group">
                    <label for="banner_image">Banner Image (only .jpg) Coming Soon</label>
                    <input type="file" name="banner_image" class="form-control" id="banner_image" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Save Account</button>
            </form>
        </div>
    </section>
    @if (Storage::disk('local')->has($user->username . '-' . $user->id . '-profile.jpg'))
        <section class="row">
            <div class="col-md-6 col-md-offset-3">
                <img src="{{route('account.image', ['filename' => $user->username . '-' . $user->id . '-profile.jpg'])}}" alt="" class="img-responsive">
            </div>
        </section>
    @endif
    @if (Storage::disk('local')->has($user->username . '-' . $user->id . '-banner.jpg'))
        <section class="row">
            <div class="col-md-6 col-md-offset-3">
                <img src="{{route('account.image', ['filename' => $user->username . '-' . $user->id . '-banner.jpg'])}}" alt="" class="img-responsive">
            </div>
        </section>
    @endif
@endsection