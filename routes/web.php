<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeliculasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * La clase Route nos permite definir rutas en mi aplicación.
 * Las rutas se definen usando el método de la clase con el nombre del verbo HTTP que queremos crear
 * (ej: get, post, put, patch, delete, options).
 *
 * Recibe 2 parámetros:
 * 1. String. La ruta a partir de la carpeta public.
 * 2. Closure|array. Los closures son funciones anónimas, o equivalentes.
 *  En el caso de usar un Closure, le ponemos dentro lo que queremos ejecutar cuando se acceda a la
 * ruta. Es básicamente lo que hicimos como un método de un Controller, sin ser un método de un
 * Controller. No suele usarse, ya que provoca tener todo el código de mi aplicación dentro del archivo
 * de ruteo.
 *  La forma normal de asociar las rutas es justamente a métodos de controllers.
 *  Para asociarlos, pasamos en vez del Closure un array de 2 posiciones:
 *      1. String. El nombre de la clase del Controller.
 *      2. String. El nombre del método que debe ejecutarse.
 *
 * Lo que nosotros hacíamos:
 *  'NombreController@método'
 * En Laravel 8+ es:
 *  [NombreController::class, 'método']
 */
//Route::get('/', function () {
//    return view('welcome');
//});
// Usando el método "name" podemos ponerle un nombre a cada ruta para poder luego llamarla de esa forma.
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/peliculas', [PeliculasController::class, 'index'])->name('peliculas.index');
Route::get('/peliculas/nueva', [PeliculasController::class, 'nuevaForm'])->name('peliculas.nueva-form');
Route::post('/peliculas/nueva', [PeliculasController::class, 'crear'])->name('peliculas.crear');
Route::get('/peliculas/{pelicula}', [PeliculasController::class, 'ver'])->name('peliculas.ver');
Route::get('/peliculas/{pelicula}/editar', [PeliculasController::class, 'editarForm'])->name('peliculas.editarForm');
Route::put('/peliculas/{pelicula}/editar', [PeliculasController::class, 'editar'])->name('peliculas.editar');

Route::delete('/peliculas/{pelicula}/eliminar', [PeliculasController::class, 'eliminar'])->name('peliculas.eliminar');
