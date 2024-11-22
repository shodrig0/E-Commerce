<?php

class AbmCompraItem
{
    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idcompraitem', $param) and array_key_exists('idproducto', $param) and array_key_exists('idcompra', $param) and array_key_exists('cicantidad', $param)) {
            $obj = new CompraItem();
            $objProducto = new Producto();
            $objProducto->setIdproducto($param["idproducto"]);
            $objProducto->cargar();
            $objCompra = new Compra();
            $objCompra->setIdcompra($param["idcompra"]);
            $objCompra->cargar();
            $obj->setear($param['idcompraitem'], $objProducto, $objCompra, $param["cicantidad"]);
        }
        return $obj;
    }

    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraitem'])) {
            $obj = new CompraItem();
            $obj->setear($param['idcompraitem'], null, null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo están seteados los campos claves.
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraitem'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Permite crear un objeto.
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $param['idcompraitem'] = null;
        $objCompraItem = $this->cargarObjeto($param);
        if ($objCompraItem != null and $objCompraItem->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Permite eliminar un objeto.
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            if ($objCompraItem != null and $objCompraItem->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Permite modificar un objeto.
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjeto($param);
            if ($objCompraItem != null and $objCompraItem->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Permite buscar un objeto.
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idcompraitem'])) {
                $where .= " and idcompraitem =" . $param['idcompraitem'];
            }
            if (isset($param['idproducto'])) {
                $where .= " and idproducto =" . $param['idproducto'];
            }
            if (isset($param['idcompra'])) {
                $where .= " and idcompra =" . $param['idcompra'];
            }
            if (isset($param['cicantidad'])) {
                $where .= " and cicantidad =" . $param['cicantidad'];
            }
        }
        $objCompraItem = new CompraItem();
        $arreglo = $objCompraItem->listar($where);
        return $arreglo;
    }

    /**
     * Elimina un ítem de compra.
     * @param array $param
     * @return void
     */
    public function eliminarItemDeCompra($param)
    {
        $arregloObjCompraItem = $this->buscar(['idcompraitem' => $param['idcompraitem']]);
        $idCompraActual = $arregloObjCompraItem[0]->getObjCompra()->getIdcompra();
        $this->baja(['idcompraitem' => $param['idcompraitem']]);
        $arregloObjCompraItem = $this->buscar(['idcompra' => $idCompraActual]);
        if ($arregloObjCompraItem == []) {
            $objAbmCompra = new AbmCompra();
            $objAbmCompra->baja(['idcompra' => $idCompraActual]);
        }
    }

    /**
     * Elimina un ítem de compra y actualiza el stock.
     * @param array $param
     * @return array
     */
    public function eliminarCompraItem($param)
    {
        $arreglo["idcompra"] = $param["idcompra"];
        $arreglo1["idcompraitem"] = $param["idcompraitem"];
        $objAbmCompraEstado = new AbmCompraEstado();
        $listaCompraEstado = $objAbmCompraEstado->buscar(null);
        $estadoMasAvanzado = 0;
        for ($i = 0; $i < count($listaCompraEstado); $i++) {
            if (
                $listaCompraEstado[$i]->getObjCompraEstadoTipo()->getIdcompraestadotipo() > $estadoMasAvanzado
                && $listaCompraEstado[$i]->getObjCompra()->getIdcompra() == $param["idcompra"]
            ) {
                $estadoMasAvanzado = $listaCompraEstado[$i]->getObjCompraEstadoTipo()->getIdcompraestadotipo();
            }
        }
        if ($estadoMasAvanzado == 1) {
            $objAbmCompraItem1 = new AbmCompraItem();
            $arregloObjCompraItem = $objAbmCompraItem1->buscar($arreglo1);
            $cantidadDevolver = $arregloObjCompraItem[0]->getCicantidad();
            $objAbmProducto = new AbmProducto();
            $idProductoDevolver = $arregloObjCompraItem[0]->getObjProducto()->getIdproducto();
            $arregloObjProducto = $objAbmProducto->buscar(['idproducto' => $idProductoDevolver]);
            $cantidadActual = $arregloObjProducto[0]->getProcantstock();
            $nuevaCantidad = $cantidadActual + $cantidadDevolver;

            $productoModificado['idproducto'] = $idProductoDevolver;
            $productoModificado['pronombre'] = $arregloObjProducto[0]->getPronombre();
            $productoModificado['prodetalle'] = $arregloObjProducto[0]->getProdetalle();
            $productoModificado['procantstock'] = $nuevaCantidad;
            $productoModificado['proprecio'] = $arregloObjProducto[0]->getProPrecio();
            $productoModificado['prodeshabilitado'] = $arregloObjProducto[0]->getProdeshabilitado();
            if ($this->baja($arreglo1)) {
                if ($objAbmProducto->modificacion($productoModificado)) {
                    // Verificar si quedan más compra-items para la compra
                    $compraItemsRestantes = $this->buscar(['idcompra' => $param['idcompra']]);
                    if (count($compraItemsRestantes) == 0) {
                        // No quedan más compra-items, actualizar el estado de la compra a "cancelada"
                        $paramCompraEstado = [
                            'idcompra' => $param['idcompra'],
                            'idcompraestadotipo' => 4, // Suponiendo que 4 es el ID del estado "cancelada"
                            'cefechaini' => date('Y-m-d H:i:s'),
                            'cefechafin' => null
                        ];
                        $objAbmCompraEstado->cambiarEstado($paramCompraEstado);
                    }
                    $respuesta["respuesta"] = "La compraItem se dio de baja correctamente y se devolvieron los artículos al stock";
                } else {
                    $respuesta["errorMsg"] = "No se pudo dar de baja la compraItem";
                }
            } else {
                $respuesta["errorMsg"] = "No se pudo dar de baja la compraItem";
            }
        } else {
            $respuesta["errorMsg"] = "Solo se pueden eliminar ítems cuando el estado de la compra es 'iniciada'";
        }
        return $respuesta;
    }

    /**
     * Lista todos los ítems de compra.
     * @return array
     */
    public function listarCompraItem()
    {
        $listaCompraItem = $this->buscar();
        $arregloSalida = array();
        foreach ($listaCompraItem as $elemento) {
            if ($elemento->getObjCompra()->getMetodo() == 'normal') {
                $nuevoElemento['idcompraitem'] = $elemento->getIdcompraitem();
                $nuevoElemento['idproducto'] = $elemento->getObjProducto()->getIdproducto();
                $nuevoElemento['pronombre'] = $elemento->getObjProducto()->getPronombre();
                $nuevoElemento['cicantidad'] = $elemento->getCicantidad();
                $nuevoElemento['idcompra'] = $elemento->getObjCompra()->getIdcompra();
                $nuevoElemento['usnombre'] = $elemento->getObjCompra()->getObjUsuario()->getUsnombre();
                array_push($arregloSalida, $nuevoElemento);
            }
        }
        return $arregloSalida;
    }
}