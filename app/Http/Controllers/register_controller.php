<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class register_controller extends Controller
{


    public function index()
    {
            $message = 'Inicia sesión';
            $action = '/login';
            return view('registration.registration', ['message' => $message, 'action' => $action]);
    }

    public function login(Request $request){

        //Validar la entrada de los datos

        $validated = $request->validate(
            [
            'username' => ['required', 'string', 'max:255', 'email'],
            'passw' => ['required', Password::min(8)]
            ],
            [
                'username.string' => 'El nombre debe ser un texto',
                'username.email' => 'Debes ingresar un email válido',
                'username.required' => 'Debes ingresar tu correo electronico',
                'passw.required' => 'La constraseña es obligatoria',
                'passw.min' => 'La contraseña debe tener al menos 8 caracteres de largo',
            ]);

        //Tratamos de hacer login, si falla, retornamos el error a la vista
        if(!Auth::attempt([
            'email' => $validated['username'],
            'password' => $validated['passw'],
        ]))
            throw ValidationException::withMessages(['passw' => 'The provided credentials are incorrect.']);

        //Regenerar los datos de la sesión por temas de seguridad
        request()->session()->regenerate();

        //Redirigir
        return redirect('/inicio');
    }

    public function logout(){

        Auth::logout();
        return redirect('/bienvenido
        ');
    }

    public function create(){
        $message = 'Crea una nueva cuenta';
        $action = '/nuevo-usuario';
        return view('registration.registration', ['message' => $message, 'repeat'=> true, 'action' => $action]);
    }

    public function store(Request $request){

        //Validar la entrada de los datos

        $validated = request()->validate([
            'name' => 'required|string|max:30',
            'username' => 'email|string|required|max:255|unique:users,email',
            'repeat_username' => 'email|same:username',
            'passw' => ['required', Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
        ],
        [
            'name.required' => 'Debes ingresar tu nombre',
            'name.string' => 'El nombre debe ser un texto',
            'username.string' => 'El nombre debe ser un texto',
            'username.email' => 'Debes ingresar un email válido',
            'username.unique' => 'Este nombre de usuario ya existe en nuestro sistema, prueba' . "<a href='/login'> iniciar sesión</a>" ,
            'username.required' => 'Debes ingresar tu correo electronico',
            'repeat_username.same' => 'Deben coincidir las dos direcciones de correo proporcionadas',
            'passw.required' => 'La constraseña es obligatoria',
            'passw.min' => 'La contraseña debe tener al menos 8 caracteres de largo',
            'passw.letters' => 'La contraseña debe contener al menos una letra',
            'passw.mixedCase' => 'La contraseña debe contener letras mayúsuclas y minúsculas',
            'passw.symbols' => 'La contraseña debe contener un caracter especial, al menos',
            'passw.numbers' => 'La contraseña debe incluir un número, al menos'
        ]);

        //Crear el usuario
        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['repeat_username'],
            'password' => Hash::make($validated['passw']),
        ]);



        //Iniciar su sesión
        Auth::login($newUser, true);

        //Redirigir a su página principal
        return redirect('/inicio');
    }
}
