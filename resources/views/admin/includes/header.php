
  @if(Auth::user() && Auth::user()->role == 0)
    <script type="text/javascript">
        window.location = "{{route('suspended')}}";//here double curly bracket
    </script>
  @endif
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('dashboard')}}"><img src="{{ asset('src/logo.png') }}" alt="" style="margin-top:-15px;"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if(!Auth::user())
            <form class="navbar-form navbar-right" action="{{route('signin')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" value="{{Request::old('email1')}}" name="email1" class="form-control {{$errors->has('username1') ? 'has-error' : ''}}" placeholder="email">
                    <input type="password" value="{{Request::old('password1')}}" name="password1" class="form-control {{$errors->has('password1') ? 'has-error' : ''}}" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary" name="login">Login</button>
            </form>
            @else
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-globe"></i>
                            @if(count(\App\Notification::where('to', Auth::user()->id)->whereNull('read_at')->get()))
                                <span class="badge">
                                    {{count(\App\Notification::where('to', Auth::user()->id)->whereNull('read_at')->get())}}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @if(count(\App\Notification::where('to', Auth::user()->id)->whereNull('read_at')->get()))
                                @foreach(\App\Notification::where('to', Auth::user()->id)->whereNull('read_at')->get() as $notif)
                                    @if($notif->type == "like")
                                        <li>
                                            <a href="{{route('read.notification', $notif->id)}}">
                                                {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Liked your post.
                                            </a>
                                        </li>
                                    @elseif($notif->type == "fRequest")
                                        <li>
                                            <a href="{{route('read.notification', $notif->id)}}">
                                                {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Sent you a friend request.
                                            </a>
                                        </li>
                                    @elseif($notif->type == "fRequestAccept")
                                        <li>
                                            <a href="{{route('read.notification', $notif->id)}}">
                                                {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Accepted your friend request.
                                            </a>
                                        </li>
                                    @elseif($notif->type == "comment")
                                        <li>
                                            <a href="{{route('read.notification', $notif->id)}}">
                                                {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Commented your post.
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li>You have no notifications</li>
                            @endif
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('profile', Auth::user()->username)}}">Profile</a></li>
                            <li><a href="{{route('account')}}">Account</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->role != 0)
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu">
                          @if(Auth::user()->role == 1)
                            <li><a href="#">Reports</a></li>
                          @elseif(Auth::user()->role == 2)
                            <li><a href="#">Manage Reports</a></li>
                            <li><a href="#">Manage Users</a></li>
                            <li><a href="#">Manage Roles</a></li>
                          @endif
                        </ul>
                      </li>
                    @endif
                </ul>
            @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
