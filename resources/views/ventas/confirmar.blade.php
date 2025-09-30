<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventario</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">
    <script src="{{asset('js/autocompletar.js')}}" defer></script>
    <script src="{{asset('js/calcular-vuelto.js')}}" defer></script>
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
                        <span class="cantidad">{{$venta['cantidad']}}</span>
                        <span class="x_mark">x</span>
                        <span class="price">
                        <span>{{$venta['precio_venta']}}</span>
                        <span class="pesos"> cup</span>
                    </span>
                    </div>

                    <div class="prod_name">
                        {{Producto::findOrFail($venta['nombre'])->nombre}}
                    </div>
                </div>
            </div>


            <hr>
            <div class="field " style="justify-content: center; gap: 0.5em">
                <label for="total">Total:</label>
                <span class="result">{{$venta['cantidad']*$venta['precio_venta']}} <span
                        class="pesos"> cup</span> </span>
            </div>

        </form>


    </section>

    <div class="exchange">
        <div class="heading">
            <span class="ico">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#6e4c3e"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-exchange"
                >
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M7 10h14l-4 -4"/>
  <path d="M17 14h-14l4 4"/>
</svg>

            </span>
            <span>Vuelto</span>
        </div>
        <hr>
        <div class="numbers">
            <input class="pago" type="number" name="cash" id="cash_input" placeholder="Pago">
            <span> - {{$venta['cantidad']*$venta['precio_venta']}} =</span>
            <input id="full_price" type="number" class="fullprice"
                   value="{{ $venta['cantidad']*$venta['precio_venta']}}">
            <input class="vuelto" type="number" name="result" id="result_input">
            <span class="pesos">cup</span>
        </div>

        <div class="alert hide" id="alert">
            <span class="ico">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="red"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle"
                >
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
  <path d="M12 8v4"/>
  <path d="M12 16h.01"/>
</svg>
            </span>
         <span> ¡falta dinero!</span>
        </div>
    </div>

    <div class="buttonsContainer">
        <button class="cancelButton" name="response" type="submit" form="confirmation_form" value="back">Atrás</button>
        <button class="submitButton" name="response" value="confirm" type="submit" form="confirmation_form">Siguiente
        </button>
    </div>


</main>

<footer></footer>
</body>
</html>

