@extends('layouts.app')

@section('javascript.header')
    <script src="{{asset('storage/js/tinymce/tinymce.min.js')}}"></script>
    <script>tinymce.init({
            selector:'#content'
    });</script>
@endsection

@section('content')


    <form action="{{route('admin.systemverwaltung.contenteditor')}}">

        <div class="dropdown show">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Bitte Seite auswählen...
            </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @foreach($seiten as $seite)
                    <a class="dropdown-item" href="?seite={{$seite}}">{{ucfirst($seite)}}</a>
                @endforeach
            </div>
        </div>
    </form>

    <hr>

    @if($selection)
        <div>
            <h5>Seite: <b>{{ ucfirst($selection)}}</b></h5>
            <br>

            <form action="{{route('admin.systemverwaltung.contenteditor')}}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{$selection}}">
                <textarea cols="100" rows="20" name="content" id="content">
                {{($content)}}
                </textarea>

                <button class="btn btn-primary" type="submit">Speichern</button>

            </form>
        </div>
    @else
        <div>
            <h3>Bitte zuerst eine Seite auswählen</h3>
        </div>
    @endif


@endsection
