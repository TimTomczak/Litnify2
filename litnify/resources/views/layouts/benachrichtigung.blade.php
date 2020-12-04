@if(session()->has('message'))
    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="{{session()->has('duration') ? session('duration') : 6000}}">
        <div class="toast-header">
            <strong class="mr-auto">{{session()->has('title') ? session('title') : 'Benachrichtigung'}} </strong>
            <small>{{date('G:i',time())}}</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body alert-{{session('alertType')}}">
            <p class="card-text">{{session('message')}}</p>
        </div>
    </div>
@endif

@if($errors->any())
    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="7000">
        <div class="toast-header">
            <strong class="mr-auto">Fehler ! </strong>
            <small>{{date('G:i',time())}}</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body alert-danger">
            @foreach($errors->all() as $error)
                <p class="card-text">{{$error}}</p>
            @endforeach
        </div>
    </div>
@endif
