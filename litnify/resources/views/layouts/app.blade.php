<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.header')
    @yield('javascript.header')
    @livewireStyles
</head>
<body>
    @include('cookieConsent::index')
    <div class="d-flex" id="wrapper">
    {{-- <div class="d-flex toggled" id="wrapper"> --}}
        @role(2)
            @include('layouts.sidebar')
        @endrole

        <div id="content-wrapper" class="">
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

            </main>
            @include('layouts.footer')
        </div>
    </div>
    <button class="btn btn-primary btn-lg" onclick="goToTop()" id="scrollToTop" title="Go to top">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>

    <script>
        $('.toast').toast('show');
    </script>
    @livewireScripts

    @yield('javascript.footer')
</body>
</html>
