<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\VerificarEdadController;
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
Route::get('/', [HomeController::class, 'index'])
    ->name('home');


// El nombre de la ruta del form de login es importante para que el middleware de autenticación de
// Laravle nos redireccione.
// Por defecto, busca el nombre "login".
// Si lo quieren cambiar, pueden ir a:
// app/Http/Middleware/Authenticate
// Y modificar la ruta en el método.
Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('auth.login-form');
Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])
    ->name('auth.logout');


// Desde las mismas rutas, a través de un "middleware", podemos indicar cuales requieren autenticación
// para poder ingresar. El middleware en cuestión es "auth".
//Route::get('/peliculas', [PeliculasController::class, 'index'])
//    ->name('peliculas.index');
//
//Route::get('/peliculas/nueva', [PeliculasController::class, 'nuevaForm'])
//    ->name('peliculas.nueva-form')
//    ->middleware(['auth']);
//
//Route::post('/peliculas/nueva', [PeliculasController::class, 'crear'])
//    ->name('peliculas.crear')
//    ->middleware(['auth']);
//
//Route::get('/peliculas/{pelicula}', [PeliculasController::class, 'ver'])
//    ->name('peliculas.ver');
//
//Route::get('/peliculas/{pelicula}/editar', [PeliculasController::class, 'editarForm'])
//    ->name('peliculas.editarForm')
//    ->middleware(['auth']);
//
//Route::put('/peliculas/{pelicula}/editar', [PeliculasController::class, 'editar'])
//    ->name('peliculas.editar')
//    ->middleware(['auth']);
//
//Route::delete('/peliculas/{pelicula}/eliminar', [PeliculasController::class, 'eliminar'])
//    ->name('peliculas.eliminar')
//    ->middleware(['auth']);

Route::get('verificar-edad', [VerificarEdadController::class, 'verificarForm'])
    ->name('peliculas.verificar-edad-form');
Route::post('verificar-edad', [VerificarEdadController::class, 'verificar'])
    ->name('peliculas.verificar-edad');

// Definimos las mismas rutas de películas, pero englobándolas en un grupo.
Route::prefix('/peliculas')->group(function() {
    Route::get('/', [PeliculasController::class, 'index'])
        ->name('peliculas.index');

    Route::get('/{pelicula}', [PeliculasController::class, 'ver'])
        ->name('peliculas.ver')
        ->middleware(['mayor.18']) // Agregamos el middleware que agregamos en Kernel.
//        ->where('pelicula', '[0-9]+'); // Pide que "pelicula" sea un número.
        ->whereNumber('pelicula'); // Pide que "pelicula" sea un número.

    Route::middleware(['auth'])->group(function() {
        Route::get('/nueva', [PeliculasController::class, 'nuevaForm'])
            ->name('peliculas.nueva-form');

        Route::post('/nueva', [PeliculasController::class, 'crear'])
            ->name('peliculas.crear');

        Route::get('/{pelicula}/editar', [PeliculasController::class, 'editarForm'])
            ->name('peliculas.editarForm');

        Route::put('/{pelicula}/editar', [PeliculasController::class, 'editar'])
            ->name('peliculas.editar');

        Route::put('/{pelicula}/restaurar', [PeliculasController::class, 'restaurar'])
            ->name('peliculas.restaurar');

        Route::delete('/{pelicula}/eliminar', [PeliculasController::class, 'eliminar'])
            ->name('peliculas.eliminar');
    });
});

/*
 |--------------------------------------------------------------------------
 | Ejemplo con MercadoPago
 |--------------------------------------------------------------------------
 */
Route::get('mptest/comprar', [MercadoPagoController::class, 'comprarForm']);

Route::get('mptest/pago-confirmado', [MercadoPagoController::class, 'pagoConfirmado'])->name('mp.pago.confirmado');
Route::get('mptest/pago-pendiente', [MercadoPagoController::class, 'pagoPendiente'])->name('mp.pago.pendiente');
Route::get('mptest/pago-fallado', [MercadoPagoController::class, 'pagoFallido'])->name('mp.pago.fallado');
