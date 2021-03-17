<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    public function index()
    {
        return view('peliculas.index');
    }

    public function nuevaForm()
    {
        return view('peliculas.nueva');
    }
}
