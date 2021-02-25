@extends('layouts.app')

@section('content')

    <div class="container mb-2">
        <form action="{{route('admin.systemverwaltung.auswertungen')}}" method="get">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($tabs as $tab)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->query('auswertung')==$tab ? 'active' : '' }}" href="?auswertung={{$tab}}">{{strtoupper($tab)}}</a>
                    </li>
                @endforeach
            </ul>
        </form>
    </div>

    <div class="container">
        @switch(request()->query()['auswertung'])
            {{--Top Ausleihen--}}
            @case($tabs[0])
                <h4>Top Ausleihen</h4>
                <table class="{{$tableStyle}}">
                    <thead>
                    <tr>
{{--                        <th>Häufigkeit</th>--}}
                        @foreach($tableBuilder as $key=>$val)
                            <th>{{$val}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($top_ausleihen as $aus)
                        <tr>
{{--                            <td>{{$aus->anzahl}}</td>--}}
                            @foreach($tableBuilder as $key=>$val)
                                @switch($key)
                                    @case('literaturart_id')
                                    <td>{{$aus->literaturart->literaturart}}</td>
                                    @break

                                    @case('zeitschrift_id')
                                    <td>{{$aus->zeitschrift!=null ? $aus->zeitschrift->name : ''}}</td>
                                    @break

                                    @case('raum_id')
                                    <td>{{$aus->raum!=null ? $aus->raum->raum : ''}}</td>
                                    @break

                                    @case('hauptsachtitel')
                                    <td class="text-wrap"><a href="#" class="render-medium-modal" data-id="{{$aus->id}}">{{$aus->attributesToArray()[$key]}}</a></td>
                                    @break

                                    @case('autoren')
                                    <td>
                                        @foreach(explode(';',$aus->autoren) as $autor)
                                            {{$autor}}<br>
                                        @endforeach
                                    </td>
                                    @break

                                    @default
                                    <td>{{$aus->attributesToArray()[$key]}}</td>

                                @endswitch
                            @endforeach
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    {{ $top_ausleihen->appends(request()->all())->links() }}
                    @livewire('export-panel',['withBib'=>false,'exportData'=>$exportData,'downloadName'=>'Top_Ausleihen','cols'=>$tableBuilder])
                </div>
            @break
            {{-- / Top Ausleihen--}}

            {{--Überfällige Ausleihen--}}
            @case($tabs[1])
                <h4>Überfällige Ausleihen</h4>
                <table class="table table-responsive-lg table-hover table-bordered">
                    <thead>
                    <tr>
                        @foreach($tableBuilder as $key=>$val)
                            <th>{{$val}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ausleihen_offen as $aus)
                        <tr {{strtotime($aus->RueckgabeSoll)<time() ? 'style=background-color:#f9d6d5' : ''}}>
                            @foreach($tableBuilder as $key=>$val)
                                @switch($key)
                                    @case('medium_id')
                                    <td><a href="#" class="render-medium-modal" data-id="{{$aus->medium_id}}">{{$aus->attributesToArray()[$key]}}</a></td>
                                    @break

                                    @case('user_id')
                                    <td><a href="{{route('ausleihe.show',$aus->user_id)}}">{{$aus->attributesToArray()[$key]}}</a></td>
                                    @break

                                    @default
                                    <td>{{$aus->attributesToArray()[$key]}}</td>
                                @endswitch
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    {{ $ausleihen_offen->appends(request()->all())->links() }}
                    @livewire('export-panel',['withBib'=>false,'exportData'=>$exportData,'downloadName'=>'Ueberfaellige_Ausleihen','cols'=>$tableBuilder])
                </div>
            @break
            {{-- / Überfällige Ausleihen--}}

            {{-- Bestand nach Systematikgruppen --}}
            @case($tabs[2])
                <h4>Bestand nach Systematikgruppen</h4>

                @livewire('bestand-nach-systematikgruppen-component')

            @break
            {{-- /Bestand nach Systematikgruppen --}}

            {{-- Bestand nach Erscheinungsjahr --}}
            @case($tabs[3])
                <h4>Bestand nach Erscheinungsjahr</h4>
                @livewire('bestand-nach-jahr-component')

            @break
            {{-- /Bestand nach Erscheinungsjahr --}}
        @endswitch
    </div>

    @include('admin.medienverwaltung.mediummodal')
@endsection
