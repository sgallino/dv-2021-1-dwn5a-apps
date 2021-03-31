{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Crear película nueva')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Crear nueva película</h1>

    <p>Completá el form.</p>

    <form action="{{ route('peliculas.crear') }}" method="post">
        {{-- La directiva de Blade "csrf" agrega un campo hidden para enviar el token de protección
        contra CSRF. Sin esto, la petición va a siempre retornar 419. --}}
        @csrf
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control">
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" id="precio" name="precio" class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_estreno">Fecha de estreno</label>
            <input type="text" id="fecha_estreno" name="fecha_estreno" class="form-control">
        </div>
        <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="text" id="duracion" name="duracion" class="form-control">
        </div>
        <div class="form-group">
            <label for="sinopsis">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-control"></textarea>
        </div>
        <button class="btn btn-block btn-primary">Crear :D</button>
    </form>
@endsection
