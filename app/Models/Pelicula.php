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
 * @property int $pais_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos
 * @property-read int|null $generos_count
 * @property-read \App\Models\Pais $pais
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
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePaisId($value)
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
        'pais_id',
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

    /*
     |--------------------------------------------------------------------------
     | Relaciones
     |--------------------------------------------------------------------------
     */
    // Cada relación se define con un método.
    // El nombre del método va a ser la forma de acceder a los modelos asociados.
    // Esos métodos deben retornar la relación.
    public function pais()
    {
        // belongsTo() permite definir una relación de uno-a-muchos en la tabla referenciante (es
        // decir, la del muchos, la que lleva la FK).
        // Todos los métodos de relación reciben como primer argumento el nombre del modelo al que
        // se asocian.
        // Si no usan las convenciones de Laravel (como yo), entonces tienen que agregar algunos
        // parámetros más.
        // Segundo parámetro: "Foreign Key".
        // Tercer parámetro: "Owner Key".
        // Donde "Foreign Key" hace referencia al campo de la FK, y "Owner Key" al campo de la PK que
        // se referencia.
        return $this->belongsTo(Pais::class, 'pais_id', 'pais_id');
    }

    public function generos()
    {
        // belongsToMany() es el método para definir una relación n:n.
        // Este recibe unos cuántos parámetros más (aparte del modelo) si no siguen las convenciones
        // de Laravel.
        // Segundo parámetro: "table" - La tabla pivot.
        // Tercer parámetro: "foreignPivotKey"
        //      El nombre de la FK para la tabla de _este_ modelo en la tabla pivot.
        //      En este caso, sería "pelicula_id" de "peliculas_tienen_generos".
        // Cuarto parámetro: "relatedPivotKey"
        //      El nombre de la FK para la tabla del _otro_ modelo en la tabla pivot.
        //      En este caso, sería "genero_id" de "peliculas_tienen_generos".
        // Quinto parámetro: "parentKey"
        //      El nombre de la PK de _este_ modelo al que la foreignPivotKey apunta.
        // Sexto parámetro: "relatedKey".
        //      La PK del _otro_ modelo al que relatedPivotKey apunta.
        return $this->belongsToMany(Genero::class, 'peliculas_tienen_generos', 'pelicula_id', 'genero_id', 'pelicula_id', 'genero_id');
    }
}
