@extends('layouts.app')

@section('javascript.header')
    <script src="{{asset('storage/js/tinymce/tinymce.min.js')}}"></script>
    <script>tinymce.init({
            selector: 'textarea',
            language: 'de',
            height : "480",
            plugins: [
                "advlist autolink lists link image charmap print code preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste hr"
            ],
            //toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | accordion code"
    });</script>
@endsection

@section('content')

    <form action="{{route('admin.systemverwaltung.contenteditor')}}" method="get">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ Helper::tab_active('faq') }}" href="?seite=faq">FAQ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Helper::tab_active('oeffnungszeiten') }}" href="?seite=oeffnungszeiten">Öffnungszeiten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Helper::tab_active('kontakt') }}" href="?seite=kontakt">Kontakt</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Helper::tab_active('impressum') }}" href="?seite=impressum">Impressum</a>
            </li>
        </ul>
    </form>


    <form action="{{route('admin.systemverwaltung.contenteditor')}}" method="post">
        @csrf
        <textarea class="content" name="content" rows="6">
            {!! $content !!}
        </textarea>
        <input type="hidden" name="title" value="{{$selection}}">
        <input type="submit" class="btn btn-block btn-primary" value="Speichern">

    </form>

@endsection
