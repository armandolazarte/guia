@if(\Auth::check())
    @include('partials.menu.dynamic')
@else
    @include('partials.menu.main')
@endif
