<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vamos a insertar algunos registros en la tabla.
        // Para insertar a través de lo que sería un "query", podemos usar la fachada "DB", que sirve
        // para todo lo que es consultas contra la base de datos.
        // table() permite indicar con qué tabla quiero interactuar en este query.
        // Luego, a través de una interfaz "fluida" ("fluent") podemos indicarle el insert.
        DB::table('peliculas')->insert([
            'pelicula_id' => 1,
            'titulo' => 'Casablanca',
            'sinopsis' => 'Play it again, Sam.',
            'duracion' => 90,
            'precio' => 3099,
            'fecha_estreno' => '1940-06-15',
            'pais_id' => 2,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        // También podemos insertar múltiples registros en
        // una sola acción.
        DB::table('peliculas')->insert([
            [
                'pelicula_id' => 2,
                'titulo' => 'El Discurso del Rey',
                'sinopsis' => 'I have a voice!',
                'duracion' => 110,
                'precio' => 2499,
                'fecha_estreno' => '2015-05-07',
                'pais_id' => 3,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'pelicula_id' => 3,
                'titulo' => 'The Matrix',
                'sinopsis' => 'I know Kung Fu.',
                'duracion' => 132,
                'precio' => 2899,
                'fecha_estreno' => '1999-04-22',
                'pais_id' => 2,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
        ]);

        DB::table('peliculas_tienen_generos')->insert([
            [
                'pelicula_id' => 1,
                'genero_id' => 1,
            ],
            [
                'pelicula_id' => 1,
                'genero_id' => 4,
            ],
            [
                'pelicula_id' => 2,
                'genero_id' => 1,
            ],
            [
                'pelicula_id' => 2,
                'genero_id' => 5,
            ],
            [
                'pelicula_id' => 3,
                'genero_id' => 3,
            ],
        ]);
    }
}
