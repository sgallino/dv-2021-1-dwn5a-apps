<?php
/** @var \App\Models\Pelicula[]|\Illuminate\Database\Eloquent\Collection $peliculas */
?>
{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Listado de películas')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Listado de películas</h1>

    <p>Estas son las películas del momento.</p>

    <a href="<?= url('/peliculas/nueva');?>">Crear nueva película</a>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Fecha de estreno</th>
            <th>País</th>
            <th>Géneros</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($peliculas as $pelicula)
        <tr>
            <td>{{ $pelicula->pelicula_id }}</td>
            <td>{{ $pelicula->titulo }}</td>
            <td>{{ $pelicula->fecha_estreno }}</td>
{{--            <td>{{ $pelicula->pais !== null ? $pelicula->pais->nombre : 'No disponible' }}</td>--}}
            <td>{{ $pelicula->pais->nombre }}</td>
            <td>
            @if($pelicula->generos->count() > 0)
                {{-- Dos maneras de imprimir lo mismo. --}}
                {{-- Forma 1: La tradicional usando un foreach (easy mode) --}}
                @foreach($pelicula->generos as $genero)
                    <span class="badge badge-primary">{{ $genero->nombre }}</span>
                @endforeach
                {{-- Forma 2: Estilo funcional (hard mode, y en este caso, unnecessary mode) --}}
{{--                {!! $pelicula->generos->map(function($genero) {--}}
{{--                    return '<span class="badge badge-primary">' . $genero->nombre . '</span>';--}}
{{--                })->join(' ') !!}--}}
                {{-- Noten la diferencia de los tags para imprimir de Blade.
                 La variante que abre con !! en vez de una segunda lleva, imprime el texto literal.
                 La forma tradicional, escapa cualquier caracter de HTML automáticamente para evitar
                 inyección de HTML.
                 --}}
            @else
                No disponibles
            @endif
            </td>
            <td>$ {{ $pelicula->precio / 100 }}</td>
            <td><a href="{{ route('peliculas.ver', ['pelicula' => $pelicula->pelicula_id]) }}">Ver detalles</a> <a href="{{ route('peliculas.editarForm', ['pelicula' => $pelicula->pelicula_id]) }}">Editar</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
