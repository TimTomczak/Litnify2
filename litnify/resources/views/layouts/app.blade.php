<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.header')
    @livewireStyles
</head>
<body>
<div id="app">

    @include('layouts.nav')
    @if (isset($alert))
        <div class="container">
            <div class="alert alert-{{$alert[0]}}">
                {{ $alert[1] }}
            </div>
        </div>
    @elseif(session('alert'))
        <div class="container">
            <div class="alert alert-{{session('alert')[0]}}">
                {{ session('alert')[1] }}
            </div>
        </div>
    @endif

    <main class="" style="margin-top:66px; background-color: #ffffff; min-height: 80vh;" >
        @yield('content')
    </main>
    @livewireScripts

</div>
@include('layouts.footer')


</body>
</html>
