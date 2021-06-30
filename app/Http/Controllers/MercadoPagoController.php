<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;

class MercadoPagoController extends Controller
{
    public function comprarForm()
    {
        $peliculas = Pelicula::findMany([1, 3, 4]);
//        $pelicula = Pelicula::find(1);

        // Creamos los items para el cobro.
        $items = [];
        foreach($peliculas as $pelicula) {
            $item = new Item();
            $item->title = $pelicula->pelicula_id;
            $item->unit_price = $pelicula->precio;
            $item->quantity = 1;
            $items[] = $item;
        }

        // Creamos la "preferencia" (detalles de la transacción).
        $preference = new Preference();
        // Le definimos los items, que deben ser un array de objetos MercadoPago\Item.
        $preference->items = $items;

        // Configuramos las URLs de callback para los resultados de los pagos.
        $preference->back_urls = [
            'success' => route('mp.pago.confirmado'),
            'pending' => route('mp.pago.pendiente'),
            'failure' => route('mp.pago.fallado')
        ];

        $preference->external_reference = "sara@za.com-" . auth()->user()->usuario_id;

        $payer = new Payer();
        $payer->name = 'Sara';
        $payer->surname = 'Za';
        $payer->email = 'sara@za.com';
        $payer->identification = [
            'type' => 'DNI',
            'number' => '12312312',
        ];

        $preference->payer = $payer;

        // "Guardamos" los detalles de la preferencia.
        $preference->save();

        return view('mp.form', compact('preference'));
    }

    public function pagoConfirmado(Request $request)
    {
        echo "Pago aprobado!";
//        echo "<pre>";
        dump($request->query());
//        echo "</pre>";
    }

    public function pagoPendiente(Request $request)
    {
        echo "Pago pendiente...";
//        echo "<pre>";
        dump($request->query());
//        echo "</pre>";
    }

    public function pagoFallido(Request $request)
    {
        echo "Error al pagar >:(";
//        echo "<pre>";
        dump($request->query());
//        echo "</pre>";
    }
}
