<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Venta_temp;
use App\Models\VentaTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class venta_controller extends Controller
{
    //
    public function index(){



        return view('ventas.create');

    }
    public function create(){

        if(Inventario::all()->where('stock','>',0)->count() == 0)
        {
            //Redirigir a una página de errores
            return view('error', ['error' =>'No existen productos en el inventario.', 'action' => 'Agregarlos']);
        }

        return view('ventas.create',  [ 'user' => request()->user()->id]);

    }
    public function store(Request $request){

        //Autorizar

        //Validar la entrada de los campos
        $validated = $request->validate([
            'producto' => 'required|string|max:25',
            'cantidad' => 'required|numeric|min:1',
            'precio_venta' => 'required|numeric|min:1',
        ]);

//        $producto = DB::select('select * from producto where nombre = ?', [strtolower(trim($validated['producto']))]);

        //Verificar que el producto exista
        $producto = Producto::findOrFail($validated['producto']);


        if (!$producto){
            throw  ValidationException::withMessages(['producto' => 'El producto no existe en la base de datos']);
        }

        //Verificar que la cantidad a vender sea posible
        if ( $producto->stock() - $validated['cantidad'] < 0){

            if ($producto->stock() == 0)
            {
                throw ValidationException::withMessages(['cantidad' => "Ya no quedan unidades disponibles."]);

            }

            throw ValidationException::withMessages(['cantidad' => "Solo quedan ". $producto->stock() ." unidades disponibles."]);
        }


        //Creamos los datos de la venta para confirmarlos
        $venta = [
            'nombre' => $validated['producto'],
            'id_usuario' => $request->user()->id,
            'cantidad' => $validated['cantidad'],
            'precio_venta' => $validated['precio_venta'],
        ];

        session(['venta' => $venta]);

        //Redirigir a la confirmación
        return redirect()->route('venta.confirmacion')->with(['venta' => $venta]);


    }
    public function show(){}
    public function edit(){}
    public function update(){}
    public function destroy(){}

    public function confirmacion(){

        $venta = session('venta') ?? null;

        if (!$venta){
            return redirect()->route('venta.create');
        }
        session()->regenerate();

        return view('ventas.confirmar')->with('venta', $venta);
    }

    public function confirmar(Request $request){

        //Analizar la respuesta del usuario
        $response = $request->input('response');

        //Almacenar la info para la confirmación
        $venta = session('venta');

        if($venta == null)
            return redirect()->route('venta.create');

        if ($response == 'confirm')
        {
            //Lógica para ingresar la venta a la base de datos
              $newVenta = Venta_temp::create([
                    'id_producto' => $venta['nombre'],
                    'id_usuario' => $venta['id_usuario'],
                    'precio_venta' => $venta['precio_venta'],
                    'cantidad' => $venta['cantidad'],
                ]);

               Venta_temp::destroy($newVenta->id);

               Session::forget('venta');
        }

        if ($response == 'back')
        {
            return redirect()->route('venta.create');
        }

        //Realizar la inserción en la base de datos, incluyendo la fecha y hora, obviamente jsjsshhs
        Session::forget('venta');

        return redirect( route('inicio'));

    }
}
