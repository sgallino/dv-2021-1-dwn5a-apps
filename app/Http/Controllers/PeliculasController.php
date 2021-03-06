<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Models\Pelicula;
use App\Models\Genero;
use App\Repositories\PeliculaRepositoryInterface;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PeliculasController extends Controller
{
    /** @var PeliculaRepositoryInterface Repositorio que administra las películas. */
    protected $repository;

    /**
     * PeliculasController constructor.
     * Le pedimos a Laravel que nos inyecte en el constructor la clase asociada a la interface
     * PeliculaRepositoryInterface.
     * Esa asociación la tenemos en AppServiceProvider.
     *
     * @param PeliculaRepositoryInterface $repository
     */
    public function __construct(PeliculaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // Para poder buscar, necesitamos traer la instacia de Request que tiene acceso a los
    // datos de la URL.
    public function index(Request $request)
    {
        $formParams = [];

        // Preguntamos si hay algún parámetro de búsqueda.
        // Para pedir datos que llegan por GET en el query string, tenemos el método "query".
        if($request->query('titulo')) {
            $formParams['titulo'] = $request->query('titulo');
        }

        $peliculas = $this->repository->all($formParams);

        return view('peliculas.index', compact('peliculas', 'formParams'));
    }

    // Cualquier parámetro que esté indicado en la ruta Laravel lo provee como argumento del método.
    public function ver($pelicula)
    {
        // find() busca un registro por su PK.
        // findOrFail() hace lo mismo, pero si el registro no existe, lanza un 404.
        $pelicula = $this->repository->getByPk($pelicula);

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

        $data = $request->only(['titulo', 'sinopsis', 'duracion', 'fecha_estreno', 'precio', 'pais_id']);

        // Upload de imagen.
        if($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');

            // Subimos el archivo usando el disco "public" del filesystem de Laravel.
//            $path = $imagen->store('imgs', 'public');
//            $data['imagen'] = $path;

            // Versión con redimensionado vía intervention/image.
            // Primero, creamos el nombre de la imagen, obteniendo la extensión del cliente.
            $nombreImagen = md5(time()) . '.' . $imagen->clientExtension();
            // Abrimos la imagen con make() para poder editarla en memoria.
            // La redimensionamos con resize a 400x400, manteniendo la proporción.
            // Y la guardamos en la ruta del storage.
            Image::make($imagen)->resize(400, 400, function($constraint) {
                // Esto le dice que redimensione manteniendo la proporción.
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save(storage_path('app/public/imgs/' . $nombreImagen));
            $data['imagen'] = 'imgs/' . $nombreImagen;
//            dd($imagen);
        }

        // Creamos la película, y obtenemos la instancia creada.
        $pelicula = $this->repository->create($data);
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

    public function editarForm($pelicula)
    {
        $pelicula = $this->repository->getByPk($pelicula);
        $paises = Pais::all();
        $generos = Genero::all();

        return view('peliculas.editar', compact('pelicula', 'paises', 'generos'));
    }

    public function editar(Request $request, $pelicula)
    {
        $request->validate(Pelicula::$rules, Pelicula::$errorMessages);

//        $pelicula->update($request->only(['titulo', 'fecha_estreno', 'sinopsis', 'precio', 'duracion', 'pais_id']));

        // Para actualizar los géneros, usamos el práctico método "sync" de la relación (noten que
        // accedemos a generos como método, no propiedad).
        // Este método, se encarga de sincronizar los registros de la tabla pivot para esta película
        // de manera que solo queden los que están en el array que le paso.
//        $pelicula->generos()->sync($request->input('genero_id'));

        $this->repository->update($pelicula, $request->only(['titulo', 'fecha_estreno', 'sinopsis', 'precio', 'duracion', 'pais_id', 'genero_id']));

        return redirect()
            ->route('peliculas.index')
            ->with('message', 'La película fue editada con éxito.');
    }

    public function eliminar($pelicula)
    {
        // Quitamos las relaciones de la tabla pivot.
//        $pelicula->generos()->detach();
        // Como estamos haciendo un Soft Delete ahora, no necesitamos eliminar los datos de la tabla
        // pivot. :)

        // El método delete() elimina el registro del modelo que lo invoca.
//        $pelicula->delete();
        $this->repository->delete($pelicula);

        return redirect()->route('peliculas.index')
            // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
            ->with('message', 'La película se eliminó exitosamente.')
            ->with('message_type', 'success');
    }

    public function restaurar($pelicula)
    {
        $pelicula = Pelicula::withTrashed()->findOrFail($pelicula);

        $pelicula->restore();

        return redirect()->route('peliculas.index')
            // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
            ->with('message', 'La película ' . $pelicula->titulo . ' se rehabilitó exitosamente.')
            ->with('message_type', 'success');
    }
}
