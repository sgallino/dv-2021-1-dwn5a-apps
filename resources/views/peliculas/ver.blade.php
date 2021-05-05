<?php
/** @var \App\Models\Pelicula $pelicula */
?>
{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', $pelicula->titulo)

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>{{ $pelicula->titulo }}</h1>

    {{-- Si hay una imagen, la vamos a mostrar :)
    Con Storage::disk('public')->exists($pelicula->imagen)
    le indicamos que vamos a preguntar si existe ese archivo en el disk public.
     --}}
    @if(Storage::disk('public')->exists($pelicula->imagen))
        {{-- Con el helper "asset" podemos imprimir un archivo de public. Para que salga de storage, simplemente le prefijamos la ruta 'storage/'. --}}
        <img src="{{ asset('storage/' . $pelicula->imagen) }}" alt="Portada de {{ $pelicula->titulo }}">
    @endif

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

    <form action="{{ route('peliculas.eliminar', ['pelicula' => $pelicula->pelicula_id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Eliminar</button>
    </form>
@endsection
