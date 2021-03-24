{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Crear película nueva')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Crear nueva película</h1>

    <p>Completá el form.</p>

    <p><i>Acá hay un form con campos para crear una película (usen su imaginación).</i></p>
@endsection
