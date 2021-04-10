<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Accueil extends Controller
{
    //
    public  function Index(Request  $request){
        $data = DB::table('livres')->select()->inRandomOrder('1234')
            ->paginate(4);

        return response()->json(['data' => $data]);

    }
}
