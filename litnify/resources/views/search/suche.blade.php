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
                    <div class="position-relative">

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
                                    <div class="form-inline">
                                        <input class="form-control date" style="width:33%;" placeholder="von" type="number" min="1900" max="2099" pattern="^[0-9]{4}$" name="dateFrom" id="dateFrom"
                                            {{request()->has('dateFrom') ? 'value='.request()->dateFrom : ''}}>
                                        &nbsp;&#45;&nbsp;
                                        <input class="form-control date" style="width:33%;" placeholder="bis" type="number" min="1900" max="2099" pattern="^[0-9]{4}$" name="dateTo" id="dateTo"
                                            {{request()->has('dateTo') ? 'value='.request()->dateTo : ''}}>
                                        &nbsp;
                                        <button type="submit" class="btn btn-primary" id="dateFilter">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </button>

                                        <input type="hidden" id="currentUrl" value="{{request()->getRequestUri()}}">
                                    </div>
                            </li>

                        </ul>

                        <hr>

                        <ul class="list-group">
                            <li class="list-group-item text-muted list-group-item-dark"><b>Suchergebnisse pro Seite</b></li>
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

                        <hr>

                        <ul class="list-group">
                            <li class="list-group-item text-muted list-group-item-dark"><b>Ergbnisse exportieren</b></li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportformat
                                </button>

                                <div class="dropdown-menu">
                                    <button type="submit" class="dropdown-item" name="export_type" value="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </button>
                                    <button type="submit" class="dropdown-item" name="export_type" value="xls"><i class="fa fa-file-excel-o" aria-hidden="true"></i> XLS </button>
                                    <button type="submit" class="dropdown-item" name="export_type" value="csv"><i class="fa fa-table" aria-hidden="true"></i> CSV </button>
                                    <button type="submit" class="dropdown-item" name="export_type" value="tex"><i class="fa fa-book" aria-hidden="true"></i> BIB</button>
                                </div>
                            </div>
                        </ul>

                        <hr>


                        <div class="d-flex align-items-end flex-column my-2">

                        </div>


                    </div>




{{--                </form>--}}
            </div>
            <!--/col-3-->
            <div class="col-sm-9">
                <form action="{{route('suche')}}" method="GET">
                    <div class="form-group">
                        <div class="d-flex justify-content-around">
                            <input class="form-control mr-3" name="q" id="q" value="{{$searchQuery}}"/>
                            @foreach(request()->query() as $key => $val)
                                @if($key!=='q') {{-- Suchstring überspringen, damit dieser nicht mehrfach gesendet wird --}}
                                    <input class="form-control mr-3" name="{{$key}}" value="{{$val}}" style="display: none"/>
                                @endif
                            @endforeach
                            <button type="submit" class="btn btn-primary">Suchen</button>
                        </div>
                    </div>
                </form>

{{--                @livewire('search-component',['searchQueryArray' => $request->all()])--}}

                <div class="tab-content">
                    <form action="{{route('suche.export')}}" method="POST">
                        @csrf

                        @if($result)
                        <table class="{{$tableStyle}}">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="check_all" id="selectAll">
                                </th>
                                @foreach($tableBuilder as $key=>$val)
                                    <th>{{$val}}</th>
                                @endforeach
                                @auth
                                    <th></th>
                                @endauth
                            </tr>
                            </thead>
                                <tbody>
                                @foreach($result as $res)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label {{old('check_'.$res->id) ? 'active': ''}}">
                                                    <input class="form-check-input checkbox" type="checkbox" name="check_{{$res->id}}"
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
{{--                                        <td><a href="{{route('medium.show',$res->id)}}"><button type="button" class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a></td>--}}
                                        @auth
                                            <td>@livewire('add-to-merkliste-component',['medium'=>$res->id])</td>
                                        @endauth
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

@section('javascript.footer')
    <script>
        $(document).ready(function (){

            $('.date').keyup(function (){
                var value = $(this).val();
                if(value > 2100){
                    alert('Fehlerhafte Eingabe: Datum ');
                    $(this).val(value.slice(0,-1));
                }

            });


            $('#dateFilter').click(function (event) {
                event.preventDefault();

                var oldLink     = $('#currentUrl').val();
                var dateFrom    = $('#dateFrom').val();
                var dateTo      = $('#dateTo').val();
                var paramsArray = '';
                var newParams = '';


                if (oldLink.indexOf('=') !== -1) {
                    var params = (oldLink.split('?')[1]).split('&');

                    for (var i = 0; i < params.length; i++) {
                        paramsArray = params[i].split('=');
                        if (paramsArray[0] !== 'dateFrom') {
                            if(paramsArray[0] !== 'dateTo'){
                                newParams += paramsArray[0] + '=' + paramsArray[1] + '&';
                            }
                        }
                    }
                }
                window.location.href = (window.location.origin + '/suche?' + newParams + 'dateFrom=' + dateFrom + '&dateTo=' + dateTo);
            });

            $('#selectAll').click(function (event) {
                if (this.checked) {
                    $('.checkbox').each(function () {
                        $(this).prop('checked', true);
                    });
                } else {
                    $('.checkbox').each(function () {
                        $(this).prop('checked', false);
                    });
                }
            });

        })






    </script>
@endsection

