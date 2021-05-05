<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pais[] $paises */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
?>
{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Crear película nueva')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Crear nueva película</h1>

    <p>Completá el form.</p>

    <form action="{{ route('peliculas.crear') }}" method="post" enctype="multipart/form-data">
        {{-- La directiva de Blade "csrf" agrega un campo hidden para enviar el token de protección
        contra CSRF. Sin esto, la petición va a siempre retornar 419. --}}
        @csrf
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="{{ old('titulo') }}" @error('titulo') aria-describedby="error-titulo" @enderror>
            @error('titulo')
            <div class="alert alert-danger" id="error-titulo">{{ $message }}</div>
            @enderror
{{--            @if($errors->has('titulo'))--}}
{{--            <div class="alert alert-danger">{{ $errors->first('titulo') }}</div>--}}
{{--            @endif--}}
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" id="precio" name="precio" class="form-control" value="{{ old('precio') }}" @error('precio') aria-describedby="error-precio" @enderror>
            @error('precio')
            <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="fecha_estreno">Fecha de estreno</label>
            <input type="text" id="fecha_estreno" name="fecha_estreno" class="form-control" value="{{ old('fecha_estreno') }}" @error('fecha_estreno') aria-describedby="error-fecha_estreno" @enderror>
            @error('fecha_estreno')
            <div class="alert alert-danger" id="error-fecha_estreno">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="text" id="duracion" name="duracion" class="form-control" value="{{ old('duracion') }}">
        </div>
        <div class="form-group">
            <label for="pais_id">País</label>
            <select id="pais_id" name="pais_id" class="form-control">
            @foreach($paises as $pais)
                    <option value="{{ $pais->pais_id }}" @if(old('pais_id') == $pais->pais_id) selected @endif>{{ $pais->nombre }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="sinopsis">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-control">{{ old('sinopsis') }}</textarea>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
        </div>
        <fieldset>
            <legend>Géneros</legend>
            @foreach($generos as $genero)
                <label><input type="checkbox" name="genero_id[]" value="{{ $genero->genero_id }}" @if( in_array($genero->genero_id, old('genero_id', [])) ) checked @endif> {{ $genero->nombre }}</label>
            @endforeach
        </fieldset>
        <button class="btn btn-block btn-primary">Crear :D</button>
    </form>
@endsection
