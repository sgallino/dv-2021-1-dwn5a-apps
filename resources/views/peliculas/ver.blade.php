{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', $pelicula->titulo)

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>{{ $pelicula->titulo }}</h1>

    <dl>
        <dt>Fecha de estreno</dt>
        <dd>{{ $pelicula->fecha_estreno }}</dd>
        <dt>Precio</dt>
        <dd>$ {{ $pelicula->precio / 100 }}</dd>
        <dt>Duración</dt>
        <dd>{{ $pelicula->duracion }}</dd>
        <dt>Sinopsis</dt>
        <dd>{{ $pelicula->sinopsis }}</dd>
    </dl>
@endsection
