<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Inventarliste;
use App\Models\Literaturart;
use App\Models\Medium;
use App\Models\Raum;
use App\Models\Zeitschrift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MediumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.medienverwaltung.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Literaturart $literaturart)
    {
        return view('admin.medienverwaltung.create',[
            'literaturarten' => Literaturart::all()->pluck('literaturart'),
            'literaturart' => $literaturart->literaturart,
            'nextMediumId' => $this->getNextAutoincrement('medien')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Die zu ersetzenden Fremdschlüssel erst validieren
        $request->validate([
            'literaturart_id' => ['string',Rule::in(Literaturart::all()->pluck('literaturart'))],
            'zeitschrift_id' => ['nullable',Rule::in(Zeitschrift::all()->pluck('name'))],
            'raum_id'=>['nullable', Rule::in(Raum::all()->pluck('raum'))]
        ]);

        $this->mapAuthorsFromRequest($request); //Autoren zu einem einzigen 'autoren'-String zusammenfügen
        $request=$this->stringToForeignId($request);

        $request->flashOnly('autoren'); //Für die Übergabe an die Livewire Autoren-Component die Autoren flashen
        $validatedAttributes=$this->validateAttributes();

        $med= Medium::create($validatedAttributes);
        $this->storeInventarnummer($request,$med->id);

        if (Auth::user()->berechtigungsrolle_id>3){
            $med->update(['released'=>1]);
        }

        return redirect(route('medium.create',''))->with([
            'title' => 'Medienverwaltung',
            'message' => 'Medium erfolgreich erstellt.',
            'alertType'=> 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medium $medium)
    {
        $exportData=[0=>clone $medium];
        if ($medium->released != 1){
            if (Auth::check()){
                if (Auth::user()->berechtigungsrolle_id<2){
                    return abort(403, 'Das Medium ist nicht freigegeben.');
                }

            }else{
                return abort(403, 'Das Medium ist nicht freigegeben.');
            }
        }

        if ($medium->deleted==1){
            if (Auth::check()){
                if (Auth::user()->berechtigungsrolle_id<3){
                    return abort('403','Medium wurde gelöscht');
                }
                else{

                    $medium = $this->foreignIdToString($medium);
                    return view('admin.medienverwaltung.show',[
                        'medium' => $medium,
                        'inventarnummernAusleihbar' => $medium->getInventarnummernAusleihbar(),
                        'tableBuilder' => TableBuilder::$mediumShow,
                        'aktionenStyles' => TableBuilder::$aktionenStyles,
                        'exportData' => $exportData,
                    ]);
                }
            }else{
                return abort('403','Medium wurde gelöscht');
            }
        }
        else{

            $medium = $this->foreignIdToString($medium);
            return view('admin.medienverwaltung.show',[
                'medium' => $medium,
                'inventarnummernAusleihbar' => $medium->getInventarnummernAusleihbar(),
                'tableBuilder' => TableBuilder::$mediumShow,
                'aktionenStyles' => TableBuilder::$aktionenStyles,
                'exportData' => $exportData,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medium  $medium
     */
    public function edit(Medium $medium)
    {
        $medium = $this->foreignIdToString($medium);
        return view('admin.medienverwaltung.edit',[
            'medium' => $medium,
            'literaturart' => $medium->literaturart_id,
            'literaturarten' => Literaturart::pluck('literaturart'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medium  $medium
     */
    public function update(Request $request, Medium $medium)
    {
        //
        $this->mapAuthorsFromRequest($request);
        $request=$this->stringToForeignId($request);
        $validatedAttributes=$this->validateAttributes();
        $medium->update($validatedAttributes);
        return redirect(route('medium.show',$medium->id))->with([
            'title' => 'Medienverwaltung',
            'message' => 'Medium geändert.',
            'alertType'=> 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medium  $medium
     */
    public function destroy(Medium $medium)
    {
        $medium->update(['deleted'=>1]);
        return redirect(route('medienverwaltung.index'))->with([
            'title' => 'Medienverwaltung',
            'message' => 'Medium "'.$medium->id.'" wurde gelöscht.',
            'alertType'=> 'danger'
        ]);
    }

    /**
     * Recover the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Medium $medium
     */
    public function recover(Medium $medium)
    {
        $medium->update(['deleted'=>0]);
        return back()->with([
            'title' => 'Wiederherstellung',
            'message' => 'Medium "'.$medium->id.'" wurde wiederhergestellt.',
            'alertType'=> 'success'
        ]);
    }

    public function showAutor($autor)
    {
        return view('admin.medienverwaltung.autor',[
            'autor' => $autor,
            'medien' => Medium::where('autoren','like','%'.$autor.'%')
                ->with('literaturart','zeitschrift','raum','inventarliste')
                ->where('deleted',0)
                ->where('released',1)
                ->paginate(10),
            'tableBuilder' => TableBuilder::$showAutor,
        ]);
    }

    protected function validateAttributes(){
        $validatedAttributes = request()->validate([
//            'id' => 'required|integer',
            'literaturart_id' => 'integer|min:1|max:5',
            'signatur' => 'nullable|string',
            'autoren' => 'nullable|string',
            'hauptsachtitel' => 'required',
            'untertitel' => 'nullable|string',
            'enthalten_in' => 'nullable|string',
            'erscheinungsort' => 'nullable|string',
            'jahr' => 'string|required|max:6',
            'verlag' => 'nullable|string',
            'isbn' => 'nullable|string',
            'issn' => 'nullable|string',
            'doi' => 'nullable|string',
            'auflage' => 'nullable|string',
            'herausgeber' => 'nullable|string',
            'schriftenreihe' => 'nullable|string',
            'zeitschrift_id' => 'nullable|integer',
            'band' => 'nullable|string',
            'seite' => 'nullable|string',
            'institut' => 'nullable|string',
            'raum_id' => 'nullable|integer|min:0|max:4',
            'bemerkungen' => 'nullable|string',
        ]);
        return $validatedAttributes;
    }

    private function stringToForeignId(Request $request){
        return $request->merge([
            'literaturart_id' => Literaturart::whereLiteraturart($request->get('literaturart_id'))->first()->id,
            'zeitschrift_id' => $request->get('zeitschrift_id')==null ?
                $request->get('zeitschrift_id') :
                Zeitschrift::whereName($request->get('zeitschrift_id'))->first()->id,
            'raum_id' => $request->get('raum_id')==null ?
                Raum::whereRaum('')->first()->id :
                Raum::whereRaum($request->get('raum_id'))->first()->id,
        ]);
    }

    private function foreignIdToString(Medium $medium){
        $medium->literaturart_id=$medium->literaturart->literaturart;
        $medium->zeitschrift_id=$medium->zeitschrift==null ? '' : $medium->zeitschrift->name;
        $medium->raum_id=$medium->raum==null ? '' : $medium->raum->raum;
        return $medium;
    }

    private function storeInventarnummer(Request $request, $medium_id){
        $inventarnummern=collect($request->toArray())->filter(function($value,$key){
            if (strpos($key,'inventarnummer_')!==false || strpos($key,'isb_')!==false || strpos($key,'ausleihbar_')!==false){
                return [$key=>$value];
            }
        });

        $nummern=[];
        foreach ($inventarnummern as $key => $val){
            if (strpos($key,'inventarnummer_')!==false){
                array_push($nummern,explode('_',$key)[1]);
            }
        }

        $inventarnummern=$inventarnummern->toArray();
        foreach ($nummern as $num){
            foreach ($inventarnummern as $key => $val){
                if ($key=='inventarnummer_'.$num){
                    $inventarnummer=$val;
                }

                if ($key=='ausleihbar_'.$num){
                    $ausleihbar= $val=='on' ? 1 : 0;
                }

                if ($key=='isb_'.$num){
                    $isb= $val=='on' ? 1 : 0;
                }
            }
            $ausleihbar = !isset($ausleihbar) ? 0 : $ausleihbar;
            $isb = !isset($isb) ? 0 : $isb;
            if ($isb==1){
                $ausleihbar=1;
            }
            $attributes = [
                'medium_id' => $medium_id=$medium_id,
                'inventarnummer' => $inventarnummer,
                'isb' => $isb,
                'ausleihbar' => $ausleihbar,
            ];
            $validatedAttributes= Validator::validate($attributes,[
                'medium_id' => 'required|integer',
                'inventarnummer' => 'required|string',
                'isb' => 'nullable|integer',
                'ausleihbar' => 'nullable|integer',
            ]);
            $inv=Inventarliste::create($validatedAttributes);
            $inv->medium()->attach($medium_id);

            $ausleihbar=null;
            $isb=null;
        }
    }

    /**
     * Nimmt ein Requ   est für ein Medium aus medium.edit, entfernt daraus nachnamen, vornamen und et_al, fügt diese
     * zu einem String zusammen und speichert diesen als 'autoren' in das Request-Objekt
     *
     * @param Request $request
     * @return Request
     */
    protected function mapAuthorsFromRequest(Request $request){
        // Autoren aus request zu einem String zusammenfügen und einzelne Vor- und Nachnamen aus Request entfernen
        $i=0;
        $autorenCounter=0;
        $authors = array(); // Autoren-Array initialisieren
        $nachname=null;
        $vorname=null;
        foreach($request->request as $key=>$val){
            if (strpos($key,'nachname')!==false){
                $nachname = $val;
                $i+=1;
            }
            elseif (strpos($key,'vorname')!==false){
                $vorname = $val;
                $i+=1;
            }
            elseif (strpos($key,'et_al')!==false){
                array_push($authors,'et al.');
                $request->request->remove('et_al');
                break;
            }
            if ($i>0 && $nachname==null && $vorname==null){
                break;
            }
            if ($i>0 && $i%2==0){ //Bei jedem zewiten Durchlauf einen Autor zusammensetzen und zum Array hinzufügen
                array_push($authors,$nachname.', '.$vorname);
                $nachname=null;
                $vorname=null;
                $request->request->remove('nachname'.$autorenCounter);
                $request->request->remove('vorname'.$autorenCounter);
                $autorenCounter+=1;
            }
        }
        $autoren = implode(';',$authors);

        $request->request->add(['autoren'=>$autoren]);
        return $request;
    }
}
