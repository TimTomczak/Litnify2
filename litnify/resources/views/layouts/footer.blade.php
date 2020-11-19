<!-- Footer -->
<footer class="py-3 ">
    <div class="container">

        <div class="row">
            <div class="col-sm-6">
                <p class="m-0 text-center text-dark">
                    <img src="{{asset('storage/images/logo.png')}}" height="40px">
                    <img src="{{asset('storage/images/sublogo.png')}}" height="40px">
                </p>
            </div>
            <div class="col-sm-6">
                <p class="m-0 text-center text-dark">

                    &copy; {{ config('app.name', 'Laravel') }}
                    @php
                        echo (date("Y"));
                    @endphp
                    | <a href="{{ url('/impressum') }}">Impressum</a>
                </p>
            </div>
        </div>


    </div>
    <!-- /.container -->
</footer>
