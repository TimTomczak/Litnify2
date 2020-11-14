
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin-Panel</div>
    <div class="list-group " >
        <a href="{{route('start')}}" class="list-group-item list-group-item-action {{ Helper::sidebar_active('/') }}">
            <i class="fa fa-home"></i> Startseite</a>
        <a href="{{route('medienverwaltung.index')}}" class="list-group-item list-group-item-action {{ Helper::sidebar_active('/admin/medienverwaltung') }}">
            <i class="fa fa-book"></i> Medienverwaltung</a>
        <a href="{{route('medium.create','')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('medienverwaltung/medium/create*')}} indented ">
            <i class="fa fa-plus"></i> Medium erstellen</a>
        <a href="{{route('zeitschriften.index')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('medienverwaltung/zeitschriften')}} indented">
            <i class="fa fa-leanpub"></i> Zeitschriften</a>
        <a href="{{route('zeitschrift.create')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('medienverwaltung/zeitschrift/create*')}} indented ">
            </i> Zeitschrift erstellen</a>


        <a href="{{route('admin.nutzerverwaltung')}}" class="list-group-item list-group-item-action {{ Helper::sidebar_active('*/nutzerverwaltung') }}">
            <i class="fa fa-user"></i> Nutzerverwaltung</a>

        <a href="{{route('admin.ausleihverwaltung')}}" class="list-group-item list-group-item-action {{ Helper::sidebar_active('*/ausleihverwaltung') }}">
            <i class="fa fa-retweet"></i> Ausleihverwaltung</a>

        <a href="{{route('admin.systemverwaltung')}}" class="list-group-item list-group-item-action {{ Helper::sidebar_active('*/systemverwaltung') }}">
            <i class="fa fa-cogs"></i> Systemverwaltung</a>
        <a href="{{route('admin.systemverwaltung.auswertungen')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung/auswertungen')}} indented ">
            <i class="fa fa-bar-chart"></i> Auswertungen</a>
        <a href="{{route('admin.systemverwaltung.contenteditor')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung/contenteditor')}} indented ">
            <i class="fa fa-pencil-square-o"></i> Inhaltseditor</a>
        <a href="{{route('admin.systemverwaltung.logs')}}" class="list-group-item list-group-item-action {{Helper::sidebar_active('*/systemverwaltung/logs')}} indented ">
            <i class="fa fa-pencil-square-o"></i> Logfiles</a>

    </div>
</div>