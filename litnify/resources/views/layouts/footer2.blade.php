<footer class="py-3">
    <div class="footer">
        <!-- start .container -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 d-flex">
                    <div class="footer-widget">
                        <div class="widget-about">
                            <img src="{{asset('storage/images/logo.png')}}" height="60px">
                            <img src="{{asset('storage/images/sublogo.png')}}" height="60px">
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-sm-12 d-flex">
                    <div class="footer-widget">
                        <div class="footer-menu no-padding">
                            <h4 class="footer-widget-title">Rechtliches</h4>
                            <ul>
                                <li>
                                    <a href="{{url('/impressum')}}">Impressum</a>
                                </li>
                                <li>
                                    <a href="{{url('/datenschutz')}}">Datenschutz</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end /.row -->
        </div>
        <!-- end /.container -->
    </div>
    <!-- end /.footer-big -->

    <div class="mini-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright-text">
                        <p> &copy; {{ config('app.name', 'Laravel') }}
                            @php
                                echo (date("Y"));
                            @endphp
                            | Meteorologische Abteilung des Instituts für Geowissenschaften der Universität Bonn
                        </p>
                    </div>

                    <div class="go_top">
                        <span class="icon-arrow-up"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
