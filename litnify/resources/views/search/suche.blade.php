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
            <div class="col-lg-3">
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
                                    <span class="pull-left">Unselbstständiges Werk</span>
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
                                        <input class="form-control form-control-sm date" style="width:33%;" placeholder="von" type="number" min="1900" max="2099" pattern="^[0-9]{4}$" name="dateFrom" id="dateFrom"
                                            {{request()->has('dateFrom') ? 'value='.request()->dateFrom : ''}}>
                                        &nbsp;&#45;&nbsp;
                                        <input class="form-control form-control-sm date" style="width:33%;" placeholder="bis" type="number" min="1900" max="2099" pattern="^[0-9]{4}$" name="dateTo" id="dateTo"
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
                            <li class="list-group-item text-muted list-group-item-dark"><b>Ausleihbare Medien</b></li>
                            <a class="btn {{request()->has('onlyBorrowable') ? 'btn-primary' : 'btn-outline-primary'}}"
                                href="{{request()->has('onlyBorrowable') ?
                                Helper::removeQueryStringParameters(['onlyBorrowable']) :
                                Helper::addQueryStringParameters(['onlyBorrowable'=>'_'])}}">Nur ausleihbare Medien anzeigen
                            </a>
                        </ul>

                        <hr>

                        <ul class="list-group">
                            <li class="list-group-item text-muted list-group-item-dark"><b>Sortieren nach</b></li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{request()->has('sort')&&array_key_exists(request()->sort,App\Helpers\TableBuilder::$sucheIndex) ? App\Helpers\TableBuilder::$sucheIndex[request()->sort]  : 'Relevanz'}}
                                    @if(request()->has('sort')&&array_key_exists(request()->sort,App\Helpers\TableBuilder::$sucheIndex)&&request()->has('direction'))
                                        @if(request()->get('direction')=='asc')
                                            - aufsteigend
                                        @elseif(request()->get('direction')=='desc')
                                            - absteigend
                                        @endif
                                    @endif
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="{{Helper::addQueryStringParameters(['sort'=>'relevanz','direction'=>'_'])}}">Relevanz</a>
                                    <a class="dropdown-item"
                                       href="{{Helper::addQueryStringParameters(['sort'=>'jahr','direction'=>'asc'])}}">Jahr - aufsteigend</a>
                                    <a class="dropdown-item"
                                       href="{{Helper::addQueryStringParameters(['sort'=>'jahr','direction'=>'desc'])}}">Jahr - absteigend</a>
                                </div>
                            </div>
                            @error('ppr')
                            <small class="form-text text-muted alert alert-danger">{{$message}}</small>
                            @enderror
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

                        <div class="d-flex align-items-end flex-column my-2">
                        </div>
                    </div>

{{--                </form>--}}
            </div>
            <!--/col-3-->
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-10">
                        <form action="{{route('suche')}}" method="GET">
                            <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" name="q" id="q" value="{{$searchQuery}}"/>
                                        @foreach(request()->query() as $key => $val)
                                            @if($key!=='q') {{-- Suchstring überspringen, damit dieser nicht mehrfach gesendet wird --}}
                                            <input class="form-control" name="{{$key}}" value="{{$val}}" style="display: none"/>
                                            @endif
                                        @endforeach
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Suchen</button>
                                        </div>
                                    </div>

                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">{{request()->has('filter') ? Helper::getSuchFilterValue(request()->query('filter')) : 'Suche filtern'}}</button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                @foreach(App\Helpers\Helper::$suchFilter as $filterItem)
                                    @if(request()->has('filter'))
                                        @if($filterItem['short'] != request()->query('filter'))
                                            <a class="dropdown-item" href="{{Helper::updateQueryStringParameters(['filter'=>$filterItem['short']])}}">{{$filterItem['full']}}</a>
                                        @endif
                                    @else
                                        <a class="dropdown-item" href="{{Helper::addQueryStringParameters(['filter'=>$filterItem['short']])}}">{{$filterItem['full']}}</a>
                                    @endif
                                @endforeach
                                @if(request()->has('filter'))
                                    <div class="dropdown-divider"></div>
                                        <a href="{{Helper::removeQueryStringParameters(['filter'])}}" class="dropdown-item"><strong>Filter entfernen</strong></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <x-switch-appearance/>
                    @if($result)
                        @if(Helper::showCards()=='true')
                            <ul class="list-group list-group-flush">
                                @foreach($result as $res)
                                    <x-medium-card :medium="$res">
                                         {{--Aktionen hier einfügen--}}
                                        @auth
                                            @livewire('add-to-merkliste-component',['medium'=>$res->id])
                                        @endauth
                                         {{--Aktionen ENDE--}}

                                        <x-slot name="ausleihenSlot"></x-slot>
                                    </x-medium-card>
                                @endforeach
                            </ul>
                        @elseif(Helper::showCards()=='false')
                            <table class="{{$tableStyle}}">
                                <thead>
                                <tr>
                                    @foreach($tableBuilder as $key=>$val)
                                        <th>
                                            {{$val}} @if(Helper::getQueryStringParameters('sort')==$key) @if(Helper::getQueryStringParameters('direction')=='asc')<i class="fa fa-sort-alpha-asc"></i>@elseif(Helper::getQueryStringParameters('direction')=='desc')<i class="fa fa-sort-alpha-desc"></i>@endif @endif
                                        </th>
                                    @endforeach
                                    @auth
                                        <th><a tabindex="0"  id="addToMerklisteInfoButton" type="button" class="btn btn-link btn-sm" ><i class="fa fa-info-circle"></i></a></th>
                                    @endauth
                                </tr>
                                </thead>
                                    <tbody>
                                    @foreach($result as $res)
                                        <tr>
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
{{--                                            <td><a href="{{route('medium.show',$res->id)}}"><button type="button" class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a></td>--}}
                                            @auth
                                                <td>@livewire('add-to-merkliste-component',['medium'=>$res->id])</td>
                                            @endauth
                                        </tr>
                                    @endforeach

                                    </tbody>
                            </table>
                        @endif
{{--                    </form>--}}

                        <div class="d-flex justify-content-between mt-2">
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
    @include('admin.medienverwaltung.mediummodal')
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
        })

    </script>
@endsection

