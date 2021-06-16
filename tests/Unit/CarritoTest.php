<?php

namespace Tests\Unit;

use App\Cart\CarritoItem;
use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;
use App\Cart\Carrito;

class CarritoTest extends TestCase
{
    protected $cart;

    protected function setUp(): void
    {
        $this->cart = new Carrito;
    }

    public function test_agregar_item_adds_that_item_to_the_cart()
    {
        // Instaciamos un CarritoItem para agregar.
        // Técnicamente, esto es una dependencia.
        $ci = $this->createItem(1, 499.99);
        $this->cart->agregarItem($ci);

//        $this->assertEquals(1, count($this->cart->getItems()));
        $this->assertCount(1, $this->cart->getItems());
//        $this->assertInstanceOf(CarritoItem::class, $this->cart->getItems()[0]);
        $this->assertEquals($ci, $this->cart->getItems()[0]);
    }

    public function test_agregar_item_adds_two_of_the_same_item_it_sets_its_quantity_to_two()
    {
        // Instaciamos un CarritoItem para agregar.
        // Técnicamente, esto es una dependencia.
        $ci = $this->createItem(1, 499.99);
        $ci2 = $this->createItem(1, 499.99);

        $this->cart->agregarItem($ci);
        $this->cart->agregarItem($ci2);

        $this->assertCount(1, $this->cart->getItems());
        $this->assertEquals(1, $this->cart->getItems()[0]->getProducto()->pelicula_id);
        $this->assertEquals(2, $this->cart->getItems()[0]->getCantidad());
    }

    public function test_agregar_item_adds_two_different_items_as_two_different_items()
    {
        // Instaciamos un CarritoItem para agregar.
        // Técnicamente, esto es una dependencia.
        $ci = $this->createItem(1, 499.99);
        $ci2 = $this->createItem(2, 159.99);

        $this->cart->agregarItem($ci);
        $this->cart->agregarItem($ci2);

        $this->assertCount(2, $this->cart->getItems());
        $this->assertEquals($ci, $this->cart->getItems()[0]);
        $this->assertEquals($ci2, $this->cart->getItems()[1]);
    }

    public function test_quitar_item_removes_the_requested_item()
    {
        $ci = $this->createItem(1, 499.99);

        $this->cart->agregarItem($ci);

        $this->cart->quitarItem(1);

        $this->assertCount(0, $this->cart->getItems());
    }

    public function test_quitar_item_doesnt_remove_a_not_included_item()
    {
        $ci = $this->createItem(1, 499.99);

        $this->cart->agregarItem($ci);

        $this->cart->quitarItem(4);

        $this->assertCount(1, $this->cart->getItems());
    }

    public function test_get_monto_total_returns_the_subtotal_sum_of_all_items()
    {
        $precio1 = 499.99;
        $precio2 = 159.99;
        $precio3 = 499.99;
        $ci = $this->createItem(1, $precio1);
        $ci2 = $this->createItem(2, $precio2);
        $ci3 = $this->createItem(1, $precio3);

        $this->cart->agregarItem($ci);
        $this->cart->agregarItem($ci2);
        $this->cart->agregarItem($ci3);

        $total = $this->cart->getMontoTotal();

        $expectedTotal = $precio1 + $precio2 + $precio3;
        $this->assertEquals($expectedTotal, $total);
//        $this->assertEquals(1159.97, $total);
    }

    public function createItem($id, $precio)
    {
        $ci = new CarritoItem();
        $pel = new Pelicula();
        $pel->pelicula_id = $id;
        $pel->precio = $precio;
        $ci->setProducto($pel);
        return $ci;
    }
}
