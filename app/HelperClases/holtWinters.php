<?php

namespace App\HelperClases;

use Illuminate\Support\Facades\DB;

class holtWinters
{
    //Necesitamos los datos de las ventas menusales
    private $ventas_iniciales = [];
    private $seasonal_factor = [];

    public function __construct(){

        $this->ventas_iniciales = DB::select("SELECT * FROM holt_level($userID, 20, 2023)");
    }

    public function getNivel_iniciales(){

        return 0;
    }

}
