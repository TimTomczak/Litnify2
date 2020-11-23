@section('javascript.header')
    <link rel="stylesheet" type="text/css" href="{{asset('storage/css/daterangepicker/daterangepicker.css')}}" />

@endsection

@section('javascript.footer')
    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/moment.js')}}"></script>
    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('storage/js/daterangepicker/custom/ausleihzeitraumDaterangepicker.js')}}"></script>
@endsection
