<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Proyecto en Laravel')</title>
    <link rel="stylesheet" href="<?= url('css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= url('css/estilos.css');?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">DV Películas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Abrir/cerrar menú de navegación">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('/');?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('/peliculas');?>">Películas</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        {{-- La directiva yield permite "ceder" ese espacio a los que implementen este template.
         Debemos ponerle un nombre entre paréntesis. --}}
        @yield('main')
    </div>
    <div class="footer">
        <p>Copyright &copy; Da Vinci 2021</p>
    </div>
</body>
</html>
