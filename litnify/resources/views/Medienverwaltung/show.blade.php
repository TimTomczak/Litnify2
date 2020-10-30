@extends('layouts.app')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin-Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('medienverwaltung.index')}}">Medienverwaltung</a></li>
                <li class="breadcrumb-item active" aria-current="page">Medium anzeigen</li>
            </ol>
        </nav>

        @auth
        <div class="row">
            <a href="{{route('medium.edit',$medium->id)}}" class="btn btn-primary">Bearbeiten <i class="fa fa-edit"></i></a>
            <form action="{{route('medium.destroy',$medium->id)}}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Löschen <i class="fa fa-trash"></i></button>
            </form>
        </div>
        @endauth

        <table class="table table-striped table-bordered">
            <tbody>
            @foreach($medium->toArray() as $key=>$val)
            <tr>
                <td><b>{{$key}}</b></td>
                <td>{{$val}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
