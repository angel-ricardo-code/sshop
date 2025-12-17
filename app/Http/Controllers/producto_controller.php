<?php

namespace App\Http\Controllers;

use App\Models\Producto_temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class producto_controller extends Controller
{
    //
    public function index()
    {
    }

    public function create()
    {

        //Autorizar la operación. Pendiente
        return view('compras.index');
    }

    public function store(Request $request)
    {

        //Autorizar la operación. Pendiente


        $action = $request->input('action');


        if ($action == 'cancel') {
            return redirect()->route('inventario');
        }

        if ($action == 'add') {
            //Validar la entrada de los campos

            $validated = $request->validate([
                'productos.*.nombre' => 'required|string|min:3|max:25',
                'productos.*.cantidad' => 'required|numeric|min:1',
                'productos.*.precio_compra' => 'required|numeric|min:1',
                'productos.*.precio_venta' => 'required|numeric|gt:productos.*.precio_compra',
                'productos.*.categoria' => 'required|string|min:3|max:100',
            ]);


            //Tratar de crear la instancia, si existe un error, capturarlo y redirigir a la página de errores

            foreach ($validated['productos'] as $producto) {

                try {

                    Producto_temp::create([
                        'nombre' => $producto['nombre'],
                        'id_usuario' => Auth::id(),
                        'stock' => $producto['cantidad'],
                        'precio_compra' => $producto['precio_compra'],
                        'precio_venta' => $producto['precio_venta'],
                        'categoria' => $producto['categoria'],
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
            //Redirigir al inventario
            return redirect()->route('inventario')->with('messages', 'Productos agregados correctamente');

        }


    }

    public function show($id)
    {
    }

    public function edit(Request $request)
    {
        if (session('ids') == null)
        {
            return redirect()->back();
        }

        //Capturar la informaci'on de los prodcutos seleccionados
        $user = $request->user()->id;
        $pgArray = '{' . implode(',',  session('ids')) . '}';


        //Buscamos los productos
        $productos = DB::select("SELECT * FROM user_productos(?, ?::integer[] )  ", [ $user, $pgArray]);


        //Hacer return de la vista de edición
        return view('productos.editar')->with('productos', $productos);

    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

}
