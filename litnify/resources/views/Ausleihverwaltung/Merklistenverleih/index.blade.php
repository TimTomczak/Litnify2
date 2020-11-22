@extends('layouts.app')
@section('content')
   <div class="container">
        <table class="table table-bordered table-hover table-responsive-lg">
            <thead>
            <tr>
                <th>ID Nutzer</th>
                <th>E-Mail-Adresse</th>
                <th>Name</th>
                <th>Anzahl Medien auf Merkliste</th>
                <th>davon ausleihbar</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merklisten as $merk)
                <tr>
                    <td>{{$merk->user_id}}</td>
                    <td>{{$merk->user->email}}</td>
                    <td>{{$merk->user->nachname}}, {{$merk->user->vorname}}</td>
                    <td>{{\App\Models\Merkliste::where('user_id',$merk->user_id)->count()}}</td>
                    <td>
                        {{\App\Models\Merkliste::where('user_id',2)->get()->filter(function($med){
                            if ($med->medium->isAusleihbar()){
                                return $med->medium;
                            }
                            })->count()}}
                    </td>
                    <td>
                        <a href="{{route('merklistenverleih.show',$merk->user_id)}}" class="btn btn-primary btn-sm">zum Verleih</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
       <div class="d-flex justify-content-between">
           {{ $merklisten->links() }}
       </div>
    </div>
@endsection
