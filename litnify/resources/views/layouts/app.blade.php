<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.header')
    @livewireStyles
</head>
<body>
<div id="app">

    @include('layouts.nav')

    <main class="" style="margin-top:66px; background-color: #ffffff; min-height: 80vh;" >
        @yield('content')
    </main>
    @livewireScripts

</div>
@include('layouts.footer')


</body>
</html>
