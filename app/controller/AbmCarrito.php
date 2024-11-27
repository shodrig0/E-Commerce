<?php

class AbmCarrito { 
    

    public function agregarProductoCarrito($param){

            $productoAgregado = false;
            $session = new Session;
            $carrito = $session->getCarritoSession() ?? [];
            $abmProducto = new AbmProducto;
            $productoEncontrado = false;
            $i = 0;
    
            // Verificar si el producto ya está en el carrito
            while ($i < count($carrito) && !$productoEncontrado) {
                if ($carrito[$i]["idproducto"] == $param["idproducto"]) {
                    // Producto encontrado, incrementar la cantidad
                    $carrito[$i]['cantidadproducto'] += $param['cantidad'];
                    $productoEncontrado = true;
                    $productoAgregado = true;
                }
                $i++;
            }
            // Si no se encontró el producto en el carrito, buscarlo y agregarlo
            if (!$productoEncontrado) {
                $productos = $abmProducto->buscarProducto($param);
                if (!empty($productos)) {
                    $producto = $productos[0];
                    $nuevoItem = [
                        'idproducto' => $producto->getIdProducto(),
                        'nombre' => $producto->getProNombre(),
                        'precio' => $producto->getPrecio() * $param['cantidad'],
                        'cantidadproducto' => $param['cantidad']
                    ];
                    $carrito[] = $nuevoItem;
                    $productoAgregado = true;
                }
            }
            $session->setCarritoSession($carrito);
            
            return $productoAgregado;

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