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
                {{--Benachrichtigung--}}
                @if($errors->any())
                    <div class="alert alert-danger">FEHLER !</div>
                    @enderror
                @if(session('message'))
                    <div class="alert alert-{{session('alertType')}}">{{session('message')}}</div>
                @endif

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
    <script>
        $( document ).on( "mousemove", function( event ) {
            if (event.pageX<5){
                if ($('#wrapper').hasClass('toggled')){
                    $('#wrapper').removeClass('toggled')
                }
            }
            if (!$('#wrapper').hasClass('toggled')){
                if (event.pageX>240){
                    $('#wrapper').addClass('toggled')
                }
            }
        });
    </script>
</body>
</html>
