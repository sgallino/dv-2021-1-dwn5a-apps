{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Listado de películas')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Listado de películas</h1>

    <p>Estas son las películas del momento.</p>

    <a href="<?= url('/peliculas/nueva');?>">Crear nueva película</a>

    <p><i>Acá hay una tabla con películas (usen su imaginación).</i></p>
@endsection
