<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.header')
    @livewireStyles
</head>
<body>
<div id="app">

    @include('layouts.nav')

    <main class="py-2">
        @yield('content')
    </main>
    @livewireScripts

</div>
@include('layouts.footer')


</body>
</html>
