<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Agregamos una variable de sesión con un mensaje.
            Session::flash('message', 'Se requiere iniciar sesión para ver este contenido. :)');
            Session::flash('message_type', 'info');
            return route('auth.login-form');
        }
    }
}
