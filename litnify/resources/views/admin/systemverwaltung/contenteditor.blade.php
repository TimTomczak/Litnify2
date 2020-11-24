@extends('layouts.app')

@section('javascript.header')
    <script src="{{asset('storage/js/tinymce/tinymce.min.js')}}"></script>
    <script>tinymce.init({
            selector: 'textarea',
            language: 'de',
            height : "480"
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



    <textarea class="content" rows="6">



    </textarea>

@endsection
