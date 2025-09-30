<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventario</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">
    <script src="{{asset('js/autocompletar.js')}}" defer></script>
</head>

@php
    use App\Models\Producto;

        $venta = session('venta') ?? [];

        \Illuminate\Support\Facades\Session::flash('venta' , $venta);

@endphp

<body>
<x-header></x-header>

<main>


    <section id="productosContainer">


        <form id="confirmation_form" action="{{route('ventas.confirmar')}}" method="post">

            <h2>Confirmar la venta</h2>

            @csrf

            <div class="resumen">
                {{--
                Esta es la plantilla del producto

                     <div class="row">
                               <div class="numbers">
                                   <span class="cantidad">100</span>
                                   <span class="x_mark">x</span>
                                   <span class="price">
                                   <span>200</span>
                                   <span class="pesos"> cup</span>
                               </span>
                               </div>
                               <div class="prod_name">
                                   Producto ejemplo
                               </div>
                       </div>--}}
                <div class="row">
                    <div class="numbers">
                        <span class="cantidad">{{10 }}</span>
                        <span class="x_mark">x</span>
                        <span class="price">
                        <span>{{235}}</span>
                        <span class="pesos"> cup</span>
                    </span>
                    </div>

                    <div class="prod_name">
                        {{"Producto Dos"}}
                    </div>
                </div>
            </div>


            <hr>
            <div class="field " style="justify-content: center; gap: 0.5em">
                <label for="total">Total:</label>
                <span class="result">{{2548}} <span class="pesos"> cup</span> </span>
            </div>

        </form>


    </section>




    <div class="buttonsContainer">
        <button class="cancelButton" name="response" type="submit" form="confirmation_form" value="back">Atrás</button>
        <button class="submitButton" name="response" value="confirm" type="submit" form="confirmation_form">Siguiente
        </button>
    </div>


</main>

<footer></footer>
</body>
</html>

