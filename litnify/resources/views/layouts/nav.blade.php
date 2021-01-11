<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top border-bottom">


    <div class="container">
        @auth
            {{-- @todo --}}
            @if ( Auth::user()->berechtigungsrolle_id > 1)
                <button class="btn btn-light btn-lg border" id="sidebar-toggle" type="button">
                    ADMIN <i class="fa fa-bars"></i>
                </button>
            @endif
        @endauth

        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('storage/images/litnify.png')}}" alt="Logo" style="width:40px;">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('suche') }}"><i class="fa fa-search"></i> SUCHE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page', 'oeffnungszeiten') }}"><i class="fa fa-clock-o"></i> ÖFFNUNGSZEITEN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page', 'faq') }}"><i class="fa fa-question-circle"></i> FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page', 'kontakt') }}"><i class="fa fa-phone"></i> KONTAKT</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user">&nbsp;</i>{{ __('LOGIN') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <button type="button" class="btn btn-primary">
                                {{ ucfirst(Auth::user()->vorname) . " " . ucfirst(Auth::user()->nachname) }}
                                <img src="{{url('/')}}/user/avatar/{{Auth::user()->vorname .'+'. Auth::user()->nachname}}" alt="Avatar" width="22px">
                            </button>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profil.show') }}">Profil</a>
                            <a class="dropdown-item" href="{{ route('merkliste.show') }}">Merkliste</a>
                            <a class="dropdown-item" href="{{ route('ausleihen.show') }}">Ausleihen</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Ausloggen</a>
                        </div>
                    </li>
                    @endguest
            </ul>
        </div>
    </div>
</nav>

{{--
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
--}}
