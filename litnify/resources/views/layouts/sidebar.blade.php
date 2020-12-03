
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin-Panel</div>
    <div class="list-group " >

        <a href="{{route('medienverwaltung.index')}}" class="list-group-item list-group-item-action {{ Helper::sidebar_active('*/medienverwaltung') }}">
            <i class="fa fa-book"></i> Medienverwaltung</a>
        <a href="{{route('freigabe.index')}}" class="list-group-item list-group-item-action indented {{ Helper::sidebar_active('*/medienverwaltung/freigabe') }}">
            <i class="fa fa-share-square-o"></i> Freigabe</a>
        <a href="{{route('medium.createEmpty','')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/medienverwaltung/medium/create*')}} indented ">
            <i class="fa fa-plus"></i> Medium erstellen</a>
        <a href="{{route('zeitschriften.index')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/zeitschriftenverwaltung')}}">
            <i class="fa fa-leanpub"></i> Zeitschriftenverwaltung</a>
        <a href="{{route('zeitschrift.create')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/zeitschriftenverwaltung/zeitschrift/create*')}} indented ">
            <i class="fa fa-plus"></i> Zeitschrift erstellen</a>

        @role(3)
        <a href="{{route('admin.nutzerverwaltung')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/nutzerverwaltung')}}">
            <i class="fa fa-users"></i> Nutzerverwaltung</a>
        <a href="{{route('admin.nutzerverwaltung.create')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/nutzerverwaltung/create')}} indented ">
            <i class="fa fa-plus"></i> Nutzer erstellen</a>
        @endrole

        <a href="{{route('ausleihverwaltung.index')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/ausleihverwaltung')}}">
            <i class="fa fa-retweet"></i> Ausleihverwaltung</a>
        <a href="{{route('ausleihenBeendet.index')}}" class="list-group-item list-group-item-action indented {{Helper::sidebar_active('*/ausleihverwaltung/ausleihen-beendet')}}">
            <i class="fa fa-retweet"></i> Ausleihen beendet</a>
        @role('3')
        <a href="{{route('merklistenverleih.index')}}" class="list-group-item list-group-item-action indented {{Helper::sidebar_active('*/ausleihverwaltung/merklistenverleih*')}}">
            <i class="fa fa-list-alt"></i> Merklistenverleih</a>
        <a href="{{route('direktverleih.index')}}" class="list-group-item list-group-item-action indented {{Helper::sidebar_active('*/ausleihverwaltung/direktverleih*')}} ">
            <i class="fa fa-address-card-o"></i> Direktverleih</a>
        @endrole

        @role('4')
        <a href="{{route('admin.systemverwaltung')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung') }}">
            <i class="fa fa-cogs"></i> Systemverwaltung</a>
        <a href="{{route('admin.systemverwaltung.auswertungen')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung/auswertungen')}} indented ">
            <i class="fa fa-bar-chart"></i> Auswertungen</a>
        <a href="{{route('admin.systemverwaltung.contenteditor')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung/contenteditor')}} indented ">
            <i class="fa fa-pencil-square-o"></i> Inhaltseditor</a>
        <a href="{{route('admin.systemverwaltung.logs')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung/logs')}} indented ">
            <i class="fa fa-pencil-square-o"></i> Logfiles</a>
        @endrole

    </div>
</div>


