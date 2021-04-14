<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Models\Pelicula;
use App\Models\Genero;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    public function index()
    {
        // Vamos a obtener todas las películas de la base a través de Eloquent.
//        $peliculas = Pelicula::all();
        // Cambiamos ahora a pedir que traiga todos los registros, pero asociados a sus
        // correspondientes relaciones.
        // Noten que no usamos "all()" acá, sino que usamos "get()".
        $peliculas = Pelicula::with(['pais', 'generos'])->get();

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
        $paises = Pais::all();
        $generos = Genero::all();

        return view('peliculas.nueva', compact('paises', 'generos'));
    }

    // Request es una clase que Laravel llena con todos los datos referentes a la petición del cliente.
    // Esto incluye: Parámetros por GET (query string), datos por POST, archivos, etc.
    public function crear(Request $request)
    {
        // all() retorna todos los datos recibidos del form por request.
//        dd($request->all());
        // El método validate de Request recibe las reglas de validación.
        // Si pasa, el método del controller sigue como si nada.
        // Si falla, automágicamente Laravel corta este método del controller, guarda los datos del
        // form y los mensajes de error en la sesión, y nos redirecciona a la página de la que venimos.
        // Nota: Esa página va a tener muy mano y convenientemente esa data para usar.
        // Nota 2: Si la petición fuera una llamada de Ajax, Laravel asume que quiere un JSON como
        // respuesta, así que genera un JSON con los errores, en vez de lo anterior.

        // Como segundo parámetro, pueden opcionalmente pasarle los mensajes de error personalizados
        // para cada validación.
        // También es un array. Para indicar a qué error corresponde cada mensaje, podemos usar la
        // notación de ".". Por ejemplo:
        // 'titulo.required' => 'El titulo es obligatorio'
        $request->validate(Pelicula::$rules, Pelicula::$errorMessages);

        // Creamos la película, y obtenemos la instancia creada.
        $pelicula = Pelicula::create($request->only(['titulo', 'sinopsis', 'duracion', 'fecha_estreno', 'precio', 'pais_id']));
//        Pelicula::create($request->all());

        // Le agregamos los géneros, usando el práctico método "attach" de la relación (noten que
        // accedemos a generos como método, no propiedad).
        // Este método, como indica la documentación, recibe un array con las FKs que queremos
        // insertar en la tabla pivot.
        $pelicula->generos()->attach($request->input('genero_id'));

        // Redireccionamos al usuario a la ruta 'peliculas.index'.
        return redirect()
            ->route('peliculas.index')
            // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
            ->with('message', 'La película se creó exitosamente.')
            ->with('message_type', 'success');
    }

    public function editarForm(Pelicula $pelicula)
    {
        $paises = Pais::all();
        $generos = Genero::all();

        return view('peliculas.editar', compact('pelicula', 'paises', 'generos'));
    }

    public function editar(Request $request, Pelicula $pelicula)
    {
        $request->validate(Pelicula::$rules, Pelicula::$errorMessages);

        $pelicula->update($request->only(['titulo', 'fecha_estreno', 'sinopsis', 'precio', 'duracion', 'pais_id']));

        // Para actualizar los géneros, usamos el práctico método "sync" de la relación (noten que
        // accedemos a generos como método, no propiedad).
        // Este método, se encarga de sincronizar los registros de la tabla pivot para esta película
        // de manera que solo queden los que están en el array que le paso.
        $pelicula->generos()->sync($request->input('genero_id'));

        return redirect()
            ->route('peliculas.index')
            ->with('message', 'La película fue editada con éxito.');
    }

    public function eliminar(Pelicula $pelicula)
    {
        // Quitamos las relaciones de la tabla pivot.
        $pelicula->generos()->detach();

        // El método delete() elimina el registro del modelo que lo invoca.
        $pelicula->delete();

        return redirect()->route('peliculas.index')
            // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
            ->with('message', 'La película se eliminó exitosamente.')
            ->with('message_type', 'success');
    }
}
