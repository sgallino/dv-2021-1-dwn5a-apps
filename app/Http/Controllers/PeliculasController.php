<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    public function index()
    {
        // Vamos a obtener todas las películas de la base a través de Eloquent.
        $peliculas = Pelicula::all();

//        return view('peliculas.index', [
//            'peliculas' => $peliculas
//        ]);

        return view('peliculas.index', compact('peliculas'));
    }

    // Cualquier parámetro que esté indicado en la ruta Laravel lo provee como argumento del método.
    public function ver(Pelicula $pelicula)
    {
        // find() busca un registro por su PK.
        // findOrFail() hace lo mismo, pero si el registro no existe, lanza un 404.
//        $pelicula = Pelicula::findOrFail($id);

        return view('peliculas.ver', compact('pelicula'));
    }

    public function nuevaForm()
    {
        return view('peliculas.nueva');
    }

    // Request es una clase que Laravel llena con todos los datos referentes a la petición del cliente.
    // Esto incluye: Parámetros por GET (query string), datos por POST, archivos, etc.
    public function crear(Request $request)
    {
        // all() retorna todos los datos recibidos del form por request.
//        dd($request->all());
        // TODO: Validar...
        // El método validate de Request recibe las reglas de validación.
        // Si pasa, el método del controller sigue como si nada.
        // Si falla, automágicamente Laravel corta este método del controller, guarda los datos del
        // form y los mensajes de error en la sesión, y nos redirecciona a la página de la que venimos.
        // Nota: Esa página va a tener muy mano y convenientemente esa data para usar.
        // Nota 2: Si la petición fuera una llamada de Ajax, Laravel asume que quiere un JSON como
        // respuesta, así que genera un JSON con los errores, en vez de lo anterior.
        $request->validate([
            'titulo' => 'required|min:2',
            'precio' => 'required|numeric',
            'fecha_estreno' => 'required|date'
        ]);

        Pelicula::create($request->only(['titulo', 'sinopsis', 'duracion', 'fecha_estreno', 'precio']));
//        Pelicula::create($request->all());

        // Redireccionamos al usuario a la ruta 'peliculas.index'.
        return redirect()->route('peliculas.index');
    }
}
