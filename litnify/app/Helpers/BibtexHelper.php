<?php


namespace App\Helpers;


use App\Models\Zeitschrift;

class BibtexHelper
{
    private $bibtex;
    private $data;

    public function __construct(array $data){
        $this->data=$data;
        $this->bibtex="";
    }

    protected $article=[
        //required
        'autoren' => 'author',
        'hauptsachtitel' => 'title',
        'zeitschrift_id' => 'journal',
        'jahr' => 'year',
        //optional
        'band' => 'volume',
//        '' => 'number',
        'seite' => 'pages',
//        '' => 'month',
//        'bemerkungen' => 'note'
    ];

    protected $book=[
        //required
        'autoren' => 'author', /* OR */ 'herausgeber' => 'editor',
        'hauptsachtitel' => 'title',
        'verlag' => 'publisher',
        'jahr' => 'year',
        //optional
        'band' => 'volume',
        'schriftenreihe' => 'series',
        'erscheinungsort' => 'address',
        'auflage' => 'edition',
//        '' => 'month',
//        'bemerkungen' => 'note'
    ];

    protected $unpublished=[
        //required
        'autoren' => 'author',
        'hauptsachtitel' => 'title',
//        'bemerkungen' => 'note',
        //optional
//        '' => 'month',
        'jahr' => 'year',
//        'bemerkungen' => 'note'
    ];


    protected $incollection=[
        //required
        'autoren' => 'author',
        'untertitel' => 'title',
        'hauptsachtitel' => 'booktitle',
        'jahr' => 'year',
        //optional
        'herausgeber' => 'editor',
        'seite' => 'pages',
//        '' => 'organization',
        'verlag' => 'publisher',
        'erscheinungsort' => 'address',
//        '' => 'month',
//        'bemerkungen' => 'note'
    ];

    protected $misc=[
        //required None
        //optional
        'autoren' => 'author',
        'hauptsachtitel' => 'title',
//        '' => 'howpublished',
//        '' => 'month',
        'jahr' => 'year',
//        'bemerkungen' => 'note'
    ];


    public function getBibtex(){
//        dd($this->data);
        foreach ($this->data as $key => $innerArray){
            switch ($innerArray['literaturart_id']){
                case 1:
                    $this->addArtikel($innerArray);
                    break;

                case 2:
                    $this->addBuch($innerArray);
                    break;

                case 3:
                    $this->addGraueLiteratur($innerArray);
                    break;

                case 4:
                    $this->addUnselbststaendigesWerk($innerArray);
                    break;

                case 5:
                    $this->addDaten($innerArray);
                    break;
            }
            $this->add('}'."\n\n");
        }
//        dd($this->bibtex);
        return $this->bibtex;
    }
    /*  Artikel Format
            @article{CitekeyArticle,
            author   = "P. J. Cohen",
            title    = "The independence of the continuum hypothesis",
            journal     = "Proceedings of the National Academy of Sciences",
            year     = 1963,

            OPTIONAL:
            volume   = "50",
            number   = "6",
            pages    = "1143--1148",
            month    = ""
            note     = ""
        }
    */
    private function addArtikel($data){
        $citekey=$this->getCitekey($data);
        $artikel="@article{".$citekey.','."\n";

        if (strpos($data["bemerkungen"],"Zeitschrift: ")!==false){
            $zeitschriftAusBemerkungen=substr($data["bemerkungen"],strpos($data["bemerkungen"],"Zeitschrift: ")+13); //Zeitschrift aus Bemerkungen herausfiltern
            $zeitschriftAusBemerkungen = substr($zeitschriftAusBemerkungen,0,strpos($zeitschriftAusBemerkungen," ")); //eventuellen weiteren Text nach Zeiutschrift herausfiltern
            $artikel=$artikel."\tjournal\t\t".'='."\t".'{'.$zeitschriftAusBemerkungen.'},'."\n";
        }
        foreach ($this->article as $key=>$val){

            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                if ($key == 'zeitschrift_id'){
                    $artikel=$artikel."\t".$val."\t\t".'='."\t".'{'.Zeitschrift::find($data[$key])->name.'}'."\n";
                }else{
                    $artikel=$artikel."\t".$val."\t\t".'='."\t".'{'.$data[$key].'},'."\n";
                }
            }
        }
        $this->removeLastCommaAndAndEtAl($artikel);
        $this->add($artikel);
    }

    private function addBuch($data){
        $citekey=$this->getCitekey($data);
        $buch="@book{".$citekey.','."\n";
        foreach ($this->book as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                $buch=$buch."\t".$val."\t\t".'='."\t".'{'.$data[$key].'},'."\n";
            }
        }
        $this->removeLastCommaAndAndEtAl($buch);
        $this->add($buch);
    }

    private function addGraueLiteratur($data){
        $citekey=$this->getCitekey($data);
        $graulit="@unpublished{".$citekey.','."\n";
        foreach ($this->unpublished as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                $graulit=$graulit."\t".$val."\t\t".'='."\t".'{'.$data[$key].'},'."\n";
            }
        }
        $this->removeLastCommaAndAndEtAl($graulit);
        $this->add($graulit);
    }

    private function addUnselbststaendigesWerk($data){
        $citekey=$this->getCitekey($data);
        $uwerk="@incollection{".$citekey.','."\n";
        foreach ($this->incollection as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                $uwerk=$uwerk."\t".$val."\t\t".'='."\t".'{'.$data[$key].'},'."\n";
            }
        }
        $this->removeLastCommaAndAndEtAl($uwerk);
        $this->add($uwerk);
    }

    private function addDaten($data){
        $citekey=$this->getCitekey($data);
        $daten="@misc{".$citekey.','."\n";
        foreach ($this->misc as $key=>$val){
            if (isset($data[$key])){
                $daten=$daten."\t".$val."\t\t".'='."\t".'{'.$data[$key].'},'."\n";
            }
        }
        $this->removeLastCommaAndAndEtAl($daten);
        $this->add($daten);
    }

    private function add(String $str){
        $this->bibtex=$this->bibtex.$str;
    }

    private function getCitekey($data){
        $citekey=explode(',',$data['autoren'])[0].'.'.$data['jahr'];
        return str_replace(';et al.','',$citekey);
    }

    private function removeLastCommaAndAndEtAl(&$string){
        $string=substr_replace($string,'',strrpos($string,','),1);
        $string=str_replace('and et al.','',$string);
//        return $string;
    }
}
