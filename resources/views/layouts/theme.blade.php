<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GUIA :: Gestor Universitario de Información y Administración</title>

    @section('css')
    <link href="/css/app.css" rel="stylesheet">

        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @show
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Laravel</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
            </ul>

            @include('partials.searchBox')
            @include('partials.menu')

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="/auth/login">Login</a></li>
                    <li><a href="/auth/register">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->nombre }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    @include('partials.mensajes')
    @yield('content')
</div>

@section('js')
    <!-- Scripts -->
    <script src="{{ asset('jquery/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
@show
</body>
</html>
