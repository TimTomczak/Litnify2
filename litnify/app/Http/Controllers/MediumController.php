<?php

namespace App\Http\Controllers;

use App\Models\Literaturart;
use App\Models\Medium;
use App\Models\Raum;
use App\Models\Zeitschrift;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use function React\Promise\reduce;

class MediumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $medien = Medium::orderBy('id','DESC')
            ->where('released',1)
            ->where('deleted',0)
            ->limit(100)->get(); //Die letzten 100 Medien
        $mappedMedien=$this->mapForeignKeyReferences2String($medien);
        return view('Medienverwaltung.index',[
            'medien' => $mappedMedien
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Literaturart $literaturart)
    {
        // Falls Zeitschrift falsch
//        $zeitschrift_old=Zeitschrift::find(old('zeitschrift_id'));
//        if ($zeitschrift_old!=null){
//            $zeitschrift_old->get();
//        }


        return view('medienverwaltung.create',[
            'literaturart' => $literaturart->literaturart,
            'nextMediumId' => $this->getNextAutoincrement('medien')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
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
        $this->mapForeignKeyReferences2Id($request); // Fremdschlüssel mit IDs austauschen
        $validatedAttributes=$this->validateAttributes();
        $med= Medium::create($validatedAttributes);
        return redirect(route('medium.show',$med->id));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Medium $medium)
    {
        /* //TODO Wenn nicht authorisiert: Nicht feiegebene Medien nicht anzeigen
        if ($medium->released != 1){
            return abort(403, 'Das Medium ist nicht freigegeben.');
        }*/
        $medColl= collect(new Medium()); //Collection für mapForeignKeyReferences2String() erstellen
        $medColl->add($medium);
        $this->mapForeignKeyReferences2String($medColl);

        return view('Medienverwaltung.show',[
            'medium' => $medium
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medium  $medium
     */
    public function edit(Medium $medium)
    {
        $medColl= collect(new Medium());
        $medColl->add($medium);
        $medium_mapped=$this->mapForeignKeyReferences2String($medColl)->first();
        return view('Medienverwaltung.edit',[
            'medium' => $medium_mapped,
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
        $this->mapForeignKeyReferences2Id($request);
        $validatedAttributes=$this->validateAttributes();
        $medium->update($validatedAttributes);
        return redirect(route('medium.show',$medium->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medium  $medium
     */
    public function destroy(Medium $medium)
    {
        //
        $medium->update(['deleted'=>1]);
        return redirect(route('medium.show',$medium->id));
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

    /**
     * Nimmt ein Request Objekt eines Mediums und ersetzt die jeweiligen Strings von Literaturart, Raum und Zeitschrift
     * mit den entsprechenden IDs in deren Tabellen, um die Fremdnschlüssel zu erhalten
     *
     * @param Request $request
     * @return Request
     */
    protected function mapForeignKeyReferences2Id(Request $request){
        if ($request->request->get('literaturart_id')!=null){
            $literaturart = Literaturart::whereLiteraturart($request->request->get('literaturart_id'))->firstOrFail()->id;
//        $request->request->remove('literaturart_id');
            $request->request->add(['literaturart_id'=>$literaturart]);
        }
        if ($request->request->get('raum_id') != null){
            $raum = Raum::whereRaum($request->request->get('raum_id'))->firstOrFail()->id;
            $request->request->add(['raum_id'=>$raum]);
        }
        if ($request->request->get('zeitschrift_id') != null){
            $zeitschrift = Zeitschrift::whereName($request->request->get('zeitschrift_id'))->firstOrFail()->id;
            $request->request->add(['zeitschrift_id'=>$zeitschrift]);
        }

        return $request;
    }

    /**
     * Nimmmt eine Collection von Medien und ersetzt in jedem Medium-Objekt die Fremdschlüssel-IDs mit den
     * entsprechenden Strings, damit später nicht die IDs, sondern Strings ausgegeben werden
     *
     * @param $medien
     * @return mixed
     */
    protected function mapForeignKeyReferences2String($medien){
        $mappedLiteraturart = $this->mapLiteraturart($medien);
        $mappedRaum = $this->mapRaum($mappedLiteraturart);
        $mappedZeitschrift = $this->mapZeitschrift($mappedRaum);

        return $mappedZeitschrift;
    }

    protected function mapLiteraturart($medien){
        $mapped = $medien->map(function($item){
            if ($item->literaturart_id!=null){
                $item->literaturart_id=Literaturart::find($item->literaturart_id)->literaturart;
            }
            return $item;
        });
        return $mapped;
    }

    protected function mapRaum($medien){
        $mapped = $medien->map(function($item){
            if ($item->raum_id!=null){
                $item->raum_id=Raum::find($item->raum_id)->raum;
            }
            return $item;
        });
        return $mapped;
    }

    protected function mapZeitschrift($medien){
        $mapped = $medien->map(function($item){
            if ($item->zeitschrift_id!=null){
                $item->zeitschrift_id=\App\Models\Zeitschrift::find($item->zeitschrift_id)->name;
            }
            return $item;
        });
        return $mapped;
    }

    protected function validateAttributes(){
        $validatedAttributes = request()->validate([
            'id' => 'required|integer',
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
//            'inventarnummer' => '',
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
}
