<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Les information météos d'une ville
 * ville=
 */
Route::post('/getmeteo','Meteo\Meteo@getVille');

/**
 * recuperer La liste des livres
 *
 */
Route::post('/tous_livres','Page\Accueil@index');


Route::post('/get_categorie','Page\Accueil@getCategorie');
Route::post('/get_liste_des_categorie','Page\Accueil@getListeDesCategories');


/**
 * ajouter un livre au panier
 *
 */

Route::post('/ajouter_panier','Livre\Panier@ajoutAuPanier');


/**
 * Recuperer la panier de l'user
 *
 */
Route::post('/get_panier','Livre\Panier@recupererPanier');

/**
 * Retirer un produiit du panier
 *
 */
Route::post('/retirer_panier','Livre\Panier@retirerAuPanier');



/**
 * L'user doit être authentifier pour accéder à ses routes
 *
 */
Route::middleware(['est_auth_user'])->group(function () {


    Route::post('/valider_commande','Livre\Commande@validerCommande');


    Route::get('/validation_commande', function (){

        return view('welcome')->with(['auth' => 1]);

    });


    Route::post('/deconnexion', function () {
        Auth::logout();
    });

});


Route::middleware(['non_auth_user'])->group(function () {



    Route::get('/connexion', function (){

        return view('welcome')->with(['auth' => 0]);

    });




    Route::post('/connexion', 'Client\Client@Connexion');



    Route::post('/inscription', 'Client\Client@Inscription');


    Route::get('/inscription', function (){
        return view('welcome')->with(['auth' => 0]);

    });


});


Route::get('/{any}', function () {
    return view('welcome')->with(['auth' => Auth::check() ? 1 : 0]);
})->where('any', '.*');

