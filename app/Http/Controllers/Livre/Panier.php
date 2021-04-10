<?php

namespace App\Http\Controllers\Livre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Panier extends Controller
{
    //

    /**
     * Ajout d'un livre au panier
     *
     */

    function ajoutAuPanier(Request  $request){

        $id_livre = request('livre_id');


        //on ajoute uniquement l'identifiant du produit
        if($request->session()->has('panier'))
        {

            $panier = session("panier");



            array_push($panier, $id_livre);

            //pas de doublons
            $panier =   array_unique($panier);
            session()->put("panier", $panier);

        }else{


            $panier = array();
            array_push($panier, $id_livre);
            $request->session()->put("panier", $panier);
        }

        return response()->json(['panier' => count(session()->get("panier")), 'ajout' => true]);


    }


    /**
     * Recuperer la panier de l'utilisateur (Voir panier)
     *
     */
    function  recupererPanier(){


        if(session()->has('panier')){

           $data = DB::table('livres')->select('titre', 'nom_img', 'prix', 'reduction', 'id')
              ->whereIn('id', session('panier'))->get();

            return response()->json(['panier' => $data, 'vide' => false, 'nb_livre' => count(session('panier')) ]);

        }else{
            return response()->json(['vide' => true] );

        }
    }
    function retirerAuPanier(Request  $request){

        $id_livre = request('livre_id');


        if($request->session()->has('panier'))
        {

            $panier = session("panier");



            foreach ($panier as $key => $value){
                if ($value == $id_livre) {
                    unset($panier[$key]);
                    break;
                }
            }
            $panier =   array_unique($panier);
            session()->put("panier", $panier);

        }

        return response()->json(['retrait' => true]);


    }
}

