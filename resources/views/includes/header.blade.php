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
            <a class="navbar-brand" href="{{route('dashboard')}}">{{Config::get('app.name')}}</a>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('profile', Auth::user()->username)}}">Profile</a></li>
                            <li><a href="{{route('account')}}">Account</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>