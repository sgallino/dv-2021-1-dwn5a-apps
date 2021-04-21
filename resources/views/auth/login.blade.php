@extends('layouts.main')

@section('title', 'Crear película nueva')

@section('main')
    <h1>Iniciar sesión</h1>
    <p>Ingresá tus credenciales blah blah</p>

    <form action="{{ route('auth.login') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
    </form>
@endsection
