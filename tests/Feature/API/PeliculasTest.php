<?php
/*
 * Queremos testear una API REST para un ABM de películas.
 * Para empezar, queremos testear el endpoint que retorne todas las películas.
 */

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeliculasTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutamos todos los seeders antes de cada test.
        $this->seed();
    }

    /**
     *
     * @return void
     */
    public function test_api_peliculas_returns_all_the_movies_in_the_database_as_json()
    {
        // Para hacer peticiones a una API REST, que reciba y retorne JSONs, Laravel nos ofrece en su clase
        // TestCase métodos como getJson o postJson para facilitarnos la existencia.
        $response = $this->getJson('/api/peliculas');

        // Para facilitar la depuración, Laravel ofrece un método "dump" en la clase TestResponse.
//        $response->dump();

        // Necesitamos verificar:
        // - Que el status de HTTP de la respuesta sea 200.
        // - Cantidad de items (películas).
        // - La estructura de la respuesta.
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'pelicula_id',
                        'pais_id',
                        'calificacion_id',
                        'titulo',
                        'sinopsis',
                        'duracion',
                        'fecha_estreno',
                        'imagen',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ]
                ]
            ])
            ->assertJsonCount(6, 'data');
    }

    public function test_api_post_peliculas_creates_a_new_movie()
    {
        // Usando actingAs(User) podemos hacer que la petición funcione como si ese User estuviera
        // autenticado.
        $user = new User();
        $user->id = 1;

        $response = $this
            ->actingAs($user)
            ->postJson('/api/peliculas/', [
                'titulo' => 'Volver al Futuro',
                'sinopsis' => '¿Se acuerdan del DeLorean?',
                'duracion' => 120,
                'precio' => 19999,
                'fecha_estreno' => '1985-01-01',
                'pais_id' => 1,
                'calificacion_id' => 1,
            ]);

//        $response->dump();

        // Necesitamos verificar:
        // - Status http => 200
        // - Respuesta tenga el formato: [code, data: [...]]
        // - Respuesta Code => 0
        // - Retorne los datos de la película con el id correspondiente.
        $response->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data' => [
                    'pelicula_id',
                    'pais_id',
                    'calificacion_id',
                    'titulo',
                    // ...
                ]
            ])
            ->assertJsonFragment(['code' => 0])
            ->assertJsonFragment(['pelicula_id' => 7]);
    }

    public function test_api_post_peliculas_validates_empty_fields()
    {
        // Usando actingAs(User) podemos hacer que la petición funcione como si ese User estuviera
        // autenticado.
//        $user = new User();
//        $user->id = 1;
//
//        $response = $this
//            ->actingAs($user)
//            ->postJson('/api/peliculas', []);
        $response = $this
            ->withAuth()
            ->postJson('/api/peliculas', []);

//        $response->dump();

        // Necesitamos validar:
        // - Status http
        // - Formato del JSON
        // - Los errores correctos
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['titulo', 'precio', 'fecha_estreno', 'pais_id']);
    }

    /**
     * @return PeliculasTest
     */
    protected function withAuth()
    {
        // Usando actingAs(User) podemos hacer que la petición funcione como si ese User estuviera
        // autenticado.
        $user = new User();
        $user->id = 1;

        return $this->actingAs($user);
    }
}
