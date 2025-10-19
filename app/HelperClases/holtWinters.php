<?php

namespace App\HelperClases;

use Illuminate\Support\Facades\DB;

class holtWinters



{


    //Propiedades
    private $userID;
    private $productID;


    //Inicializaciones
    private $years = [];
    private $seasonal_factor = [];

    private $nivel_inicial = [];

    private $tendencia_inicial = [];







    /*
     *      Se encarga de realizar las inicializaciones para los datos proporcionados de
     *   año, producto y usuario. Esta será una clase estática para calcular.
     *
     *
     *
     *
     * */

    public function __construct($initialYear , $userID , $productID){

        $this->userID = $userID;
        $this->productID = $productID;


        $years = now()->year - $initialYear;

        $sum = 0;


        for ($i = 0; $i <= $years ; $i++) {

            $this->years[] = $initialYear + $sum;
            $sum ++;

        }


        $this->nivel_inicial = $this->get_nivelInicial($userID , $productID);
        $this->tendencia_inicial = $this->get_tendenciaInicial($userID , $productID);
        $this->seasonal_factor = $this->get_factoresE($initialYear + 1);


        //   $this->ventas_iniciales = DB::select("SELECT * FROM holt_level($userID, 20, 2023)");
    }






    //Inicializaciones, métodos
    public function get_nivelInicial($userID, $productID){

        $year = $this->years[0];


        $results = DB::select("SELECT total_vendido FROM holt_level($userID, $productID,$year )");


        $sum= 0;

        foreach ( $results as $month) {

            $sum += $month->total_vendido;
        }

        return  $sum/12;

    }

    public function get_tendenciaInicial($userID, $productID){

        $results = self::getData($userID, $productID);

        $iA = 0;
        $iB = 1;

        $sum = 0;

        for ($i = 0; $i < 11; $i++) {
            $sum += $results[$iB]->total_vendido - $results[$iA]->total_vendido;
            $iB++;
            $iA++;
        }

        return $sum/11;

    }



    //Retorna el conjunto de datos para cada producto en un anho, las ventas mensuales
    static function getData($user, $product, $year = 2023){
        return DB::select("SELECT * FROM holt_level($user, $product, $year)");
    }





    //Métodos auxiliares para calcular los valores
    public function calcular_nivel($a = 0.3, $venta, $nivel_anterior, $tendencia_anterior, $temp_mes){

        return round(($a * ($venta / $temp_mes) + (1 - $a) * ($nivel_anterior + $tendencia_anterior)),2);

    }

    public function calcular_tendencia($b = 0.1, $nivel_actual, $nivel_anterior, $tendencia_anterior){

        return round(( $b*($nivel_actual - $nivel_anterior) + (1 - $b)*$tendencia_anterior),2);

    }

    public function calcular_temp( $r ,$venta, $nivel_actual, $factorTemp){

        return round(($r*($venta/$nivel_actual) + (1 - $r)*$factorTemp),2);

    }


    public function get_factoresE( $year = 2023){


        $data = self::getData($this->userID , $this->productID, $year);

        $factores = array();
        $j = 0;

        for ($i = 1; $i < 12; $i++) {

        $factores[$j] = $data[$j]->total_vendido/( $this->nivel_inicial + ( 1 - $i)*$this->tendencia_inicial);
        $j++;

        }

        return $factores;
    }
    public function pronosticar($meses, $initial_year)
    {

        //Inicializamos los valores


        //Calculamos los parametros para cada i, hasta el numero de meses posteriores a la fecha actual, o ultima

        //Calculamos el pronostico
    }

}
