<?php

namespace App\Http\Controllers\Meteo;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class Meteo extends Controller
{

    /**
     * La météo d'une ville donnée en paramètre ville= 'paris'
     *
     */
    function getVille(Request $request){


      //  $data =file_get_contents('https//api.openweathermap.org/data/2.5/weather?q=paris&appid=6c945c5ad184357364000879a164fb93&lang=fr&units=metric');

        try {
            return response()->json(array('data' => json_decode(file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' .
                request('ville') . '&appid=6c945c5ad184357364000879a164fb93&lang=fr&units=metric')),'trouve' => true
            ));
        } catch( Exception $e ){
            //Rechercher une ville (Aucune ville trouvéé)
            return response()->json(array(['trouve' =>  false]));
        }
    }
}
