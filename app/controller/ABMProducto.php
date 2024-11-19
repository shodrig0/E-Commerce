<?php

class AbmProducto
{
    // Crear un producto
    public function agregarProducto($datos)
    {
        $producto = new Producto();
        $producto->cargar(null, $datos['proNombre'], $datos['proDetalle'], $datos['precio'], $datos['proCantStock']);
        if ($producto->insertar()) {
            return ['success' => true, 'message' => 'Producto agregado exitosamente.'];
        } else {
            return ['success' => false, 'message' => $producto->getMensajeOperacion()];
        }
    }

    // Modificar un producto
    public function modificarProducto($datos)
    {
        $producto = new Producto();
        $producto->cargar($datos['idProducto'], $datos['proNombre'], $datos['proDetalle'], $datos['precio'], $datos['proCantStock']);
        if ($producto->modificar()) {
            return ['success' => true, 'message' => 'Producto modificado exitosamente.'];
        } else {
            return ['success' => false, 'message' => $producto->getMensajeOperacion()];
        }
    }

    // Eliminar un producto
    public function eliminarProducto($idProducto)
    {
        $producto = new Producto();
        $producto->setIdProducto($idProducto);
        if ($producto->eliminar()) {
            return ['success' => true, 'message' => 'Producto eliminado exitosamente.'];
        } else {
            return ['success' => false, 'message' => $producto->getMensajeOperacion()];
        }
    }

    // Listar productos
    public function listarProductos($filtro = "")
    {
        try {
            $productos = Producto::listar($filtro);
            return ['success' => true, 'productos' => $productos];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al listar los productos: ' . $e->getMessage()];
        }
    }

    // Buscar un producto por ID
    public function buscarProducto($idProducto)
    {   
        $resp = null;
        $producto = new Producto();
        $producto->cargarClave(['idProducto' => $idProducto]);
        if ($producto->buscar()) {
            $resp = $producto;
        }
        return $resp;
    }
}
?>
