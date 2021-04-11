<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Accueil extends Controller
{
    //

    /**
     * Page d'accueil avec une pagination de 4 /page
     *
     */
    public  function Index(Request  $request){
        $data = DB::table('livres')->select()->inRandomOrder('1234')
            ->paginate(4);

        return response()->json(['data' => $data]);

    }
    /**
     * La liste des livre d'une certaine categorie
     *
     */
    function getCategorie(Request  $request){
        $data = DB::table('livres')->select()->where('id_cat','=',request('cat'))->paginate(4);

        return response()->json(['data' => $data]);

    }

    /**
     * Liste des categorie de livre disponible
     *
     */
    function getListeDesCategories(Request  $request){
        $data = DB::table('categorie')->select()->get();

        return response()->json(['data_cat' => $data]);

    }

}
