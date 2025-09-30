<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inicia Sesión</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/registration.css')}}">
</head>
<body>

<main>

    <h1 class="mainHeading">{{$message}}.</h1>

    <form action="{{$action ?? '/login'}}" method="post" class="container loginContainer">

        @csrf

        @if(isset($repeat))
            <div class="field">
                <label for="name_in">Nombre:</label>
                <input type="text" name="name" id="name_in">
            </div>
            <hr>
        @endif



        <div class="field">
            <label for="username_in">Usuario:</label>
            <input type="email" name="username" id="username_in">
        </div>

        @if(isset($repeat))
            <div class="field repeat">
                <label  for="repeat_username_in"> Repítelo:</label>
                <input type="email" name="repeat_username" id="repeat_username_in">
            </div>
        @endif

        <div class="field">
            <label for="passw_in">Contraseña:</label>
            <input type="password" name="passw" id="passw_in">
        </div>
        <hr>

        @if( $errors->any())

                @foreach( $errors->all() as $error)
                <div class="errors">
                    <div style="font-size: 0.9em; display: flex; align-items: center; gap: 0.5em">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="42"
                            height="42"
                            opacity="0.8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="red"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>


                        {{$error}}
                    </div>
                </div>
            @endforeach

        @endif

        <div class="buttonsContainer">
            <button class="cancelButton"><a href="/bienvenido">Cancelar</a></button>
            <button class="submitButton" type="submit">Aceptar</button>
        </div>
    </form>

    <div class="logo">
        <img src="{{asset('icos/logo.png')}}" alt="" srcset="">
    </div>

</main>

</body>
</html>
