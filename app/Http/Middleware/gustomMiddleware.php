<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class gustomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Si no está autenticado, redirigimos a la página de bienvenida.
        if (!$request->user()) {

            var_dump($request->user());

        return redirect('/bienvenido');
    }

        return $next($request);
    }
}
