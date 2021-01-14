@extends('layouts.app')

@section('content')


    @if($merkliste->count()==0)
        <div class="alert alert-info m-2">INFO: Sie haben keine Medien in der Merkliste!</div>
    @else
        <x-switch-appearance/>

        @if(Helper::showCards()=='true')
            @foreach($merkliste as $item)
                <x-medium-card :medium="$item">
                    <div class="d-flex border-0 justify-content-around">
                        <a href="{{route('medium.show',$item->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>
                        <form action="{{route('merkliste.edit')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Von Merkliste entfernen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                        </form>
                    </div>

                    <x-slot name="ausleihenSlot"></x-slot>
                </x-medium-card>
            @endforeach
        @elseif(Helper::showCards()=='false')
            <table class="{{$tableStyle}}">
                <thead>
                <tr>
                    @foreach($tableBuilder as $key=>$val)
                        <th>{{$val}}</th>
                    @endforeach
                    <th>Aktionen</th>
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
                        <td>
                            <div class="d-flex border-0 justify-content-around">
                                <a href="{{route('medium.show',$item->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a>
                                <form action="{{route('merkliste.edit')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <button type="submit" class="{{$aktionenStyles['delete']['button-class']}}" title="Von Merkliste entfernen"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        @endif

        {{-- Pagination --}}
        <div class="d-flex">
            <div class="mr-auto p-2">
                {{ $merkliste->links() }}
            </div>
            <div class="p-2">
                <x-export-panel/>
            </div>
        </div>

    @endif
    @include('admin.medienverwaltung.mediummodal')
@endsection

