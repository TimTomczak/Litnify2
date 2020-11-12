<div>
    @if ($message)
        <div id='success_alert' class="alert alert-success">
            {{$message}}
            <button wire:click="$set('message',null)" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <button wire:click="$set('message',null)" type="button" class="btn btn-primary">
            Weitere Zeitschrift erstellen
        </button>
    @else

        <form wire:submit.prevent="submitForm" action="{{route('zeitschrift.store')}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="id">ID</label>
                <input type="text"
                       class="form-control @error('id') border-danger @enderror " name="id" id="id" value="{{$nextId}}" readonly>
                @error('id')
                <div class="invalid-feedback d-block">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input wire:model.defer="name" type="text"
                       class="form-control @error('name') border-danger @enderror" name="name" id="name" value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback d-block">{{$message}}</div>
                @enderror
            </div>
            {{--<livewire:zeitschrift-name-input />--}}
            <div class="form-group">
                <label for="shortcut">Kürzel (shortcut)</label>
                <input wire:model.defer="shortcut" type="text"
                       class="form-control @error('shortcut') border-danger @enderror" name="shortcut" id="shortcut" value="{{old('shortcut')}}">
                @error('shortcut')
                <div class="invalid-feedback d-block">{{$message}}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn @if($errors->any()) btn-danger @elseif(session()->has('message')) btn-success @else btn-primary @endif">
                    <span wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <i wire:loading.remove class="fa @if($errors->any()) fa-times @elseif(session()->has('message')) fa-check @endif"></i> Erstellen
                </button>
            </div>
        </form>
    @endif
</div>
