
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin-Panel</div>
    <div class="list-group " >
        <a href="{{route('start')}}" class="list-group-item list-group-item-action {{request()->path()==='/' ? 'active' : 'bg-light'}}"><i class="fa fa-home"></i> Startseite</a>
        <a href="{{route('medienverwaltung.index')}}" class="list-group-item list-group-item-action {{request()->path()==='medienverwaltung' ? 'active' : 'bg-light'}}"><i class="fa fa-book"></i> Medienverwaltung</a>
        <a href="{{route('medium.create','')}}" class="list-group-item list-group-item-action {{request()->is('medienverwaltung/medium/create*') ? 'active' : 'bg-light'}} indented "><i class="fa fa-plus"></i> Medium erstellen</a>
        <a href="{{route('zeitschriften.index')}}" class="list-group-item list-group-item-action {{request()->path()==='medienverwaltung/zeitschriften' ? 'active' : 'bg-light'}} indented"><i class="fa fa-leanpub"></i> Zeitschriften</a>
        <a href="{{route('zeitschrift.create')}}" class="list-group-item list-group-item-action {{request()->path()==='medienverwaltung/zeitschrift/create' ? 'active' : 'bg-light'}} indented "><i class="fa fa-plus"></i> Zeitschrift erstellen</a>
    </div>
</div>
