<?php

namespace App\Cart;


use App\Models\Pelicula;

class CarritoItem
{
    /** @var Pelicula */
    protected $producto;

    /** @var int */
    protected $cantidad;

    public function getSubtotal()
    {
        return $this->getProducto()->precio * $this->getCantidad();
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
        $this->cantidad = $this->cantidad ?? 1;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
}
