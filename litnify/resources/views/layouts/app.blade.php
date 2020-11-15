<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.header')
    @livewireStyles
</head>
<body>

    {{--@include('layouts.nav')--}}

    <div class="d-flex toggled" id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper">
            @include('layouts.nav')
            <main class="" style="/*margin-top:66px; */background-color: #ffffff; min-height: 80vh;">
                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>

    {{--<main class="" style="margin-top:66px; background-color: #ffffff; min-height: 80vh;" >
        @yield('content')
    </main>--}}
    @livewireScripts
    @yield('scripts')
</body>
</html>
