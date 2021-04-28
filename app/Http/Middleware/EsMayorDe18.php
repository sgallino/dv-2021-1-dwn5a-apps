<?php

namespace App\Http\Middleware;

use App\Models\Pelicula;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class EsMayorDe18
 *
 * Verifica si la película en cuestión tiene una calificación para mayores de 18, en cuyo caso
 * verificamos si el usuario ya indicó que es mayor.
 * Si ya lo hizo, entonces lo dejamos seguir. Sino, lo redireccionamos a la página de confirmación antes
 * de dejarlo proseguir.
 *
 * Si indicó o no que es mayor lo tenemos que guardar en alguna variable de sesión.
 *
 * @package App\Http\Middleware
 */
class EsMayorDe18
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // ¿Cómo obtenmos la película que están pidiendo?
        // Como probamos recién, no podemos en un middleware pedir por argumento los parámetros de la
        // ruta.
        // Cualquier cosa que queramos manejar, lo tenemos que pedir a algún elemento del framework,
        // o alguno de los parámetros que tenemos en el handle.
        // Para obtener el dato, podemos pedirle a $request si propia route() que nos retorna la
        // instancia de la ruta.
        // A su vez, le podemos pedir que nos retorne el parámetro "pelicula" que estamos esperando.
        // Y sorpresa sorpresa, no solo funciona y nos retorna el parámetro, sino que ya lo asoció a un
        // modelo.
        // Esto se debe a que Laravel analiza de antemano los requisitos del método del controller, y
        // reconoce que está bindeando este parámetro a un objeto Pelicula.
        /** @var Pelicula $pelicula */
        $pelicula = $request->route()->parameter('pelicula');
        // Podemos ver que esto nos retorna el objeto Pelicula.
//        echo "<pre>";
//        print_r($pelicula);
//        echo "</pre>";

        // Preguntamos si la película tiene una calificación para mayores de 18.
        if($pelicula->calificacion_id == 4) {
            // Requiere que el usuario confirme que es mayor de 18.
            // Verificamos si ya hizo la confirmación. Caso contrario, lo mandamos a la pantalla de
            // confirmación.
            if(!Session::has('mayor_de_18_verificado')) {
                Session::put('pelicula_que_quiere_ver', $pelicula->pelicula_id);
                return redirect()->route('peliculas.verificar-edad');
            }
        }

        // Si no pasó lo anterior, lo dejamos seguir de largo.
        return $next($request);
    }
}
