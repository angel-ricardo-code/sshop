<?php

namespace App\Http\Controllers;

use App\HelperClases\holtWinters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class suggestions_controller extends Controller
{


    public function getSeasonalFactor($i){

        //Necesitamos el valor del nivel inicial


}

    //Mostrar la vista de las sugerencias
    public function index(Request $request)
    {

        $userID = $request->user()->id;
        $productoID = 20;

        //Calcularemos la tendencia para un mes, un producto, a partir de datos de tres años anteriores

        //Obtener los resultados del primer año para calcular el nivel inicial, luego a partir de ahi se calculan recursivamente
        //Los valores del nivel para cada mes de ventas, teniendo c

        $holt = new holtWinters(2023, $userID, $productoID);

        dd($holt, $holt::getData($userID, $productoID));
//        $res = $holt->get_nivelInicial($userID, $productoID);

        $string = "";

        foreach ($res as $level) {

         $string .= " " .    $level->total_vendido;

        }

        dd($userID, $res,  $string);

    }
}
