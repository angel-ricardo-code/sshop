<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class suggestions_controller extends Controller
{


    //Mostrar la vista de las sugerencias
    public function index(Request $request)
    {

        $userID = $request->user()->id;

        //Calcularemos la tendencia para un mes, un producto, a partir de datos de tres años anteriores

        //Obtener los resultados del primer año

        $res = DB::select("SELECT * FROM holt_level($userID, 38, 2025)");

        dd($userID, $res);

    }
}
