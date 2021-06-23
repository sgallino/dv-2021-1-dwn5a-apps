<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Repositories\PeliculaRepositoryInterface;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    protected $repo;

    public function __construct(PeliculaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function all()
    {
//        $peliculas = $this->repo->all();
        $peliculas = Pelicula::all();

        // Retornamos un JSON.
        // Los JSONs se pueden retornar fácilmente usando el método response()->json()
        // Cualquier dato que le provean, automáticamente es codificado con json_encode.
        return response()->json([
            'data' => $peliculas
        ]);
    }

    public function create(Request $request)
    {
        $request->validate(Pelicula::$rules, Pelicula::$errorMessages);

        $pelicula = Pelicula::create($request->input());

        return response()->json([
            'code' => 0,
            'data' => $pelicula,
        ]);
    }
}
