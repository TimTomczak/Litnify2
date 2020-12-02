<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('javascript.header')
    @include('layouts.header')
    @livewireStyles
</head>
<body>

    <div class="d-flex" id="wrapper">
    {{-- <div class="d-flex toggled" id="wrapper"> --}}
        @role('1')
            @include('layouts.sidebar')
        @endrole

        <div id="content-wrapper">
            @include('layouts.nav')
            <main class="border-bottom" style="margin-top:75px; background-color: #ffffff; min-height: 85vh;">
                {{--Benachrichtigung--}}
                <div class="container-fluid">
                    @if(!(request()->is('/')))
                        @include('layouts.breadcrumbs')
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">FEHLER !</div>
                    @enderror
                    @if(session('message'))
                        <div class="alert alert-{{session('alertType')}}">{{session('message')}}</div>
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
