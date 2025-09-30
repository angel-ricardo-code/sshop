<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table = 'producto';

    protected $guarded = [];

    public function inventario(){

        return $this->hasOne(Inventario::class, 'id_producto', 'id');
    }

    public function stock(){
        return $this->inventario->stock;
    }

}
