<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Hacer algo.
        // TODO: Validar...

        // Para autenticar, Laravel tiene una clase Auth, que también podemos acceder a través de la
        // función auth().
        // Entre los métodos, tiene uno de "attempt" que intenta loguear al usuario, y retorna true o
        // false dependiendo de si tuvo éxito o no.
        // Ese método recibe como parámetro un array de al menos 2 claves:
        // 1. 'password': Debe llamarse exactamente así la clave, y contener en el valor el password.
        // 2. Otra columna que sirva para traer el usuario con el cual comparar el password.
        // Por ejemplo, si yo llamo:
        // attempt(['password' => 'asd', 'email' => 'pepe@trueno.com', 'activo' => 1])
        // La consulta que Laravel va a ser es del estilo:
        // SELECT * FROM usuarios
        // WHERE email = :email
        // AND activo = :activo
        // Cada holder será reemplazado por sus respectivos valores.
        // Si el registro existe, entonces recién ahí compara el password.

        // Definimos un array con las credenciales.
        $credenciales = $request->only(['password', 'email']);
//        $credenciales['activo'] = 1;
//        $credenciales = [
//            'password' => $request->input('password'),
//            'email' => $request->input('email'),
//            'activo' => 1, // Definirlo así es útil para agregar otros valores.
//        ];

        // Tratamos de autenticar.
        if(!auth()->attempt($credenciales)) {
            // Error de autenticación, lo mandamos al login.
            return redirect()
                ->route('auth.login-form')
                // withInput envía los datos del form para poder levantarlos con la función old()
                ->withInput()
                ->with('message', 'Las credenciales ingresadas no coinciden con nuestro registros.')
                ->with('message_type', 'danger');
        }

        // Listo, el usuario está felizmente autenticado :)
        return redirect()
            ->route('peliculas.index')
            ->with('message', 'Bienvenido de vuelta :)')
            ->with('message_type', 'success');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()
            ->route('auth.login')
            ->with('message', 'Cerraste sesión exitosamente. Te esperamos pronto :)');
    }
}
