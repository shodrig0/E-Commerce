<?php

class AbmProducto
{
    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     * @return object
     */

    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idproducto', $param) && array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('precio', $param) && array_key_exists('procantstock', $param)) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], $param['pronombre'], $param['prodetalle'],$param["precio"] ,$param['procantstock']);
        }
        return $obj;
    }

    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null, null, null);
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
        if (isset($param['idproducto'])) {
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
        $param['idproducto'] = null;
        $objProducto = $this->cargarObjeto($param);
        if ($objProducto != null and $objProducto->insertar()) {
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
        echo "ID PRODUCTO?";
        var_dump($param);
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto != null and $objProducto->eliminar()) {
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
            $objProducto = $this->cargarObjeto($param);
            echo "BOOLEAN";
            var_dump($objProducto);
            if ($objProducto != null and $objProducto->modificar()) {
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
    public function buscarProducto($param)
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idproducto'])) {
                $where .= " and idproducto =" . $param['idproducto'];
            }
            if (isset($param['pronombre'])) {
                $where .= " and pronombre ='" . $param['pronombre'] . "'";
            }
            if (isset($param['prodetalle'])) {
                $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            }
            if (isset($param['procantstock'])) {
                $where .= " and procantstock =" . $param['procantstock'];
            }
            if (isset($param['proprecio'])) {
                $where .= " and proprecio =" . $param['proprecio'];
            }
            if (isset($param['prodeshabilitado'])) {
                $where .= " and prodeshabilitado ='" . $param['prodeshabilitado'] . "'";
            }
        }
        $objProducto = new Producto();
        $arreglo = $objProducto->listar($where);
        return $arreglo;
    }

    /**
     * Crea un nuevo producto.
     * @param array $param
     * @return array
     */
    public function crearProducto($param)
    {
        $param["prodeshabilitado"] = null;
        $param["procantstock"] = 0;
        $param["proprecio"] = intval($param["proprecio"]);
        if ($param["proprecio"] > 0) {
            if ($this->alta($param)) {
                $respuesta["respuesta"] = "Se dio de alta el producto correctamente";
            } else {
                $respuesta["errorMsg"] = "No se pudo realizar el alta del producto";
            }
        } else {
            $respuesta["errorMsg"] = "El precio debe ser mayor a 0";
        }
        return $respuesta;
    }

    /**
     * Carga una imagen para el producto.
     * @param array $param
     * @return array
     */
    public function cargaDeImagen($param)
    {
        $arreglo["idproducto"] = $param["idproducto"];
        if ($this->buscarProducto($arreglo)) {
            if ($param[0]["imagen"]["type"] == "image/jpeg") {
                $archivo = "../../img/productos/" . $param["idproducto"] . ".jpg";
                if (file_exists($archivo)) {
                    unlink($archivo);
                    if (copy($param[0]["imagen"]["tmp_name"], "../../img/productos/" . $param["idproducto"] . ".jpg")) {
                        $respuesta["respuesta"] = "El archivo se subió correctamente";
                    } else {
                        $respuesta["errorMsg"] = "No se pudo subir el archivo";
                    }
                } else {
                    if (copy($param[0]["imagen"]["tmp_name"], "../../img/productos/" . $param["idproducto"] . ".jpg")) {
                        $respuesta["respuesta"] = "El archivo se subió correctamente";
                    } else {
                        $respuesta["errorMsg"] = "No se pudo subir el archivo";
                    }
                }
            } else {
                $respuesta["errorMsg"] = "El archivo debe ser .jpg";
            }
        } else {
            $respuesta["errorMsg"] = "No existe ningún producto con el id ingresado";
        }
        return $respuesta;
    }

    /**
     * Edita un producto existente.
     * @param array $param
     * @return array
     */
    public function editarProducto($param)
    {
        $arreglo["idproducto"] = $param["idproducto"];
        $listaProductos = $this->buscarProducto($arreglo);
        $param["prodeshabilitado"] = $listaProductos[0]->getProdeshabilitado();
        $param["procantstock"] = $listaProductos[0]->getProcantstock();
        if ($param["proprecio"] > 0) {
            if ($this->modificacion($param)) {
                $respuesta["respuesta"] = "Se modificó el producto correctamente";
            } else {
                $respuesta["errorMsg"] = "No se pudo realizar la modificación del producto";
            }
        } else {
            $respuesta["errorMsg"] = "El precio debe ser mayor a 0";
        }
        return $respuesta;
    }

    /**
     * Edita el stock de un producto.
     * @param array $param
     * @return array
     */
    public function editarStock($param)
    {
        $arreglo["idproducto"] = $param["idproducto"];
        $listaProductos = $this->buscarProducto($arreglo);
        $param["proprecio"] = $listaProductos[0]->getProprecio();
        $param["prodeshabilitado"] = $listaProductos[0]->getProdeshabilitado();
        $param["procantstock"] = intval($param["procantstock"]);
        if ($param["procantstock"] > 0) {
            if ($this->modificacion($param)) {
                $respuesta["respuesta"] = "Se modificó el stock correctamente";
            } else {
                $respuesta["errorMsg"] = "No se pudo realizar la modificación del stock";
            }
        } else {
            $respuesta["errorMsg"] = "El stock debe ser mayor a 0";
        }
        return $respuesta;
    }

    /**
     * Lista todos los productos.
     * @return array
     */
    public function listarProductos()
    {
        $listaProductos = $this->buscarProducto(null);
        $arregloSalida = array();
        foreach ($listaProductos as $elemento) {
            $nuevoElemento['idproducto'] = $elemento->getIdproducto();
            $nuevoElemento['pronombre'] = $elemento->getPronombre();
            $nuevoElemento['prodetalle'] = $elemento->getProdetalle();
            $nuevoElemento['proprecio'] = $elemento->getProprecio();
            if ($elemento->getProdeshabilitado() == null) {
                $nuevoElemento["prodeshabilitado"] = "Habilitado";
            } else {
                $nuevoElemento["prodeshabilitado"] = "Deshabilitado (" . $elemento->getProdeshabilitado() . ")";
            }
            $caminoArchivo = "../../img/productos/" . $elemento->getIdproducto() . ".jpg";
            if (file_exists($caminoArchivo)) {
                $nuevoElemento["imagen"] = "<img src='../img/productos/" . $elemento->getIdproducto() . ".jpg?" . time() . "' width='100px' height='66px'>";
            } else {
                $nuevoElemento["imagen"] = "Sin Imagen";
            }

            array_push($arregloSalida, $nuevoElemento);
        }
        return $arregloSalida;
    }

    /**
     * Lista el stock de todos los productos.
     * @return array
     */
    public function listarStock()
    {
        $listaProductos = $this->buscarProducto([]);
        $arregloSalida = array();
        foreach ($listaProductos as $elemento) {
            $nuevoElemento['idproducto'] = $elemento->getIdproducto();
            $nuevoElemento['pronombre'] = $elemento->getPronombre();
            $nuevoElemento['prodetalle'] = $elemento->getProdetalle();
            $nuevoElemento['procantstock'] = $elemento->getProcantstock();
            array_push($arregloSalida, $nuevoElemento);
        }
        return $arregloSalida;
    }
}