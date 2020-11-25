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
        @auth
            @include('layouts.sidebar')
        @endauth
        <div id="content-wrapper">
            @include('layouts.nav')
            <main class="" style="margin-top:66px; background-color: #ffffff; min-height: 80vh;">
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

    <script>
        $('#sidebar-toggle').click(function (){
            if ($('#wrapper').hasClass('toggled')){
                $('#wrapper').removeClass('toggled');
            }
            else{
                $('#wrapper').addClass('toggled');
            }
            // $('#wrapper').toggleClass('toggled');
        });
    </script>
    <script>
        $( document ).ready(function() {
            $(".render-medium-modal").click(function( event) {
                var $mediumId = $(this).data('id');
                $('#modalContent').empty();
                var spinnerDiv = "<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>"
                $('#modalContent').append(spinnerDiv);
                $('#modalContent').load('/medium/'+$mediumId+' #medium');
                $('#showMediumBtn').attr('href','/medium/'+$mediumId)
                $('#mediumModal').modal('show');
            })
        });
    </script>
    @yield('javascript.footer')
</body>
</html>
