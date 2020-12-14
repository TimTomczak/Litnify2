<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.header')
    @include('layouts.fallback-js')
    @yield('javascript.header')
    @livewireStyles
</head>
<body>

    <div class="d-flex" id="wrapper">
    {{-- <div class="d-flex toggled" id="wrapper"> --}}
        @role(2)
            @include('layouts.sidebar')
        @endrole

        <div id="content-wrapper">
            @include('layouts.nav')
            <main class="border-bottom" style="margin-top:75px; background-color: #ffffff; min-height: 85vh;">
                {{--Benachrichtigung--}}
                @include('layouts.benachrichtigung')

                    @if(!(request()->is('/')))
                        <div class="container">
                        @include('layouts.breadcrumbs')
                    @else
                        <div class="container-fluid">
                    @endif

                    @yield('content')
                </div>
            </main>
            @include('layouts.footer2')
        </div>
    </div>

    <script>
        $('.toast').toast('show')
    </script>
    @livewireScripts

    @yield('javascript.footer')
</body>
</html>
