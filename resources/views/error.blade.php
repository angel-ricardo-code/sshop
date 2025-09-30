<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/error.css')}}">
    <title>Error:</title>
</head>
<body>
<main>
    <div class="container">
        <span class="alert-icon">
            <img class="ico" src="{{asset('icos/alert-circle.svg')}}" alt="alert circle">
        </span>
        <h1 class="mainHeading messages">{{$error}}</h1>
    </div>

    <div class="buttonContainer">
       <button class="cancelButton"> <a href="/inicio">Inicio</a></button>
        <button class="submitButton"><a href="/agregar-productos">{{$action}}</a></button>
    </div>
</main>
<footer></footer>
</body>
</html>
