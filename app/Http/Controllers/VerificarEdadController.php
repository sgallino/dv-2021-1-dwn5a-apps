<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerificarEdadController extends Controller
{
    public function verificarForm()
    {
        return view('peliculas.verificar-edad');
    }

    /**
     * Setea la variable de sesión que indica que el usuario confirmó ser mayor de 18 años.
     */
    public function verificar()
    {
        Session::put('mayor_de_18_verificado', true);

        $pelicula_id = Session::get('pelicula_que_quiere_ver');
        Session::remove('pelicula_que_quiere_ver');

        return redirect()
            ->route('peliculas.ver', ['pelicula' => $pelicula_id])
            ->with('message', 'Confirmaste que sos mayor a 18, y creemos plenamente en tu palabra.');
    }
}
