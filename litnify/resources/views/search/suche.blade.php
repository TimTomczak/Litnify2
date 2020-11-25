@extends('layouts.app')

@section('content')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-sm-3">
{{--                <form id="submitFilter" method="GET" action="{{route('suche')}}">--}}
                    <div class="position-fixed">

                        <ul class="list-group">
                            <li class="list-group-item text-muted list-group-item-dark"><b>Art der Literatur</b></li>

                            <li class="list-group-item text-right {{request()->has('artikel') ? 'active-list-group-item' : '' }}">
                                <a href="{{request()->has('artikel') ?
                                        Helper::removeQueryStringParameters(['artikel']) :
                                        Helper::addQueryStringParameters(['artikel'=>'_'])}}">
                                    <span name="artikel" class="pull-left">Artikel</span>
                                    <span class="badge badge-pill badge-primary">{{$litTypeCounter['artikel']}}</span>
                                </a>
                            </li>
                            <li class="list-group-item text-right {{request()->has('graulit') ? 'active-list-group-item' : '' }}">
                                <a href="{{request()->has('graulit') ?
                                        Helper::removeQueryStringParameters(['graulit']) :
                                        Helper::addQueryStringParameters(['graulit'=>'_'])}}">
                                    <span name="graulit" class="pull-left">Graue Literatur</span>
                                    <span class="badge badge-pill badge-primary">{{$litTypeCounter['graulit']}}</span>
                                </a>
                            </li>
                            <li class="list-group-item text-right {{request()->has('buch') ? 'active-list-group-item' : '' }}">
                                <a href="{{request()->has('buch') ?
                                        Helper::removeQueryStringParameters(['buch']) :
                                        Helper::addQueryStringParameters(['buch'=>'_'])}}">
                                    <span class="pull-left">Buch</span>
                                    <span class="badge badge-pill badge-primary">{{$litTypeCounter['buch']}}</span>
                                </a>
                            </li>
                            <li class="list-group-item text-right {{request()->has('unwerk') ? 'active-list-group-item' : '' }}">
                                <a href="{{request()->has('unwerk') ?
                                        Helper::removeQueryStringParameters(['unwerk']) :
                                        Helper::addQueryStringParameters(['unwerk'=>'_'])}}">
                                    <span class="pull-left">Unselbständiges Werk</span>
                                    <span class="badge badge-pill badge-primary">{{$litTypeCounter['unwerk']}}</span>
                                </a>
                            </li>
                            <li class="list-group-item text-right {{request()->has('daten') ? 'active-list-group-item' : '' }}">
                                <a href="{{request()->has('daten') ?
                                        Helper::removeQueryStringParameters(['daten']) :
                                        Helper::addQueryStringParameters(['daten'=>'_'])}}">
                                    <span class="pull-left">Daten</span>
                                    <span class="badge badge-pill badge-primary">{{$litTypeCounter['daten']}}</span>
                                </a>
                            </li>
                        </ul>

                        <hr>

                        <ul class="list-group">
                            <li class="list-group-item text-muted list-group-item-dark"><b>Erscheinungsjahr</b></li>
                            <li class="list-group-item">
                                <form action="{{request()->fullUrl()}}" method="GET">
                                    <div class="form-inline">
                                        <input class="form-control" style="width:33%;" placeholder="von" type="number" min="1900" max="2099" name="dateFrom"
                                            {{request()->has('dateFrom') ? 'value='.request()->dateFrom : ''}}>
                                        &nbsp;&#45;&nbsp;
                                        <input class="form-control" style="width:33%;" placeholder="bis" type="number" min="1900" max="2099" name="dateTo"
                                            {{request()->has('dateTo') ? 'value='.request()->dateTo : ''}}>
                                        &nbsp;
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>

                        </ul>

                        <hr>

                        <!-- Example single danger button -->


                        <ul class="list-group">
                            <li class="list-group-item text-muted list-group-item-dark"><b>Suchergebnisse pro Seite</b></li>
                            {{--<li class="list-group-item">
                                <select class="form-control" style="width:100%;">
                                    <option><a href="?&ppr=10">10</a></option>
                                    <option><a href="?&ppr=11">11</a></option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </li>--}}
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{request()->has('ppr') ? request()->ppr : 10}}
                                </button>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="{{request()->has('ppr') ?
                                        Helper::updateQueryStringParameters(['ppr'=>'10']) :
                                        Helper::addQueryStringParameters(['ppr'=>'10'])}}">10</a>
                                    <a class="dropdown-item" href="{{request()->has('ppr') ?
                                       Helper::updateQueryStringParameters(['ppr'=>'11']) :
                                        Helper::addQueryStringParameters(['ppr'=>'11'])}}">11</a>
                                    <a class="dropdown-item" href="{{request()->has('ppr') ?
                                        Helper::updateQueryStringParameters(['ppr'=>'25']) :
                                        Helper::addQueryStringParameters(['ppr'=>'25'])}}">25</a>
                                    <a class="dropdown-item" href="{{request()->has('ppr') ?
                                        Helper::updateQueryStringParameters(['ppr'=>'50']) :
                                        Helper::addQueryStringParameters(['ppr'=>'50'])}}">50</a>
                                    <a class="dropdown-item" href="{{request()->has('ppr') ?
                                        Helper::updateQueryStringParameters(['ppr'=>'100']) :
                                        Helper::addQueryStringParameters(['ppr'=>'100'])}}">100</a>
                                </div>
                            </div>
                            @error('ppr')
                            <small class="form-text text-muted alert alert-danger">{{$message}}</small>
                            @enderror
                        </ul>

                    </div>
{{--                </form>--}}
            </div>
            <!--/col-3-->
            <div class="col-sm-9">
                <form action="{{route('suche')}}" method="GET">
                    <div class="form-group">
                        <div class="d-flex justify-content-around">
                            <input class="form-control mr-3" name="q" id="q" value="{{$searchQuery}}"/>
                            <button type="submit" class="btn btn-primary">Suchen</button>
                        </div>
                    </div>
                </form>

{{--                @livewire('search-component',['searchQueryArray' => $request->all()])--}}

                <div class="tab-content">
                    <form action="{{route('suche.export')}}" method="POST">
                        @csrf
                        <div class="d-flex align-items-end flex-column my-2">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>

                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <button type="submit" class="dropdown-item" name="export_type" value="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                                    <button type="submit" class="dropdown-item" name="export_type" value="xls"><i class="fa fa-file-excel-o" aria-hidden="true"></i> XLS</button>
                                    <button type="submit" class="dropdown-item" name="export_type" value="csv"><i class="fa fa-table" aria-hidden="true"></i> CSV</button>
                                    <button type="submit" class="dropdown-item" name="export_type" value="tex"><i class="fa fa-book" aria-hidden="true"></i>TEX</button>
                                </div>
                            </div>
                        </div>

                        @if($result)
                        <table class="{{$tableStyle}}">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach($tableBuilder as $key=>$val)
                                    <th>{{$val}}</th>
                                @endforeach
                                <th>Ansehen</th>
                            </tr>
                            </thead>
                                <tbody>
                                @foreach($result as $res)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label {{old('check_'.$res->id) ? 'active': ''}}">
                                                    <input class="form-check-input" type="checkbox" name="check_{{$res->id}}"
                                                               value="{{$res->id}} {{old('check_'.$res->id) ? 'checked="checked"': ''}}">
                                                </label>
                                            </div>
                                        </td>
                                        @foreach($tableBuilder as $key=>$val)
                                            @switch($key)
                                                @case('literaturart_id')
                                                <td>{{$res->literaturart->literaturart}}</td>
                                                @break

                                                @case('zeitschrift_id')
                                                <td>{{$res->zeitschrift!=null ? $res->zeitschrift->name : ''}}</td>
                                                @break

                                                @case('raum_id')
                                                <td>{{$res->raum!=null ? $res->raum->raum : ''}}</td>
                                                @break

                                                @case('hauptsachtitel')
                                                <td class="text-wrap"><a href="#" class="render-medium-modal " data-id="{{$res->id}}">{{$res->attributesToArray()[$key]}}</a></td>
                                                @break

                                                @case('autoren')
                                                <td>
                                                    @foreach(explode(';',$res->autoren) as $autor)
                                                        {{$autor}}<br>
                                                    @endforeach
                                                </td>
                                                @break

                                                @default
                                                <td>{{$res->attributesToArray()[$key]}}</td>

                                            @endswitch
                                        @endforeach
                                        <td><a href="{{route('medium.show',$res->id)}}"><button type="button" class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a></td>
                                    </tr>
                                @endforeach

                                </tbody>
                        </table>
                    </form>

                    <div class="d-flex justify-content-between">
                        {{ $result->appends(request()->all())->links() }}
                    </div>
                    @else
                        <div class="alert alert-info">Keine Ergebnisse gefunden.</div>
                    @endif
                    <!--/table-resp-->


                </div>

            </div>

        </div>
        <!--/col-9-->
    </div>
    <!--/row-->
    @include('Medienverwaltung.mediumModal')
@endsection

