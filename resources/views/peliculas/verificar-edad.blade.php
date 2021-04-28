{{-- Extendemos el template de views/layouts/main.blade.php --}}
@extends('layouts.main')

@section('title', 'Verificar edad antes de seguir')

{{-- section permite indicar el contenido en qué espacio cedido del layout queremos ubicarlo --}}
@section('main')
    <h1>Verificación de edad</h1>

    <p>Antes de seguir a ver la película, como es para mayores de 18, necesitamos que nos confirmes que sos mayor de 18 años.</p>

    <form action="{{ route('peliculas.verificar-edad') }}" method="POST">
        @csrf
        <button class="btn btn-primary">Sí, soy mayor de 18 años</button>
        <a href="{{ route('peliculas.index') }}" class="btn btn-danger">No, soy muy chico para estar acá ¡Sáquenme!</a>
    </form>
@endsection
