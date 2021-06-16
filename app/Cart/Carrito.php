<?php

namespace App\Cart;


class Carrito
{
    /** @var array|CarritoItem[] */
    protected $items = [];

    /**
     * @param CarritoItem $newItem
     */
    public function agregarItem(CarritoItem $newItem)
    {
        foreach($this->items as $item) {
            if($item->getProducto()->pelicula_id == $newItem->getProducto()->pelicula_id) {
                $item->setCantidad($item->getCantidad() + 1);
                return;
            }
        }
        $this->items[] = $newItem;
    }

    /**
     * Quita el item con el $id indicado.
     *
     * @param $id
     */
    public function quitarItem($id)
    {
//        $this->items = $this->items;
        foreach($this->items as $key => $item) {
            if($item->getProducto()->pelicula_id == $id) {
                unset($this->items[$key]);
                // Si queremos reiniciar los índices del array...
//                $this->items = array_values($this->items);
            }
        }
    }

    /**
     * Retorna la suma de los subtotales de los items.
     *
     * @return float|int
     */
    public function getMontoTotal()
    {
        $total = 0;
        foreach($this->items as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }

    /**
     * @return array|CarritoItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
