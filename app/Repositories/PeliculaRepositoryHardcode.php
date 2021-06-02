<?php

namespace App\Repositories;

use App\Models\NoEloquent\Calificacion;
use App\Models\NoEloquent\Genero;
use App\Models\NoEloquent\Pais;
use App\Models\NoEloquent\Pelicula;

class PeliculaRepositoryHardcode implements PeliculaRepositoryInterface
{
    public function all($searchParams = [])
    {
        // Retornamos una serie de Películas hardcodeadas.
        $salida = [];
        $pel1 = new Pelicula();
        $pel1->pelicula_id = 1;
        $pel1->titulo = "Película hardcode 1";
        $pel1->precio = 123;
        $pel1->fecha_estreno = '2021-01-01';
        $pel1->calificacion = new Calificacion();
        $pel1->calificacion->nombre = "Calificación Hardcode";
        $pel1->pais = new Pais();
        $pel1->pais->nombre = 'Hardcodelandia';
        $gen1 = new Genero();
        $gen1->nombre = 'Hard';
        $gen2 = new Genero();
        $gen2->nombre = 'Code';
        $pel1->generos[] = $gen1;
        $pel1->generos[] = $gen2;

        $pel2 = new Pelicula();
        $pel2->pelicula_id = 2;
        $pel2->titulo = "Película hardcode Versión 2";
        $pel2->precio = 432;
        $pel2->fecha_estreno = '2021-01-02';
        $pel2->calificacion = new Calificacion();
        $pel2->calificacion->nombre = "Calificación Re-Hardcode";
        $pel2->pais = new Pais();
        $pel2->pais->nombre = 'Hardcodelandia';
        $gen1 = new Genero();
        $gen1->nombre = 'Re-Hard';
        $gen2 = new Genero();
        $gen2->nombre = 'Code';
        $pel2->generos[] = $gen1;
        $pel2->generos[] = $gen2;

        $salida[] = $pel1;
        $salida[] = $pel2;

        return $salida;
    }

    public function getByPk($pk)
    {
        // TODO: Implement getByPk() method.
    }

    public function create($data = [])
    {
        // TODO: Implement create() method.
    }

    public function update($pk, $data = [])
    {
        // TODO: Implement update() method.
    }

    public function delete($pk)
    {
        // TODO: Implement delete() method.
    }
}
