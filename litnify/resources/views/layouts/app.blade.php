<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('javascript.header')
    @include('layouts.header')
    @livewireStyles
</head>
<body>

    <div class="d-flex toggled" id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper">
            @include('layouts.nav')
            <main class="" style="background-color: #ffffff; min-height: 80vh;">
                <div class="container-fluid">
                    @if(!(request()->is('/')))
                        @include('layouts.breadcrumbs')
                    @endif
                    @yield('content')
                </div>

            </main>

            @include('layouts.footer')
        </div>
    </div>

    @livewireScripts
    @yield('javascript.footer')
</body>
</html>
