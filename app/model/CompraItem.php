<?php

class CompraItem
{
    private $idcompraitem;
    private $objProducto;
    private $objCompra;
    private $cicantidad;
    private $mensajeoperacion;

    /**
     * Constructor de la clase CompraItem.
     * Inicializa los atributos de la clase.
     */
    public function __construct()
    {
        $this->idcompraitem = null;
        $this->objProducto = new Producto();
        $this->objCompra = new Compra();
        $this->cicantidad = null;
        $this->mensajeoperacion = "";
    }

    /**
     * Setea los atributos de la clase CompraItem.
     * @param int $idcompraitemS
     * @param Producto $objProductoS
     * @param Compra $objCompraS
     * @param int $cicantidadS
     */
    public function setear($idcompraitemS, $objProductoS, $objCompraS, $cicantidadS)
    {
        $this->setIdcompraitem($idcompraitemS);
        $this->setObjProducto($objProductoS);
        $this->setObjCompra($objCompraS);
        $this->setCicantidad($cicantidadS);
    }

    public function getIdcompraitem()
    {
        return $this->idcompraitem;
    }
    public function setIdcompraitem($nuevoIdcompraitem)
    {
        $this->idcompraitem = $nuevoIdcompraitem;
    }

    public function getObjProducto()
    {
        return $this->objProducto;
    }
    public function setObjProducto($nuevoObjProducto)
    {
        $this->objProducto = $nuevoObjProducto;
    }

    public function getObjCompra()
    {
        return $this->objCompra;
    }
    public function setObjCompra($nuevoObjCompra)
    {
        $this->objCompra = $nuevoObjCompra;
    }

    public function getCicantidad()
    {
        return $this->cicantidad;
    }
    public function setCicantidad($nuevoCicantidad)
    {
        $this->cicantidad = $nuevoCicantidad;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($nuevomensajeoperacion)
    {
        $this->mensajeoperacion = $nuevomensajeoperacion;
    }

    /**
     * Carga los datos de un ítem de compra desde la base de datos.
     * @return boolean
     */
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdcompraitem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objProducto = new Producto();
                    $objProducto->setIdproducto($row["idproducto"]);
                    $objProducto->cargar();
                    $objCompra = new Compra();
                    $objCompra->setIdcompra($row["idcompra"]);
                    $objCompra->cargar();
                    $this->setear($row["idcompraitem"], $objProducto, $objCompra, $row["cicantidad"]);
                    $respuesta = true;
                }
            }
        } else {
            $this->setmensajeoperacion("CompraItem->listar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Inserta un nuevo ítem de compra en la base de datos.
     * @return boolean
     */
    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) 
            VALUES (" . $this->getObjProducto()->getIdproducto() . " , " .
            $this->getObjCompra()->getIdcompra() . " , " .
            $this->getCicantidad() . ")";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdcompraitem($elid);
                $respuesta = true;
            } else {
                $this->setmensajeoperacion("CompraItem->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraItem->insertar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Modifica un ítem de compra existente en la base de datos.
     * @return boolean
     */
    public function modificar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem 
            SET idproducto = " . $this->getObjProducto()->getIdproducto() .
            ", idcompra = " . $this->getObjCompra()->getIdcompra() .
            ", cicantidad = " . $this->getCicantidad() .
            " WHERE idcompraitem = " . $this->getIdcompraitem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setmensajeoperacion("CompraItem->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraItem->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Elimina un ítem de compra de la base de datos.
     * @return boolean
     */
    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem = " . $this->getIdcompraitem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setmensajeoperacion("CompraItem->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraItem->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Lista los ítems de compra de la base de datos que cumplen con el parámetro dado.
     * @param string $parametro
     * @return array
     */
    public static function listar($parametro = "")
{
    $arreglo = array();
    $base = new BaseDatos();
    $sql = "SELECT * FROM compraitem ";
    if ($parametro != "") {
        $sql .= "WHERE " . $parametro;
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
        if ($res > 0) {
            while ($row = $base->Registro()) {
                $obj = new CompraItem();
                
                // Crear y cargar el objeto Producto
                $objProducto = new Producto();
                $objProducto->setIdproducto($row["idproducto"]);
                $objProducto->cargar();

                // Crear y cargar el objeto Compra
                $objCompra = new Compra();
                $objCompra->setIdcompra($row["idcompra"]);
                $objCompra->cargar();

                // Configurar el objeto CompraItem
                $obj->setear($row["idcompraitem"], $objProducto, $objCompra, $row["cicantidad"]);
                array_push($arreglo, $obj);
            }
        }
    } else {
        throw new Exception("Error al listar los ítems de compra: " . $base->getError());
    }
    return $arreglo;
}

}