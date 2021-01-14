<div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="literaturart_id">Literaturart</label>
                <select wire:model="literaturart" class="form-control" name="literaturart_id">
                    <option selected ></option>
                    <option value="2">Buch</option>
                    <option value="3">Graue Literatur</option>
                </select>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row">
                <div wire:loading.remove class="col-sm-4">
                    <label>Systematikgruppen</label>
                    @foreach($inputs as $key => $val)
                        <div class="form-group">
                            <div class="input-group">
                                <input wire:model.lazy="sysgrp_inputs.{{$key}}" type="text" class="form-control" name="sysgrp{{$val}}" id="sysgrp{{$val}}" list="sysgrps" placeholder="ANW-0, BMA3 ...">
                                <div class="input-group-append rounded-left">
                                    <button wire:click.prevent="remove({{$key}})" class="btn btn-danger"><i class="fa fa-minus-square"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <button wire:click.prevent="add({{$i}})" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i></button>
                </div>
                <datalist id="sysgrps">
                    @foreach($systematikgruppen as $sysgrp)
                        <option value="{{$sysgrp}}"></option>
                    @endforeach
                </datalist>




                <div wire:loading.remove class="col-sm-8 h-25">
                    @if($result->isNotEmpty())
                        <div class="card border-dark p-1">
                            <div class="overflow-auto" style="height: 50vh">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Literaturart</th>
                                        <th>Signatur</th>
                                        <th>Hauptsachtitel</th>
                                        <th>Aktion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($result as $res)
                                        <tr>
                                            <td>{{$res->id}}</td>
                                            <td><i class="{{\App\Helpers\Helper::$literaturartenIcons[$res->literaturart_id]}}"></i></td>
                                            <td>{{$res->signatur}}</td>
                                            <td>{{--<a href="#" class="render-medium-modal" data-id="{{$res->id}}">--}}{{$res->hauptsachtitel}}{{--</a>--}}</td>
                                            <td><a href="{{route('medium.show',$res->id)}}"><button class="{{$aktionenStyles['show']['button-class']}}" title="Medium ansehen"><i class="{{$aktionenStyles['show']['icon-class']}}"></i></button></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
{{--                        <script>--}}
{{--                            $(".render-medium-modal").click(function( event) {--}}
{{--                                var $mediumId = $(this).data('id');--}}
{{--                                $('#modalContent').empty();--}}
{{--                                var spinnerDiv = "<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>"--}}
{{--                                $('#modalContent').append(spinnerDiv);--}}
{{--                                $('#modalContent').load('/medium/'+$mediumId+' #medium');--}}
{{--                                $('#showMediumBtn').attr('href','/medium/'+$mediumId)--}}
{{--                                $('#mediumModal').modal('show');--}}
{{--                            });--}}
{{--                        </script>--}}
                    @endif
                </div>
            </div>
            <div wire:loading>
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
