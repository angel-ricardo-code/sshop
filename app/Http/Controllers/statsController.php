<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class statsController extends Controller
{
    //

    public function index(Request $request)
    {


        //Hacer la queries para cada section de la página

        $user = $request->user()->id;

        session('userId', $user);


        //Productos más vendidos
        $bestSellers = DB::select("

        WITH no_ventas AS
        (

        SELECT id_producto, SUM(cantidad)  FROM user_ventas($user) GROUP BY id_producto

        )

        SELECT p.nombre, no_ventas.sum
        FROM producto p, no_ventas
        WHERE p.id = no_ventas.id_producto
        ORDER BY sum DESC LIMIT 5"
        );

        //Productos con mejores gannacias, redondeadads

        $bestProfit = DB::select("

        WITH total_venta AS( SELECT id_producto, SUM(precio_venta*cantidad) FROM user_ventas($user) GROUP BY id_producto),
             total_compra AS (SELECT id_producto, SUM(precio_compra*cantidad) FROM user_compras($user) GROUP BY id_producto)


        SELECT p.nombre,
        ROUND(total_venta.sum - total_compra.sum) AS ganancia

        FROM producto p, total_venta, total_compra
        WHERE p.id = total_venta.id_producto AND p.id = total_compra.id_producto
        ORDER BY ganancia DESC LIMIT 5

        ");

        //Productos agotados

        $outStock = DB::select("

        WITH out AS  (SELECT id_producto FROM user_inventario($user) WHERE stock = 0)

        SELECT nombre FROM producto JOIN out ON out.id_producto = producto.id

        ");

        //Productos a punto de agotarse (teniendo en cuenta las ventas semanales)

        /*$almostStock = DB::select("

          WITH ventas_semanales AS (
             SELECT id_producto, (SUM(cantidad)/4) AS cantidad_semanal FROM user_ventas($user) as v
             WHERE EXTRACT( YEAR FROM v.created_at) = EXTRACT(YEAR FROM CURRENT_DATE) AND EXTRACT(MONTH FROM v.created_at) = EXTRACT(MONTH FROM CURRENT_DATE)
             GROUP BY id_producto
            ),

            casi_agotados AS (
            SELECT inventario.id_producto, stock FROM user_inventario($user) as inventario, ventas_semanales
            WHERE inventario.id_producto = ventas_semanales.id_producto AND stock < cantidad_semanal*0.60 AND stock > 0
            )

            SELECT p.nombre, c.stock FROM producto p, casi_agotados c
            WHERE p.id = c.id_producto AND p.id_usuario = $user
            ORDER BY c.stock ASC;
        ");*/

        $almostStock = DB::select("

        WITH ventas_semanales AS (

        SELECT id_producto, AVG(cantidad) as prom_semanal, EXTRACT( WEEK FROM created_at ) as week, EXTRACT( YEAR FROM created_at ) as year
        FROM ventas
        GROUP BY id_producto, EXTRACT( YEAR FROM created_at ), EXTRACT( WEEK FROM created_at )
        ORDER BY id_producto, year, week
        ),

        prom_semanal AS (

            SELECT id_producto, AVG(v.prom_semanal) FROM ventas_semanales v
            GROUP BY id_producto

        )



         , casi_agotados AS (
            SELECT DISTINCT(inventario.id_producto), stock FROM user_inventario($user) as inventario, prom_semanal p
            WHERE inventario.id_producto = p.id_producto AND stock < p.avg*0.60 AND inventario.stock > 0
            )

            SELECT p.nombre, c.stock FROM producto p, casi_agotados c
            WHERE p.id = c.id_producto AND p.id_usuario = $user
            ORDER BY c.stock ASC;
        ");

        return view('Stats.stats', [
            'bestSellers' => $bestSellers,
            'bestProfit' => $bestProfit,
            'outStock' => $outStock,
            'almostStock' => $almostStock
        ]);
    }

    public function show_all(Request $request, $stat)
    {


        $user = $request->user()->id;
        $results = [];
        $mssg = "";


        if ($stat == "producto-ventas") {
            $mssg = "Productos más vendidos.";
            $result = DB::select("
                WITH no_ventas AS
                (SELECT id_producto, SUM(cantidad)  FROM user_ventas($user) GROUP BY id_producto)

                SELECT p.nombre, no_ventas.sum as num
                FROM producto p, no_ventas
                WHERE p.id = no_ventas.id_producto
                ORDER BY num DESC"
            );
        } elseif ($stat == 'producto-ganancias') {
            $mssg = "Productos con más ganancias.";
            $result = DB::select("

        WITH total_venta AS( SELECT id_producto, SUM(precio_venta*cantidad) FROM user_ventas($user) GROUP BY id_producto),
             total_compra AS (SELECT id_producto, SUM(precio_compra*cantidad) FROM user_compras($user) GROUP BY id_producto)


        SELECT p.nombre,
        ROUND(total_venta.sum - total_compra.sum) AS num

        FROM producto p, total_venta, total_compra
        WHERE p.id = total_venta.id_producto AND p.id = total_compra.id_producto
        ORDER BY num DESC

        ");
        } elseif ($stat = 'producto-lowStock') {
            $mssg = "Productos casi agotados.";
            $result = DB::select("

          WITH ventas_semanales AS (
             SELECT id_producto, (SUM(cantidad)/4) AS cantidad_semanal FROM user_ventas($user) as v
             WHERE EXTRACT( YEAR FROM v.created_at) = EXTRACT(YEAR FROM CURRENT_DATE) AND EXTRACT(MONTH FROM v.created_at) = EXTRACT(MONTH FROM CURRENT_DATE)
             GROUP BY id_producto
            ),

            casi_agotados AS (
            SELECT inventario.id_producto, stock FROM user_inventario($user) as inventario, ventas_semanales
            WHERE inventario.id_producto = ventas_semanales.id_producto AND stock < cantidad_semanal*0.60 AND stock > 0
            )

            SELECT p.nombre, c.stock as num FROM producto p, casi_agotados c
            WHERE p.id = c.id_producto AND p.id_usuario = $user
            ORDER BY c.stock ASC;
        ");
        }

        return view("Stats.producto-detalles", ['result' => $result, 'header' => $mssg, 'stats' => $stat]);
    }

    public function goBack(Request $request)
    {
        return redirect('/estadisticas');
    }
}
