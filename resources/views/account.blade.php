@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
    @include('includes.message-block')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div>
                    <ul class="nav nav-pills nav-stacked nav-fixed-top" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">General</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="home" role="tab" data-toggle="tab">Profile</a></li>
                        <li role="presentation"><a href="#privacy" aria-controls="profile" role="tab" data-toggle="tab">Privacy</a></li>
                        <li role="presentation"><a href="#notification" aria-controls="messages" role="tab" data-toggle="tab">Notification</a></li>
                        <li role="presentation"><a href="#blocking" aria-controls="settings" role="tab" data-toggle="tab">Blocking</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                @include('includes.message-block')
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                        <div class="alert alert-info animated fadeIn" role="alert">If you do not want to change something do not change the box.</div>
                        {{ $errors->first('name', '<span class=error>:message</span>') }}
                        <h1>General Account Settings</h1><small>Your username must only contain letters from a-z in both lowercase and/or UPPERCASE, Numbers, Dot . , Dash -. Do not include spaces.</small>
                        <form action="{{route('account.update')}}" method="post">
                            {{csrf_field()}}
                            <label for="username">Username:</label><input class="form-control" type="text" name="username" value="{{$user->username}}" placeholder="Username" autocomplete="off"><br>
                            <label for="first_name">First Name:</label><input class="form-control" type="text" name="first_name" value="{{$user->first_name}}" placeholder="First Name"><br>
                            <label for="last_name">Last Name:</label><input class="form-control" type="text" name="last_name" value="{{$user->last_name}}" placeholder="Last Name"><br>
                            <label for="email">Email Address:</label><input class="form-control" type="email" name="email" value="{{$user->email}}" placeholder="Email Address"><br>
                            <label for="password">New Password:</label><input class="form-control" type="password" name="password" placeholder="New Password" >
                            <small>If you do not want to change your password then just add your current password to the "New Password" field.</small>
                            <br><br>
                            <button type="submit" class="btn btn-primary">Save Changed</button>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="profile">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Profile Image
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <form method="post" action="" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="alert alert-info">Your image must at least 120px X 120px and must be a .png, .jpg, .jpeg and no larger than 5MB.</div>
                                            <label for="profile_image">Profile Image</label>
                                            <input disabled class="form-control" type="file" id="image" name="profile_image"><br>
                                            <button type="submit" name="profileimg-set" class="btn btn-primary">Upload</button>
                                        </form>
                                        @if (Storage::disk('local')->has($user->id . '-profile.jpg'))
                                            <section class="row new-post">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="" class="img-responsive">
                                                </div>
                                            </section>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Profile Banner
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <form method="post" action="" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="alert alert-info">Your image must at least 1170px X 300px and must be a .png, .jpg, .jpeg and no larger than 5MB.</div>
                                            <label for="banner_image">Profile Banner</label>
                                            <input disabled class="form-control" type="file" id="banner_image" name="banner-image"><br>
                                            <button type="submit" name="bannerimg-set" class="btn btn-primary">Upload</button>
                                        </form>
                                        @if (Storage::disk('local')->has($user->id . '-banner.jpg'))
                                            <section class="row new-post">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="" class="img-responsive">
                                                </div>
                                            </section>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Profile bio/about
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <form method="post" action="{{route('update.bio')}}">
                                            {{csrf_field()}}
                                            <label for="about-txt">About section</label>
                                            <textarea id="about-txt" name="content" class="form-control"></textarea><br>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="privacy">
                        <h1>Nothing in here</h1>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="notification">
                        <h1>Nothing in here</h1>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="blocking">
                        <h1>Nothing in here</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
