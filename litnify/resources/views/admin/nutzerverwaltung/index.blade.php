@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="{{$tableStyle}}">
                    <thead>

                    <tr>
                        @foreach($tableBuilder as $key=>$val)
                            <th scope="col">{{$val}}</th>
                        @endforeach
                        <th>Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            @foreach($tableBuilder as $key=>$val)
                                @switch($key)
                                    @case('id')
                                    <td scope="row">{{$user->attributesToArray()[$key]}}</td>
                                    @break

                                    @case('berechtigungsrolle_id')
                                    <td>{{$user->berechtigungsrolle->berechtigungsrolle}}</td>
                                    @break

                                    @case('created_at')
                                    <td>{{$user->attributesToArray()[$key]!=null ? $user->created_at->format('d.m.Y  G:i') : ''}}</td>
                                    @break

                                    @default
                                    <td>{{$user->attributesToArray()[$key]}}</td>
                                @endswitch
                            @endforeach
                            <td>
                                <button class="{{$aktionenStyles['show']['button-class']}}" title="VIEW"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button>
                                <button class="{{$aktionenStyles['edit']['button-class']}}" title="EDIT"><i class="{{$aktionenStyles['edit']['icon-class']}}"></i></button>
                                <button class="{{$aktionenStyles['delete']['button-class']}}" title="DELETE"><i class="{{$aktionenStyles['delete']['icon-class']}}"></i></button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
