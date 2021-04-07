<?php
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \App\Models\Pelicula $pelicula */
?>
{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Editar película')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Editar película</h1>

    <p>Completá el form.</p>

    <form action="{{ route('peliculas.editar', ['pelicula' => $pelicula->pelicula_id]) }}" method="post">
        {{-- La directiva de Blade "csrf" agrega un campo hidden para enviar el token de protección
        contra CSRF. Sin esto, la petición va a siempre retornar 419. --}}
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="{{ old('titulo', $pelicula->titulo) }}" @error('titulo') aria-describedby="error-titulo" @enderror>
            @error('titulo')
            <div class="alert alert-danger" id="error-titulo">{{ $message }}</div>
            @enderror
{{--            @if($errors->has('titulo'))--}}
{{--            <div class="alert alert-danger">{{ $errors->first('titulo') }}</div>--}}
{{--            @endif--}}
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" id="precio" name="precio" class="form-control" value="{{ old('precio', $pelicula->precio) }}" @error('precio') aria-describedby="error-precio" @enderror>
            @error('precio')
            <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="fecha_estreno">Fecha de estreno</label>
            <input type="text" id="fecha_estreno" name="fecha_estreno" class="form-control" value="{{ old('fecha_estreno', $pelicula->fecha_estreno) }}" @error('fecha_estreno') aria-describedby="error-fecha_estreno" @enderror>
            @error('fecha_estreno')
            <div class="alert alert-danger" id="error-fecha_estreno">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="text" id="duracion" name="duracion" class="form-control" value="{{ old('duracion', $pelicula->duracion) }}">
        </div>
        <div class="form-group">
            <label for="sinopsis">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-control">{{ old('sinopsis', $pelicula->sinopsis) }}</textarea>
        </div>
        <button class="btn btn-block btn-primary">Editar :D</button>
    </form>
@endsection
