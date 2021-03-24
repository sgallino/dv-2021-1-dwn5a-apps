<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema es la clase de Laravel para manipular una base de datos.
        // create() es el método con el que se crea una table en la base, y recibe 2 parámetros:
        // 1. String. El nombre de la tabla que quiero crear.
        // 2. Closure. El código que define la tabla a crear. A este Closure le vamos a inyectar por
        //  parámetro una instancia de "Blueprint".
        // Blueprint ("plano de construcción" en inglés) es la clase que lleva la definición de una
        //  tabla.
        Schema::create('peliculas', function (Blueprint $table) {
            // Campos que queremos en la tabla de películas:
            // - pelicula_id
            // - titulo
            // - sinopsis
            // - duracion
            // - precio
            // - fecha_estreno
            // - pais_id (FK)
            // El campo pais_id requiere que creemos una tabla de paises, y lo podemos agregar después.

            // id() es un shortcut para crear una columna con las siguientes características:
            //  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PK
            // Si quieren cambiarle el nombre al campo, lo pueden pasar por parámetro.
            $table->id('pelicula_id');
            // Si queremos agregar un campo VARCHAR, llamamos al método "string".
            // Si no ponen la longitud, Laravel por defecto define 255.
            $table->string('titulo', 100);
            // Si queremos agregar un campo TEXT, usamos el método text equivalente.
            $table->text('sinopsis');
            // Si quiero guardar la duración, tengo opciones:
            // Puedo usar un TIME para guardar la hora y minutos.
            // Puedo usar un INT para guardar los minutos.
            $table->unsignedSmallInteger('duracion')->nullable();
            // Finalmente tenemos el precio.
            // Acá hay 3 opciones, que vamos a ordenar de la peor a la mejor:
            // 3. FLOAT/DOUBLE: Float y double son valores decimales de precisión APROXIMADA.
            // 2. DECIMAL(n, d): Decimal también permite valores decimales, pero de precisión EXACTA.
            // 1. INT: La forma más recomendada para almacenar valores monetarios, es guardarlos en
            //      centavos como INT, y luego convertirlos a decimales a la hora de mostrarlos.
            // ¿Por qué INT es mejor que DECIMAL? El problema radica a la hora operar, específicamente,
            // aplicar operaciones matemáticas. Con DECIMAL o FLOAT, la computadora va a hacer
            // operaciones aritméticas con flotantes. Es decir, los errores de aproximación ahora pueden
            // incrementarse por las operaciones matemáticas como multiplicación o división.
            // Para evitarse TODOS los dolores de cabeza que VAN a venir con eso, se recomienda usar
            // enteros, y hacer operaciones con enteros, que son MUCHO más precisas.
            $table->unsignedBigInteger('precio')->nullable();
            // Para un DATE, usamos date().
            $table->date('fecha_estreno')->nullable();

            // timestamps() define dos columnas en la tabla:
            // 1. `created_at` NULLABLE TIMESTAMP
            // 2. `updated_at` NULLABLE TIMESTAMP
            // Esas columnas Laravel, si usamos Eloquent, las va a mantener actualizadas en relación a
            // cada registro.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas');
    }
}
