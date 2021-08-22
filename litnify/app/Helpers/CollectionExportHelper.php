<?php


namespace App\Helpers;


use App\Models\Berechtigungsrolle;
use App\Models\Literaturart;
use App\Models\Raum;
use App\Models\Zeitschrift;

class CollectionExportHelper
{
    /**
     * Tauscht die Fremdschlüsselwerte der Models in der Collection gegen die entsprechenden Strings aus
     * Bspw.: Medium hat literaturart_id = 1, daraus wird literaturart_id = "Artikel"
     *
     * @param array $exportData
     * @return array
     */
    public static function mapForeignKeys(array $exportData, $columns){
        if (array_key_exists('literaturart_id',$exportData[array_key_first($exportData)])){                  // Wenn literaturart_id in Collection ...
            $literaturarten=Literaturart::all()->toArray();
            foreach ($exportData as $key=>$data){
                if ($data['literaturart_id']==null){
                    $exportData[$key]['literaturart_id']="";
                }else{
                    $exportData[$key]['literaturart_id']=$literaturarten[$data['literaturart_id']-1]['literaturart'];
                }
            }
        }

        if (array_key_exists('raum_id',$exportData[array_key_first($exportData)])){                          // Wenn raum_id in Collection ...
            $raeume=Raum::all()->toArray();
            foreach ($exportData as $key=>$data){
                if ($data['raum_id']==null){
                    $exportData[$key]['raum_id']="";
                }else{
                    $exportData[$key]['raum_id']=$raeume[$data['raum_id']-1]['raum'];
                }
            }
        }

        if (array_key_exists('zeitschrift_id',$exportData[array_key_first($exportData)])){                  // Wenn zeitschrift_id in Collection ...
            $zeitschriften=Zeitschrift::all()->toArray();
            foreach ($exportData as $key=>$data){
                if ($data['zeitschrift_id']==null){
                    $exportData[$key]['zeitschrift_id']="";
                }else{
                    $exportData[$key]['zeitschrift_id']=$zeitschriften[$data['zeitschrift_id']-1]['name'];
                }
            }
        }

        if (array_key_exists('berechtigungsrolle_id',$exportData[array_key_first($exportData)])){                  // Wenn berechtigungsrolle_id in Collection ...
            $berechtigungsrollen=Berechtigungsrolle::all()->toArray();
            foreach ($exportData as $key=>$data){
                if ($data['berechtigungsrolle_id']==null){
                    $exportData[$key]['berechtigungsrolle_id']="";
                }else{
                    $exportData[$key]['berechtigungsrolle_id']=$berechtigungsrollen[$data['berechtigungsrolle_id']-1]['berechtigungsrolle'];
                }
            }
        }

        /* Array nach Spalten ordnen */
        $exportData=array_map(function($item) use ($columns) {
            $arr_ordered=[];
            foreach ($columns as $key=>$val){
                $arr_ordered[$key]=$item[$key];
            }
            return $arr_ordered;
        },$exportData);

        return $exportData;
    }
}
