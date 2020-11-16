<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Start</a></li>
        @for($i = 1; $i <= count(Request::segments()); $i++)
            <li class="breadcrumb-item">
                {{ucfirst(Request::segment($i))}}
            </li>
        @endfor
    </ol>
</nav>
<!-- /Breadcrumb -->










