@extends('layouts.app')

@section('content')


    @if($ausleihe->count()==0)
        <div class="alert alert-info m-2">INFO: Sie haben keine Medien ausgeliehen!</div>
    @else
        <x-switch-appearance/>

        @if(Helper::showCards()=='true')
            @foreach($ausleihe as $item)
                <x-medium-card :medium="$item">
                    <x-slot name="ausleihenSlot">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div >
                                @php
                                    $diff = (Carbon\Carbon::parse($now))->diffInDays($item->pivot->RueckgabeSoll, false);

                                    echo ($diff > 1 ? 'Verbleibende Ausleihdauer: ' : ' <b><i class="fa fa-exclamation-triangle"></i> Sie sind mit dem Medium im Verzug: </b>' );
                                    echo $diff . ($diff == 1 ? ' Tag' : ' Tage' );
                                @endphp
                            </div>
                            <div>
                                <table class="table table-sm table-responsive table-borderless ml-auto">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Ausleihdatum</th>
                                        <td>{{(Carbon\Carbon::parse($item->pivot->Ausleihdatum))->formatLocalized('%d.%m.%Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Rückgabedatum</th>
                                        <td>{{(Carbon\Carbon::parse($item->pivot->RueckgabeSoll))->formatLocalized('%d.%m.%Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Verlängerungen</th>
                                        <td>{{($item->pivot->Verlaengerungen)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </x-slot>

                </x-medium-card>
            @endforeach

        @elseif(Helper::showCards()=='false')
            <table class="{{$tableStyle}} table-responsive">
                <thead>
                <tr>
                    <th>Ausleihdatum</th>
                    <th>Rückgabedatum</th>
                    <th>Verlängerungen</th>
                    @foreach($tableBuilder as $key=>$val)
                        <th>{{$val}}</th>
                    @endforeach
                    <th>Informationen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ausleihe as $item)
                    <tr>
                        <td>
                            {{(Carbon\Carbon::parse($item->pivot->Ausleihdatum))->formatLocalized('%d.%m.%Y') }}
                        </td>
                        <td>
                            {{(Carbon\Carbon::parse($item->pivot->RueckgabeSoll))->formatLocalized('%d.%m.%Y') }}
                        </td>
                        <td>
                            {{($item->pivot->Verlaengerungen)}}
                        </td>


                        @foreach($tableBuilder as $key=>$val)
                            @switch($key)
                                @case('literaturart_id')
                                <td>{{$item->literaturart->literaturart}}</td>
                                @break

                                @case('zeitschrift_id')
                                <td>{{$item->zeitschrift!=null ? $item->zeitschrift->name : ''}}</td>
                                @break

                                @case('raum_id')
                                <td>{{$item->raum!=null ? $item->raum->raum : ''}}</td>
                                @break

                                @case('hauptsachtitel')
                                <td class="text-wrap"><a href="#" class="render-medium-modal" data-id="{{$item->id}}">{{$item->attributesToArray()[$key]}}</a></td>
                                @break

                                @case('autoren')
                                <td>
                                    @foreach(explode(';',$item->autoren) as $autor)
                                        {{$autor}}<br>
                                    @endforeach
                                </td>
                                @break

                                @default
                                <td>{{$item->attributesToArray()[$key]}}</td>

                            @endswitch
                        @endforeach
                        <td>
                            @php
                                $diff = (Carbon\Carbon::parse($now))->diffInDays($item->pivot->RueckgabeSoll, false);

                                echo ($diff > 1 ? 'Verbleibende Ausleihdauer: ' : ' <b><i class="fa fa-exclamation-triangle"></i> Sie sind mit dem Medium im Verzug: </b>' );
                                echo $diff . ($diff == 1 ? ' Tag' : ' Tage' );

                            @endphp

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        @endif

        {{-- Pagination --}}
        <div class="d-flex">
            <div class="mr-auto p-2">
                {{ $ausleihe->links() }}
            </div>
            <div class="p-2">
                <x-export-panel-ausleihen/>
            </div>
        </div>

    @endif
    @include('admin.medienverwaltung.mediummodal')
@endsection

