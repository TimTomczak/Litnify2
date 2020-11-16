<!-- Footer -->
<footer class="py-3 ">
    <div class="container">

        &nbsp;&nbsp;&nbsp;

        <p class="m-0 text-center text-dark">
            <img src="{{asset('storage/images/logo.png')}}" height="40px">
            <img src="{{asset('storage/images/sublogo.png')}}" height="40px">
             &copy; {{ config('app.name', 'Laravel') }}
            @php
                echo (date("Y"));
            @endphp
            | <a href="{{ url('/impressum') }}">Impressum</a>
        </p>
    </div>
    <!-- /.container -->
</footer>
