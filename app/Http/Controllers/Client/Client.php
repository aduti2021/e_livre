<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class Client extends Controller
{
    //

    function Inscription(Request $request)
    {


        $validator = Validator::make($request->all(), $this->regles_inscription(), $this->message_inscription(), $this->attrInscription());

        if ($validator->passes()) {


            DB::table('users')->insertGetId([

                'nom' => request('nom'), 'email' => request('email'),
                'ville' => request('ville'),
                'tel' => request('tel'), 'sex' => request('sex'),
                'password' => Hash::make(request('password')),

            ]);


            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {


                return response()
                    ->json(array(
                        'success' => true
                    ));

            }

        } else {

            return response()->json(array('success' => false, 'errors' => $validator->getMessageBag()->toArray()));

        }

    }

    public function regles_inscription()
    {

        return [

            'nom' => 'required|min:5|max:90', 'sex' => 'required|min:1|max:10', 'ville' => 'required|min:3|max:75',
            'tel' => 'required|between:8,12', 'email' => 'required|email|min:5|max:155|unique:users,email', 'password' => 'required|min:6|max:100'

        ];

    }

    public function message_inscription()
    {

        return ['password.required' => 'le mot de passe est obligatoire', 'email.required' => 'L\'adresse Email est obligatoire.',

        ];

    }

    function attrInscription()
    {

        return ['nom' => 'Nom', 'post' => 'Poste', 'email' => 'Email', 'tel' => 'Téléphone', 'password' => 'Password'];
    }

    function Connexion(Request $request)
    {

        $validator = Validator::make($request->all(), ['username' => 'required|between:5,50', 'password' => 'required|between:5,100'], $this->message_inscription(), $this->attrInscription());

        if ($validator->passes()) {
            /* DB::table('users')->insertGetId([

                 'name' => 'Admin', 'email' => 'admin@reservation.ci' ,
                 'post' => 'Directeur' ,
                 'tel' => '0707070707' , 'sex' => '122546',
                 'password' => Hash::make('admin@2021'),

             ]);*/

            $connexion = array(
                'email' => request('username'),
                'password' => request('password')
            );

            if (Auth::attempt($connexion, true)) {

                return response()->json(array(
                    'success' => true,

                ));

            } else {

                return response()
                    ->json(array(
                        'invalid' => true,
                        'success' => false,
                    ));

            }

        } else {

            return response()
                ->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()
                        ->toArray()

                ));

        }
    }

    public function regles_autorisation()
    {


        return [

            'nom' => 'required|min:5|max:90', 'sex' => 'required|min:1|max:10', 'post' => 'required|min:3|max:75', 'email' => 'required|email|between:5,255|',
            'tel' => 'required|between:8,12', 'raison_abs' => 'required|max:995|min:10|', 'date_debut' => 'required', 'date_fin' => 'required'

        ];

    }

    function attr()
    {

        return ['nom' => 'Nom', 'post' => 'Poste', 'email' => 'Email', 'tel' => 'Téléphone', 'raison_abs' => 'Raison absence', 'compensation' => 'Compensation'];
    }
}
