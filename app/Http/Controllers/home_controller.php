<?php

namespace App\Http\Controllers;

use http\Client\Request;
use Illuminate\Support\Facades\DB;


function str_from_to($string, $start, $end)
{

    $string_out = '';

    for ($i = $start; $i <= $end; $i++) {
        $string_out .= $string[$i];
    }

    return $string_out;

}

class home_controller extends Controller
{


    //
    public function index()
    {


        $user = request()->user()->id;


        $grettings = [
            '¡Hola otra vez!',
            '¡Bienvenido de nuevo!',
            '¡Hola, nuevamente!',
            '¡Saludos, bienvenido!',
            '¡Me alegra verte por aquí!'
        ];

        //Mostrar la información de la venta del día
        $dailyInfo = DB::select(" SELECT COUNT(*)
                                        FROM user_ventas($user)
                                          WHERE  EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)
                                         AND   EXTRACT(day FROM created_at) = EXTRACT(DAY FROM CURRENT_DATE)
                                         AND   EXTRACT(month FROM created_at) = EXTRACT(month FROM CURRENT_DATE)");

        //Total de ventas
        $total_vendido = DB::select(" SELECT SUM(monto_venta) as total_vendido
                                        FROM user_ventas($user)
                                          WHERE  EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)
                                         AND   EXTRACT(day FROM created_at) = EXTRACT(DAY FROM CURRENT_DATE)
                                         AND   EXTRACT(month FROM created_at) = EXTRACT(month FROM CURRENT_DATE)");

        //Cash vendido


        //Ganancia
        $ganancia = DB::select("

                WITH venta_diaria AS
                 (
                    SELECT id_producto, SUM(cantidad) AS total_items, SUM(monto_venta) AS total_vendido
                     FROM user_ventas($user)
                      WHERE  EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)
                      AND   EXTRACT(day FROM created_at) = EXTRACT(DAY FROM CURRENT_DATE)
                      AND   EXTRACT(month FROM created_at) = EXTRACT(month FROM CURRENT_DATE)
                      GROUP BY id_producto
                 )

                     SELECT SUM(v.total_vendido - v.total_items*p.precio_compra)
                     FROM venta_diaria AS v, producto p
                     WHERE v.id_producto = p.id;
         ");

        //Las últimas 5 operaciones
        $operaciones = DB::select("SELECT  v.id_producto, p.nombre, v.created_at
                                    FROM user_ventas($user) v, user_productos($user) p
                                    WHERE v.id_producto = p.id_producto
                                    ORDER BY v.created_at DESC LIMIT 5");


//        dd($operaciones, $dailyInfo, $total_vendido);

        return view('inicio', [
            'greeting' => $grettings[random_int(0, count($grettings) - 1)],
            'operaciones' => $operaciones,
            'count' => $dailyInfo[0]->count,
            'total_vendido' => $total_vendido[0]->total_vendido ?? 0,
            'ganancia' => $ganancia[0]->sum ?? 0]);
    }

    public function quickAccess()
    {

        //Listar las 5 últimas operaciones y retornarlas a la vista

        dump(request()->all());
    }
}
