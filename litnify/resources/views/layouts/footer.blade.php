<!-- Footer -->
<footer class="py-3 ">
    <div class="container">

        &nbsp;&nbsp;&nbsp;

        <p class="m-0 text-center text-dark">
            <img src="https://litnify.meteo.uni-bonn.de/webapp/img/logo.png" height="40px">
            <img src="https://litnify.meteo.uni-bonn.de/webapp/img/sublogo.png" height="40px">
             &copy; {{ config('app.name', 'Laravel') }}
            @php
                echo (date("Y"));
            @endphp
            | <a href="/pages/impressum">Impressum</a>
        </p>
    </div>
    <!-- /.container -->
</footer>
