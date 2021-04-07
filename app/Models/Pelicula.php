<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property string $titulo
 * @property string $sinopsis
 * @property int|null $duracion
 * @property int|null $precio
 * @property string|null $fecha_estreno
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereDuracion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereFechaEstreno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePeliculaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereSinopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pelicula extends Model
{
    // Por defecto, Laravel busca una tabla que se llame igual que el modelo, pero como plural en inglés
    // y todo minúsculas.
    // Si eso no nos sirve, podemos en cada modelo especificar manualmente el nombre de la tabla.
    protected $table = "peliculas";
    // Por defecto, Laravel asume que la PK de la tabla es "id".
    // Si eso no nos sirve, podemos aclararle cuál es la PK usando:
    protected $primaryKey = "pelicula_id";

    // $fillable permite definir una lista de los valores que permitimos hacer un "Mass assignment" en
    // un INSERT cuando usamos el método "create()" de Eloquent.
    // De no estar presente, Laravel lanza un error.
    protected $fillable = [
        'titulo',
        'sinopsis',
        'precio',
        'fecha_estreno',
        'duracion',
    ];

    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'titulo' => 'required|min:2',
//        'titulo' => ['required', 'min:2'],
        'precio' => 'required|numeric',
        'fecha_estreno' => 'required|date'
    ];

    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'titulo.required' => 'Tenés que escribir el título de la película.',
        'titulo.min' => 'El título tiene que tener al menos 2 caracteres.',
        'precio.required' => 'Tenés que escribir el precio de la película.',
        'precio.numeric' => 'El precio de la película tiene que ser un número, sin decimales. Ej: 1234',
        'fecha_estreno.required' => 'Tenés que escribir la fecha de estreno de la película.',
        'fecha_estreno.date' => 'La fecha de estreno tiene que tener el siguiente formato: AAAA-MM-DD. Ej: 1999-02-23',
    ];
}
