<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_temp extends Model
{
    use HasFactory;


    //
    protected $table = 'producto_temp';

    protected $guarded = [];



    public function inventario(){

        return $this->hasOne(Inventario::class, 'id_producto', 'id');
    }

    public function stock(){
        return $this->inventario->stock;
    }

}
