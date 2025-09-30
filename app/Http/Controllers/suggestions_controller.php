<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class suggestions_controller extends Controller
{
    //

    /*
     *  TODO
     *     Necesitamos el promedio de ventas del primer año, por meses para obtener el nivel inicial l_12
     *    Para calcular la tendencia inicial, debemos calcular la diferencia entre el promedio mensual del primero al segundo año
     *
     *    O sea, que tenemos datos de tres años, los datos del primero serán los iniciales, L_12, y queremos calcular all
     *      hasta L_36, o sea de t= 12 hasta t = 36
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */


    //Mostrar la vista de las sugerencias
    public function index( Request $request )
    {
        /*TODO para calcular el promedio mensual para los tres años*/
        /*SELECT id, COALESCE(SUM(v.cantidad/12), 0), EXTRACT(YEAR from v.created_at) FROM calendar
        JOIN user_ventas(1) v
        ON calendar.id = EXTRACT(MONTH from v.created_at)
        GROUP BY EXTRACT(MONTH from v.created_at), calendar.id, EXTRACT(YEAR from v.created_at)
        ORDER BY EXTRACT(YEAR from v.created_at), calendar.id;*/


        /*
         * Modificar el usuario, el id_producto y el año
         * Obtiene las ventas totales de cada mes
         *
         * SELECT id as month, COALESCE(SUM(v.cantidad), 0) as total_vendido, EXTRACT(YEAR from v.created_at) as year FROM calendar
              LEFT JOIN user_ventas(1) v
             ON calendar.id = EXTRACT(MONTH from v.created_at) AND id_producto = 4 AND  EXTRACT(YEAR from v.created_at) = 2024
           GROUP BY EXTRACT(MONTH from v.created_at), calendar.id, EXTRACT(YEAR from v.created_at)
           ORDER BY calendar.id,EXTRACT(YEAR from v.created_at);
        */
        $user_id = $request->user()->id;

        dd( DB::select("SELECT * FROM "));

    }
}
