<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @include('partials.head')
    @section('css')
        <!-- Sección para incluir CSS -->
    @show
</head>

<body>

<!-- WRAPPER -->
<div>

    @yield('contenido')

</div>
<!-- END WRAPPER -->

@section('js')
    @include('partials.javascript')
@show

</body>
</html>
