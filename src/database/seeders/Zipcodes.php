<?php

namespace Database\Seeders;

use App\Models\Zipcodes as MongoZipcodes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class Zipcodes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MongoZipcodes::truncate();
        //$lines = $this->stripAccents(Storage::get('public/CPdescarga.txt'));
        $lines = $this->stripAccents(Storage::get('public/CPdescarga.txt'));

        $lines=explode("\n",$lines);
        array_shift($lines);
        $columns=explode("|",array_shift($lines));
        $zipCode=[];
        $currentCode=0;
        foreach ($lines as $zip) {
            // separamos los datos
            $zip=explode("|",$zip);

            if(count($zip) != 15) continue;
            
            /*
                 * 0 => "d_codigo": //zip_code
                 * 1 => "d_asenta": //settlements[0].name
                 * 2 => "d_tipo_asenta": //settlements[0].settlement_type.name
                 * 3 => "D_mnpio": //municipality.name
                 * 4 => "d_estado": //federal_entity.name
                 * 5 => "d_ciudad": //locality
                 * 6 => "d_CP": //?
                 * 7 => "c_estado": //federal_entity.key
                 * 8 => "c_oficina": //?
                 * 9 => "c_CP": "",  //?
                 * 10 => "c_tipo_asenta": //?
                 * 11 => "c_mnpio": //municipality.key
                 * 12 => "id_asenta_cpcons": //settlements[0].key
                 * 13 => "d_zona": //settlements[0].zone_type
                 * 14 => "c_cve_ciudad": //?
            */
            //definimos el settlement
            $settle=[
                "key" => $zip[12]*1,
                "name" => strtoupper($zip[1]),
                "zone_type" => strtoupper($zip[13]),
                "settlement_type" => ["name" => $zip[2]]
            ];

            //añadimos a uno existente o creamos nuevo
            if($currentCode == $zip[0]){
                //agregamos otro a settlement
                $zipCode[$zip[0]]["settlements"][count($zipCode[$zip[0]]["settlements"])]=$settle;
            }else{
                //guardamos el anterior y limpiamos el zipcode
                if(!empty($zipCode)){
                    if(MongoZipcodes::insert($zipCode[$currentCode])){
                        unset($zipCode[$currentCode]);
                    }
                }

                // si el zipcode es otro entonces llenamos los otros datos una sola vez
                /**
                 * zip_code
                 * locality
                 * federal_entity
                 * municipality
                 */
                $zipCode[$zip[0]]=[
                    "zip_code"=>$zip[0],
                    "locality"=>strtoupper($zip[5]),
                    "federal_entity"=>[
                        "key"=>$zip[7]*1,
                        "name"=>strtoupper($zip[4]),
                        "code"=>null,
                    ],
                    "municipality"=>[
                        "key"=>$zip[11]*1,
                        "name"=>strtoupper($zip[3]),
                    ],
                    "settlements"=>[$settle]
                ];
            }

            //definimos el current como el zip[0]
            $currentCode=$zip[0];
        }
    }

    private function stripAccents($str) {
        //return iconv('UTF-8', 'UTF-8//IGNORE', $str);
        //return utf8_decode($str);
        //return mb_convert_encoding($str, "windows-1251", "utf-8");
        $str=str_replace("´","?",$str);
        return strtr(utf8_decode(iconv('UTF-8', 'UTF-8//IGNORE', $str)), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY´');
    }
}
