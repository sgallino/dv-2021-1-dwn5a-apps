<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Los métodos de los controllers siempre deben RETORNAR (no echoear ni nada) la respuesta.
        // Típicamente, va a ser una vista, una respuesta o un redireccionamiento.
        // En el caso de una vista, las podemos agregar con la función view($vista).
        // Donde $vista es el nombre (sin extensión) del archivo de la vista en la carpeta de vistas:
        // resources/views
        return view('home');
    }
}
