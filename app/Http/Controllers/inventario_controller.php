<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class inventario_controller extends Controller
{
    //
    public function index(){

        $user = auth()->user()->id;

        $productos = DB::select(" SELECT * FROM user_inventario($user)");

        return view('inventario', ['user' => $user, 'productos' => $productos]);
    }

    public function manage(Request $request){

        $selected = $request->input('selected');
        $action = $request->input('action');

        if(empty($selected)){
            return redirect()->route('inventario')->with('messages','Debes seleccionar un producto.');
        }

        if($action == 'delete'){
            //redirigir a una vista de confirmacion de eliminacion
            return redirect()->route('eliminar.confirmacion')->with('ids',$selected);
        }

        if($action == 'edit'){

//            session('ids', $selected);
            //dd('eiasdfa');
            return redirect()->route('producto.editar', ['ids' => $selected])->with('ids',$selected);
        }


    }

    public function eliminar(Request $request){

        $ids = $request->input('selected') ?? null;
        $response = $request->input('response');


        if (!$ids)
            return redirect()->route('inventario')->with('ids',$ids);


        if ($response == 'delete') {
            Producto::whereIn('id',$ids)->delete();
            return redirect()->route('inventario')->with('messages', 'Productos eliminados correctamente');
        }

        if ($response == 'cancel') {
            return redirect()->route('inventario');
        }

    }

    public function edit(Request $request){

        $id_user = $request->user()->id;

        $id_productos = [];

        foreach (session('ids') as $id){
            $id_productos[] = intval($id);
        }



        //Recuperar la info de los productos,
        $products = DB::select("SELECT * FROM user_productos($id_user , $id_productos )");

        dd($products);


        //Retornar la vista, con los productos que hemos recuperado desde manage

        return view('Productos.editar')->with('ids',$request->input('selected'));

    }


    public function productos_update(Request $request){

    }


}
