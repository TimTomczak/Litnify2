<div>

    <div class="card shadow mb-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center mb-n3">
                @if($medium->literaturart!=null)
                    <p><i class="{{Helper::$literaturartenIcons[$medium->literaturart_id]}} fa-lg mr-2"></i> <strong>{{$medium->literaturart->literaturart}}</strong></p>
                @endif
                <p><strong><a href="{{route('suche').'?q='.$medium->signatur.'&filter=sign'}}" title="Signatur">{{$medium->signatur}}</a></strong></p>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{$medium->hauptsachtitel}} <small class="text-muted">{{$medium->untertitel}}</small></h5>
            <p class="card-text mt-n1">
                @if($medium->autoren!='')
                    <em>-
                        @foreach(explode(';',$medium->autoren) as $autor)
                            @if(strpos($autor,'et al')!==false)
                                {{$autor}}
                            @else
                                <a href="{{route('autor.show',$autor)}}">{{$autor}}</a>
                                @if(!$loop->last)
                                    ,
                                @endif
                            @endif
                        @endforeach
                    </em>
                @endif
            </p>
            <div class="d-flex justify-content-between mt-n2 mb-n4">
                <p class="card-text">
                    @if($medium->zeitschrift_id!=null)
                        <a href="{{route('suche').'?q='.$medium->zeitschrift->name.'&filter=ztitel'}}" title="Zeitschrift">{{$medium->zeitschrift->name}}</a>
                        -
                    @endif {{$medium->jahr}}
                        <span class="card-text-right">
                            <em>{{$medium->erscheinungsort}}</em>
                        </span>
                </p>

                {{-- ORT--}}
                @if($medium->raum!=null)
                    <p class="card-text">{{$medium->raum->raum}}</p>
                @endif
                {{-- / ORT--}}
            </div>

            <hr>
            <div class="d-flex justify-content-between mb-n2 mt-n2">
                <div>
                    <a href="#" class="card-link render-medium-modal" data-id="{{$medium->id}}">Mehr Informationen</a>
                </div>
                <div>
                    {{-- ACTIONS --}}
                    {{$slot}}
                    {{-- / ACTIONS--}}
                </div>
            </div>
            {{$ausleihenSlot}}
        </div>
    </div>

</div>
