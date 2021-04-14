<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculasTienenGenerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas_tienen_generos', function (Blueprint $table) {
            $table->id('pelicula_tiene_genero_id');
//            $table->unsignedBigInteger('pelicula_id');
            // Creamos el campo pelicula_id ya como una FK (forma nueva).
            $table->foreignId('pelicula_id')->constrained('peliculas', 'pelicula_id');
            $table->unsignedSmallInteger('genero_id');
            $table->timestamps();

            // Forma tradicional de definir una FK a partir de una columna existente.
            $table->foreign('genero_id')->references('genero_id')->on('generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas_tienen_generos');
    }
}
