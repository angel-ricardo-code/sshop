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
            dd("Editando productos");
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


}
