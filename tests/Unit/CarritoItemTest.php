<?php

namespace Tests\Unit;

use App\Cart\CarritoItem;
use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;

/*
 * Requerimientos y convenciones:
 * - [req] Todas las clases de test en phpUnit heredan de la clase TestCase del framework.
 * - [conv] Las clases de los tests se llaman igual que la clase que testean más el sufijo "Test".
 * - [conv] Los métodos de la clase que representen un test empiezan con el prefijo "test".
 * - [conv] Cada test debería testear un flujo o escenario en particular. Es decir, un camino de ejecución
 *   por test.
 * - [conv] Los nombres de los métodos de los tests deben ser tan largos como sea necesario para que sean
 *   claramente descriptivos de lo que hacen.
 *
 * ## Anatomía de un test
 * En general, un test se compone de 3 etapas:
 * 1. Preparación del entorno.
 *  Esto implica definir las variables/clases/etc que son necesarias para realizar el test.
 * 2. Ejecución del código a testear.
 * 3. Verificar expectativas.
 *  Las expectativas se verifican a través de "assertions" ("aseveración/afirmación", "verificación").
 *  Las assertions son métodos de TestCase que empiezan con el prefijo "assert".
 *
 * ## Ejecutando los tests en la línea de comandos
 * 1. Llamar al ejecutable de phpUnit:
 *      vendor\bin\phpunit
 * 2. Llamar a phpUnit a través de un comando de artisan:
 *      php artisan test
 */
class CarritoItemTest extends TestCase
{
    public function test_can_create_instance_from_carritoitem()
    {
        $ci = new CarritoItem;

        $this->assertInstanceOf(CarritoItem::class, $ci);
    }

    public function test_can_set_a_movie_to_a_carritoitem()
    {
        $ci = new CarritoItem();

        $pelicula = new Pelicula();
        $pelicula->pelicula_id = 1;
        $pelicula->precio = 499.99;

        $ci->setProducto($pelicula);

        $this->assertEquals($pelicula, $ci->getProducto());
    }

    public function test_set_a_movie_to_a_carritoitem_without_quantity_defaults_quantity_to_one()
    {
        $ci = new CarritoItem();

        $pelicula = new Pelicula();
        $pelicula->pelicula_id = 1;
        $pelicula->precio = 499.99;

        $ci->setProducto($pelicula);

        $this->assertEquals(1, $ci->getCantidad());
    }

    public function test_set_cantidad_of_5_sets_it_correctly()
    {
        $ci = new CarritoItem();

        $expected = 5;

        $ci->setCantidad($expected);

        $this->assertEquals($expected, $ci->getCantidad());
    }

    // test_get_subtotal_retorna_el_precio_por_cantidad
    public function test_get_subtotal_returns_the_price_times_quantity()
    {
        $ci = new CarritoItem();

        $pelicula = new Pelicula();
        $pelicula->pelicula_id = 1;
        $pelicula->precio = 499.99;

        $cantidad = 5;

        $ci->setProducto($pelicula);
        $ci->setCantidad($cantidad);

        $subtotal = $ci->getSubtotal();

        $this->assertEquals(2499.95, $subtotal);
    }
}
