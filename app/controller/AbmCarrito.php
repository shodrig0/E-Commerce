<?php

class AbmCarrito
{


    public function agregarProductoCarrito($param)
    {
        $productoAgregado = false;
        $session = new Session;
        $carrito = $session->getCarritoSession() ?? [];
        $abmProducto = new AbmProducto;
        $productoEncontrado = false;
        $i = 0;
    
        while ($i < count($carrito) && !$productoEncontrado) {
            if ($carrito[$i]["idproducto"] == $param["idproducto"]) {
                $carrito[$i]['cantidadproducto'] += $param['cantidad'];
            
                if ($carrito[$i]['cantidadproducto'] <= 0) {
                    unset($carrito[$i]);
                    $carrito = array_values($carrito); // Reindexar el array
                }
                
                $productoEncontrado = true;
                $productoAgregado = true;
            }
            $i++;
        }
    
        if (!$productoEncontrado) {
            $productos = $abmProducto->buscarProducto($param);
            if (!empty($productos)) {
                $producto = $productos[0];
                
                if ($param['cantidad'] > 0) {
                    $nuevoItem = [
                        'idproducto' => $producto->getIdProducto(),
                        'nombre' => $producto->getProNombre(),
                        'precio' => $producto->getPrecio(), // Usar precio unitario
                        'cantidadproducto' => $param['cantidad']
                    ];
                    $carrito[] = $nuevoItem;
                    $productoAgregado = true;
                }
            }
        }
        $session->setCarritoSession($carrito);
        return $productoAgregado;
    }
    
    public function obtenerCarritoConPrecios()
    {
        $session = new Session;
        $carrito = $session->getCarritoSession() ?? [];
        $precioTotal = 0;

        foreach ($carrito as &$item) {
            $item['precioTotal'] = $item['precio'] * $item['cantidadproducto'];
            $precioTotal += $item['precioTotal'];
        }

        return ['carrito' => $carrito, 'precioTotal' => $precioTotal];
    }

    public function eliminarProductoCarrito($param)
    {
        $session = new Session;
        $carrito = $session->getCarritoSession() ?? [];
        $productoEncontrado = false;
        $i = 0;
        while ($i < count($carrito) && !$productoEncontrado) {
            if ($carrito[$i]["idproducto"] == $param["idproducto"]) {
                unset($carrito[$i]);
                $productoEncontrado = true;
            }
            $i++;
        }

        if ($productoEncontrado) {
            // Reindexar el array y guardar el carrito actualizado
            $carrito = array_values($carrito);
            $session->setCarritoSession($carrito);
        }

        return $productoEncontrado;
    }

    public function obtenerCarrito()
    {
        $session = new Session();
        return $session->getCarritoSession() ?? [];
    }
}