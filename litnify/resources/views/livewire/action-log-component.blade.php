<div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Logging</h5>
                <div class="form-group">
                    <select wire:model="date" class="form-control form-control-sm">
                        @foreach($log_dates as $date)
                            <option value="{{$date}}">{{$date}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p class="card-text">
            <div style="height: 50vh; overflow-y: auto;">
                @if(empty($data))
                    <div class="alert alert-primary">Keine relevanten Daten für dieses Datum.</div>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Time</th>
                            <th scope="col">WER</th>
                            <th scope="col">WAS</th>
                            <th scope="col">AKTION</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <th scope="row">{{date('G:i:s',strtotime($item['datetime']))}}</th>
                                    <td>{{$item['uid']}}</td>
                                    <td>{{$item['object']=='User' ? 'Nutzer' : $item['object']}} {{$item['object_id']}}</td>
                                    <td><i class="{{$log_aktionen[$item['aktion']]}}"></i></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
{{--                    @for($i=0; $i < 100; $i++)--}}
{{--                        <tr>--}}
{{--                            <th scope="row">{{$i}}</th>--}}
{{--                            <td>hallas</td>--}}
{{--                            <td>medium 91234</td>--}}
{{--                            <td><i class="fa fa-trash-o"></i></td>--}}
{{--                        </tr>--}}
{{--                        @php--}}
{{--                            $i++;--}}
{{--                        @endphp--}}
{{--                        <tr>--}}
{{--                            <th scope="row">{{$i}}</th>--}}
{{--                            <td>hense</td>--}}
{{--                            <td>User "muster"</td>--}}
{{--                            <td><i class="fa fa-plus"></i></td>--}}
{{--                        </tr>--}}
{{--                        @php--}}
{{--                            $i++;--}}
{{--                        @endphp--}}
{{--                        <tr>--}}
{{--                            <th scope="row">{{$i}}</th>--}}
{{--                            <td>hense</td>--}}
{{--                            <td>Medium 87651</td>--}}
{{--                            <td><i class="fa fa-pencil"></i></td>--}}
{{--                        </tr>--}}



{{--                    @endfor--}}



            </div>

            </p>
        </div>
    </div>

</div>
