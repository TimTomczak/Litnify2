<!-- Footer -->
<footer class="py-3 bg-light ">
    <div class="container">
        <p class="m-0 text-center text-dark">
            Copyright &copy; {{ config('app.name', 'Laravel') }}
            @php
                echo (date("Y"));
            @endphp
        </p>
    </div>
    <!-- /.container -->
</footer>
