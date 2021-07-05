<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="main-breadcrumb">

    <ol class="breadcrumb">
        <li class="">
            <a onclick="javascript:history.back();">
                <i class="fa fa-arrow-circle-left p-1" aria-hidden="true"></i>
            </a>
        </li>
        <li class="border-right border-dark pr-3"></li>
        <li class="text-muted px-3">Sie befinden sich hier: </li>
        <li class="breadcrumb-item"><a href="{{url('/')}}">Start</a></li>

        @for($i = 1; $i <= count(Request::segments()); $i++)
            @if(array_key_exists(Request::segment($i),Helper::$breadcrumpLinks))
            <li class="breadcrumb-item">
                <a href="{{route(Helper::$breadcrumpLinks[Request::segment($i)])}}">{{ucfirst(Request::segment($i))}}</a>
            </li>
            @else
            <li class="breadcrumb-item">
                {{ucfirst(Request::segment($i))}}
            </li>
            @endif

        @endfor
    </ol>
</nav>


<!-- /Breadcrumb -->
