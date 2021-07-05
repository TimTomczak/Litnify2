@component('mail::message')
# Leihfrist endet bald !
___


Sehr geehrte( r) Frau/Herr {{$user->nachname}},
<br>
<br>
dies ist eine Voraberinnerung, dass die Leihfrist @if($ausleihen->count()>1) der folgenden Medien @else des folgenden Mediums @endif bald endet.
Wir bitten Sie daher um eine rechtzeitige Rückgabe oder Verlängerung der Leihfrist.
<br>
<br>
<em>This is a reminder that the loan period of the following @if($ausleihen->count()>1) media @else medium @endif will end soon. We therefore ask you to return or extend the loan period in good time.</em>

@component('mail::panel')

<table>
    @foreach($ausleihen as $aus)
        @php
            $medium=App\Models\Medium::find($aus->medium_id)
        @endphp
    <tr>
        <td><b>Medium ID</b></td>
        <td>{{$medium->id}}</td>
    </tr>
    <tr>
        <td><b>Titel</b></td>
        <td>{{$medium->hauptsachtitel}} {{$medium->untertitel}}</td>
    </tr>
    <tr>
        <td><b>Inventarnummer</b></td>
        <td>{{$aus->inventarnummer}}</td>
    </tr>
    <tr>
        <td><b>Ausleihdatum</b></td>
        <td>{{date('d.m.Y',strtotime($aus->Ausleihdatum))}}</td>
    </tr>
    <tr>
        <td><b>Rückgabefrist-Ende</b></td>
        <td><b>{{date('d.m.Y',strtotime($aus->RueckgabeSoll))}}</b></td>
    </tr>
    <tr>
        <td><b>Bisherige Verlängerungen</b></td>
        <td>{{$aus->Verlaengerungen}}</td>
    </tr>
    @if(!$loop->last)
        <tr><td>_</td><td>_</td></tr>
    @endif
    @endforeach
</table>
@endcomponent

Mit freundlichen Grüßen
<br>
{{ env('MAIL_SALUTION') }}
@endcomponent


