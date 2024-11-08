<?php

class CompraItem
{

    private $idCompraItem;
    private Producto $producto;
    private Compra $compra;
    private $ciCantidad;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idCompraItem = "";
        $this->producto = new Producto();
        $this->compra = new Compra();
        $this->ciCantidad = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idCompraItem, $producto, $compra, $ciCantidad)
    {
        $this->setIdCompraItem($idCompraItem);
        $this->setProducto($producto);
        $this->setCompra($compra);
        $this->setCiCantidad($ciCantidad);
    }

    //getters

    public function getIdCompraItem()
    {
        return $this->idCompraItem;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getCompra()
    {
        return $this->compra;
    }

    public function getCiCantidad()
    {
        return $this->ciCantidad;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    //setters

    public function setIdCompraItem($idCompraItem)
    {
        $this->idCompraItem = $idCompraItem;
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function setCompra($compra)
    {
        $this->compra = $compra;
    }

    public function setCiCantidad($ciCantidad)
    {
        $this->ciCantidad = $ciCantidad;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $compra = new Compra();
                    $compra->setIdCompra($row['idcompra']);
                    $producto = new Producto();
                    $producto->setIdProducto($row['idproducto']);
                    $this->cargar($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                }
            }
        } else {
            $this->setMensajeOperacion("CompraItem->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad)
        VALUES ('"
            . $this->getProducto()->getIdProducto() . "', '"
            . $this->getCompra()->getIdCompra() . "', '"
            . $this->getCiCantidad() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("CompraItem->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->insertar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET idproducto=" . $this->getProducto()->getIdProducto() . ", idcompra=" . $this->getCompra()->getIdCompra() . ", cicantidad=" . $this->getCiCantidad() .
            "  WHERE idcompraitem=" . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem=" . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("CompraItem->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new CompraItem();
                    $producto = new Producto();
                    $producto->setIdProducto($row['idproducto']);
                    $producto->buscar();
                    $compra = new Compra();
                    $compra->setIdCompra($row['idcompra']);
                    //$compra->buscar();
                    $obj->cargar($row['idcompraitem'], $producto, $compra, $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar las compraItem: " . $base->getError());
        }
        return $arreglo;
    }


    public function jsonSerialize()
    {

        $producto = null;
        if ($this->getProducto() != null) {
            $producto = $this->getProducto()->jsonSerialize();
        }
        return [
            'idCompraItem' => $this->getIdCompraItem(),
            'producto' => $producto,
            'ciCantidad' => $this->getCiCantidad()
        ];
    }
}
