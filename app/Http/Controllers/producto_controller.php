<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Producto_temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        if (session('ids') == null  ) {
            return redirect()->back();
        }

        //Capturar la informaci'on de los prodcutos seleccionados
        $user = $request->user()->id;
        $pgArray = '{' . implode(',', session('ids')) . '}';


        //Buscamos los productos
        $productos = DB::select("SELECT * FROM user_productos(?, ?::integer[] )  ", [$user, $pgArray]);


        //Hacer return de la vista de edición
        session(['productos' => $productos]);
        return view('productos.editar');

    }

    public function update(Request $request)
    {


        if ($request['action'] == 'cancel')
        {
            session()->forget('productos');
            session()->forget('ids');
            return redirect()->route('inventario');
        }




        $productos = session('productos');  //Obtenemos los modelos de los productos que están en la session
        $validated = [];


        //Debemos validar la entrada de los datos nuevos en los campos.
        try {
            $validated = $request->validate([
                'productos.*.nombre' => 'required|string|min:3|max:50',
                'productos.*.cantidad' => 'required|numeric|min:0',
                'productos.*.precio_compra' => 'required|numeric|min:1',
                'productos.*.precio_venta' => 'required|numeric|min:1|gt:productos.*.precio_compra',
                'productos.*.categoria' => 'required|string|min:3|max:100',
            ],[
                'productos.*.nombre.required' => 'El nombre para todos los productos es requerido',
                'productos.*.nombre.min' => 'El nombre debe tener al menos 3 caracteres para todos los productos',
                'productos.*.nombre.max' => 'El nombre debe tener maximo 50 caracteres para todos los productos',
                'productos.*.cantidad.required' => 'La cantidades, para todos los productos, es requerida',
                'productos.*.cantidad.min' => 'La cantidad mínima,para todos los productos, es 0',
                'productos.*.precio_compra.required' => 'El precio para todos los productos es requerido',
                'productos.*.precio_compra.min' => 'El precio mínimo es 0, para todos los productos',
                'productos.*.precio_venta.required' => 'El precio de venta es requerido, para todos los productos',
                'productos.*.precio_venta.gt' => 'El precio de venta tiene que ser mayor que el precio de compra,para todos los productos',
            ]);

        }
        catch (\Exception $e) {
            return view('productos.editar')->withErrors(['errors' => $e->getMessage()]);
        }


        //Tratamos de hacer update a los registros en la base de datos
        $i = 0;

        DB::beginTransaction();


        try {

            foreach ( $productos as $producto) {


                $id = $producto->id_producto;

                Producto::find($id)->update([
//                   'nombre' => $validated['productos'][$i]['nombre'],
                    'precio_compra' => $validated['productos'][$i]['precio_compra'],
                    'precio_venta' => $validated['productos'][$i]['precio_venta'],
                    'categoria' => $validated['productos'][$i]['categoria'],
                ]);

                $cantidad = $validated['productos'][$i]['cantidad'];

                DB::statement("UPDATE inventario SET stock = :cantidad WHERE id_producto = :id;", [  'cantidad' => $cantidad,'id' => $id]);

            }

            DB::commit();

        }



    catch (\Exception $e) {
        DB::rollback();
        return view(['error' => $e->getMessage(), 'action' => 'POST']);
    }

    return redirect()->route('inventario')->with('messages','Productos editados correctamente.');
        //Redirigir a una vista de confirmación de actualización, con un cartel que incluya la alerta sobre hacer un reconteo...

    }

    public function destroy($id)
    {
    }

}
