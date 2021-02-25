<?php


namespace App\Helpers;


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
        'zeitschrift' => 'journal',
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
        $citekey=explode(',',$data['autoren'])[0].'.'.$data['jahr'];
        $artikel="@article{".$citekey.','."\n";
        foreach ($this->article as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                if ($key == 'zeitschrift'){
                    $artikel=$artikel."\t".$val."\t\t".'='."\t".'{'.$data[$key]["name"].'}'."\n";
                }else{
                    $artikel=$artikel."\t".$val."\t\t".'='."\t".'{'.$data[$key].'}'."\n";
                }
            }
        }
        $this->add($artikel);
    }

    private function addBuch($data){
        $citekey=explode(',',$data['autoren'])[0].'.'.$data['jahr'];
        $buch="@book{".$citekey.','."\n";
        foreach ($this->book as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                $buch=$buch."\t".$val."\t\t".'='."\t".'{'.$data[$key].'}'."\n";
            }
        }
        $this->add($buch);
    }

    private function addGraueLiteratur($data){
        $citekey=explode(',',$data['autoren'])[0].'.'.$data['jahr'];
        $graulit="@unpublished{".$citekey.','."\n";
        foreach ($this->unpublished as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                $graulit=$graulit."\t".$val."\t\t".'='."\t".'{'.$data[$key].'}'."\n";
            }
        }
        $this->add($graulit);
    }

    private function addUnselbststaendigesWerk($data){
        $citekey=explode(',',$data['autoren'])[0].'.'.$data['jahr'];
        $uwerk="@incollection{".$citekey.','."\n";
        foreach ($this->incollection as $key=>$val){
            if (isset($data[$key])){
                if ($key=='autoren'){
                    $data[$key]=str_replace(';',' and ', $data[$key]);
                }
                $uwerk=$uwerk."\t".$val."\t\t".'='."\t".'{'.$data[$key].'}'."\n";
            }
        }
        $this->add($uwerk);
    }

    private function addDaten($data){
        $citekey=explode(',',$data['autoren'])[0].'.'.$data['jahr'];
        $daten="@misc{".$citekey.','."\n";
        foreach ($this->misc as $key=>$val){
            if (isset($data[$key])){
                $daten=$daten."\t".$val."\t\t".'='."\t".'{'.$data[$key].'}'."\n";
            }
        }
        $this->add($daten);
    }

    private function add(String $str){
        $this->bibtex=$this->bibtex.$str;
    }
}
