@if(Auth::check())
    <script type="text/javascript">
        window.location = "{{ route('dashboard') }}";//here double curly bracket
    </script>
@endif
@extends('layouts.master')

@section('title')
    Home
@endsection
@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-8">
            <h1><b>This website is in early BETA stages and WILL brake. If you find a bug please tell us. <a href="https://jackdouglas.co.uk/bugs">Report A Bug</a></b></h1>
            <img src="" alt="Main screen img (To Come).">
        </div>
        <div class="col-md-4">
            <h1><b>Create an account</b></h1>
            <h3>It is free after all.</h3>
            <form action="{{route('signup')}}" name="signup" method="post">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
                    <input type="text" value="{{Request::old('username')}}" class="form-control " name="username" placeholder="Username" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                </div>
                <div class="form-group {{$errors->has('first_name') ? 'has-error' : ''}}">
                    <input type="text" value="{{Request::old('first_name')}}" class="form-control " name="first_name" placeholder="First name" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                </div>
                <div class="form-group {{$errors->has('last_name') ? 'has-error' : ''}}">
                    <input type="text" value="{{Request::old('last_name')}}" class="form-control" name="last_name" placeholder="Surname">
                </div>
                <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                    <input type="email" value="{{Request::old('email')}}" class="form-control" name="email" placeholder="Email address">
                </div>
                <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                    <input type="password" value="{{Request::old('password')}}" class="form-control" name="password" placeholder="New Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;" autocomplete="off">
                </div>
                <div class="form-group {{$errors->has('birth_day') ? 'has-error' : ''}}">
                    <label for="birth_day">Birthday</label>
                    <input type="date" class="form-control" value="{{Request::old('birth_day')}}" name="birth_day">
                </div>
                <div class="form-group">
                    <select name="gender" class="form-control">
                        <option value="0">Female</option>
                        <option value="1">Male</option>
                    </select>
                </div>
                <p>By clicking Create an account, you agree to our <a href="/terms.php" target="_blank">Terms</a> and confirm that you have read our Data Policy, including our Cookie Use Policy.</p>
                <input type="submit" class="btn btn-lg btn-primary" name="register" value="Create an account">
            </form>
        </div>
    </div>
@endsection