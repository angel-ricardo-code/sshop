<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventario extends Model
{
    //
    protected $table = 'inventario';

    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function display($user_id)
    {

       $productos = Producto::hydrate ( DB::select("SELECT p.id,  p.nombre, i.stock, p.precio_compra,p.precio_venta, p.descripcion, p.categoria
                            FROM producto p, inventario i
                            WHERE i.id_producto = p.id AND i.id_usuario = $user_id
                            ORDER BY p.nombre;"));

       return $productos;

    }
}
