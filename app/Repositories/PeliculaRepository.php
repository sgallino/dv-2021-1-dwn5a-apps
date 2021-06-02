<?php

namespace App\Repositories;

use App\Models\Pelicula;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PeliculaRepository
 *
 * Esta clase funciona como repositorio de películas.
 * Esto implica que su responsabilidad es la de abstraer para el resto de las clases cómo se obtienen
 * las películas, o cómo se administran sus datos (ej: ABM).
 * En pocas palabras, todo lo que tiene que ver con la base de datos y generación de los modelos.
 *
 * @package App\Repositories
 */
class PeliculaRepository implements PeliculaRepositoryInterface
{
    /** @var Pelicula */
//    protected $pelicula;
//
//    public function __construct()
//    {
//        $this->pelicula = new Pelicula();
//    }

    /**
     * @param array $searchParams
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Pelicula[]|Collection
     */
    public function all($searchParams = [])
    {
        // Para buscar, como puede haber una búsqueda o no, vamos a separar en pasos la ejecución
        // de la llamada de Eloquent.
        $peliculasQuery = Pelicula::with(['pais', 'generos', 'calificacion'])/*->withTrashed()*/;

        // Preguntamos si hay algún parámetro de búsqueda.
        // Para pedir datos que llegan por GET en el query string, tenemos el método "query".
        if(isset($searchParams['titulo'])) {
            $peliculasQuery->where('titulo', 'like', '%' . $searchParams['titulo'] . '%');
        }

        // paginate() nos permite pedir los resultados paginados.
        // Como primer parámetro, le podemos pasar cuántos registros queremos por página.
        return $peliculasQuery->paginate(2)->withQueryString();
    }

    /**
     * @param int $pk
     * @return Pelicula|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Pelicula::findOrFail($pk);
    }

    /**
     * @param array $data
     * @return Pelicula|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Pelicula::create($data);
    }

    public function update($pk, $data = [])
    {
        $pelicula = Pelicula::findOrFail($pk);
        $pelicula->update($data);

        // Para actualizar los géneros, usamos el práctico método "sync" de la relación (noten que
        // accedemos a generos como método, no propiedad).
        // Este método, se encarga de sincronizar los registros de la tabla pivot para esta película
        // de manera que solo queden los que están en el array que le paso.
        $pelicula->generos()->sync($data['genero_id']);
        return $pelicula;
    }

    public function delete($pk)
    {
        $pelicula = Pelicula::findOrFail($pk);

        $pelicula->delete();

        return $pelicula;
    }
}
