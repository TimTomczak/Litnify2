@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover">
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
                                <button class="btn btn-primary btn-sm" title="VIEW"><i class="fa fa-search"></i></button>
                                <button class="btn btn-success btn-sm" title="EDIT"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" title="DELETE"><i class="fa fa-minus-circle"></i></button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
