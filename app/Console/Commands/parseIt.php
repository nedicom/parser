<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class parseIt extends Command{
    //getting name and desc
    protected $signature = 'parse:cars';
    protected $description = 'It checks cars';

    public function handle(){

        //getting path and checking it
        $path = $this->ask('Which is path to file? Now you here - '.__DIR__);
            if($path == ''){
                $path = 'data.xml';
            };

        $contents = Storage::get($path);

        if($contents==''){
            $this->error('You need to be carefully with file url! Try again, please.');
            return;
        }

        //converting to array
        $xml = simplexml_load_string($contents, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        foreach ($array['offers']['offer'] as $offer) {
        //creating an array for future checking
            $offersArray[] = $offer['id'];
            
        //cheking arrays inside for avoid empty values
            foreach($offer as $key=>$val){
                if(is_array($val) == 'Array'){
                    $val = 0;                                         
                }
                $arr[$key]=$val;
            }

        //inserting values and updating DB
            DB::table('auto')->upsert([
                'id' => $arr['id'],
                'mark' => $arr['mark'],
                'model' => $arr['model'],
                'generation' => $arr['generation'],
                'year' => $arr['year'],
                'run' => $arr['run'],
                'color' => $arr['color'],
                'body-type' => $arr['body-type'],
                'engine-type' => $arr['engine-type'],
                'transmission' => $arr['transmission'],
                'gear-type' => $arr['gear-type'],
                'generation_id' => $arr['generation_id']
            ], ['id'], 
            ['mark', 'model', 'generation', 'year', 'run', 'color', 'body-type', 'engine-type', 'transmission', 'gear-type', 'generation_id']
        );

        //deleting old values from DB   
            $cars = DB::table('auto')->pluck('id')->toArray();
            $deleted = array_diff($cars, $offersArray);
            foreach($deleted as $del){
                DB::table('auto')->where('id', $del)->delete();
            }  
        }
    }
}