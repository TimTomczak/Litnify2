<table>
    <thead>
    <tr>
        @foreach($tableBuilder as $key=>$val)
            <th>{{$val}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($merkliste as $item)
        <tr>
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
        </tr>
    @endforeach

    </tbody>
</table>
