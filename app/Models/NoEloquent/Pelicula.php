<?php

namespace App\Models\NoEloquent;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property string $titulo
 * @property string $sinopsis
 * @property int|null $duracion
 * @property int|null $precio
 * @property string|null $fecha_estreno
 * @property int $pais_id
 * @property Genero[] $generos
 * @property Pais $pais
 * @property Calificacion $calificacion
 */
class Pelicula
{
    public $titulo;
    public $sinopsis;
    public $precio;
    public $fecha_estreno;
    public $duracion;
    public $imagen;
    public $pais_id;
    public $pais;
    public $generos = [];
    public $calificacion;

    public function links()
    {
        return '';
    }

    public function trashed()
    {
        return false;
    }
}
