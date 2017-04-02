<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jackdouglas.co.uk/bootstrap-3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.jackdouglas.co.uk/cosmo-bootstrap.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>@yield('title')</title>
    </head>
    <body>
        @include('includes.header')
        <div class="container" style="margin-top: -10px; height: auto; padding-bottom: 100px; !important;">
            @yield('content')
        </div>

        <script src="https://cdn.jackdouglas.co.uk/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.jackdouglas.co.uk/bootstrap-3.3.7/js/bootstrap.js"></script>
        <script src="{{ asset('src/js/app.js') }}"></script>
    </body>
</html>