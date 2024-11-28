<?php

class AbmCompraEstado
{
    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idcompraestado', $param) and array_key_exists('idcompra', $param) and array_key_exists('idcompraestadotipo', $param) and array_key_exists('cefechaini', $param) and array_key_exists('cefechafin', $param)) {
            $obj = new CompraEstado();
            $objCompra = new Compra();
            $objCompra->setIdcompra($param["idcompra"]);
            $objCompra->cargar();
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdcompraestadotipo($param["idcompraestadotipo"]);
            $objCompraEstadoTipo->cargar();
            $obj->cargar($param['idcompraestado'], $objCompra, $objCompraEstadoTipo, $param["cefechaini"], $param["cefechafin"]);
        }
        return $obj;
    }

    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->cargar($param['idcompraestado'], null, null, null, null);
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
        if (isset($param['idcompraestado'])) {
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
        $param['idcompraestado'] = null;
        $objCompraEstado = $this->cargarObjeto($param);
        if ($objCompraEstado != null and $objCompraEstado->insertar()) {
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
            $objCompraEstado = $this->cargarObjetoConClave($param);
            if ($objCompraEstado != null and $objCompraEstado->eliminar()) {
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
            $objCompraEstado = $this->cargarObjeto($param);
            if ($objCompraEstado != null and $objCompraEstado->modificar()) {
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
            if (isset($param['idcompraestado'])) {
                $where .= " and idcompraestado =" . $param['idcompraestado'];
            }
            if (isset($param['idcompra'])) {
                $where .= " and idcompra =" . $param['idcompra'];
            }
            if (isset($param['idcompraestadotipo'])) {
                $where .= " and idcompraestadotipo =" . $param['idcompraestadotipo'];
            }
            if (isset($param['cefechaini'])) {
                $where .= " and cefechaini ='" . $param['cefechaini'] . "'";
            }
            if (isset($param['cefechafin'])) {
                $where .= " and cefechafin =" . $param['cefechafin'];
            }
        }
        $objCompraEstado = new CompraEstado();
        $arreglo = $objCompraEstado->listar($where);
        return $arreglo;
    }


    public function cambiarEstado($param)
    {
        $resp = false;

        $compraEstado = $this->buscar($param);
        if (count($compraEstado) >= 0) {
            $numeroEstado = count($compraEstado) - 1;
            $viejoIdEstadoTipo = intval($param['idcompraestadotipo']);
            $datosCompraEstadoAnterior = [
                'idcompraestado' => $compraEstado[$numeroEstado]->getidcompraestado(),
                'idcompra' => $param['idcompra'],
                'idcompraestadotipo' => $param['idcompraestadotipo'],
                'cefechaini' => $compraEstado[$numeroEstado]->getCeFechaIni(),
                'cefechafin' =>  date('Y-m-d H:i:s')
            ];
            $modEstadoAnterior = $this->modificacion($datosCompraEstadoAnterior);
            $nuevoIdEstadoTipo = $param['idcompraestadotipo'] + 1;
            $datosCompraEstadoActual = [
                'idcompra' => $param['idcompra'],
                'idcompraestadotipo' => $nuevoIdEstadoTipo,
                'cefechaini' => date('Y-m-d H:i:s'),
                'cefechafin' =>   date('0000-00-00 00:00:00')
            ];
            $modEstadoActual = $this->alta($datosCompraEstadoActual);
        }

        if ($modEstadoAnterior && $modEstadoActual) {
            $resp = true;
            $abmCompra = new abmCompra();
            $compra = $abmCompra->buscar(['idcompra' => $param['idcompra']])[0];
            $correoEnviar = $this->cambioEstadoMail($compra, $param['idcompraestadotipo']);

            if (!$correoEnviar) {
                $resp = false;
            }
        }

        return $resp;
    }


    public function cancelarCompra($param)
    {

        $resp = false;
        $compraEstado = $this->buscar($param);

        if (count($compraEstado) > 0) {
            $estadonumero = count($compraEstado) - 1;
            $datosCompraEstadoAnterior = [
                'idcompraestado' => $compraEstado[$estadonumero]->getidcompraestado(),
                'idcompra' => $param['idcompra'],
                'idcompraestadotipo' => $param['idcompraestadotipo'],
                'cefechaini' => $compraEstado[$estadonumero]->getCeFechaIni(),
                'cefechafin' => date('Y-m-d H:i:s')
            ];
            $this->modificacion($datosCompraEstadoAnterior);
            $datosCompraCancelar = [
                'idcompra' => $param['idcompra'],
                'idcompraestadotipo' => 4,
                'cefechaini' => date('Y-m-d H:i:s'),
                'cefechafin' => date('Y-m-d H:i:s')
            ];
            $resp = $this->alta($datosCompraCancelar);

            $abmCompraItem = new AbmCompraItem;
            $arrCompraItem = $abmCompraItem->buscar(['idcompra' => $param['idcompra']]);

            foreach ($arrCompraItem as $item) {
                $abmProducto = new AbmProducto;
                $idProducto["idproducto"] = $item->getObjProducto()->getIdProducto();
                $objProducto = $abmProducto->buscarProducto($idProducto)[0];
                var_dump($objProducto);
                var_dump($item->getCiCantidad());
                $datosProducto = [
                    'idproducto' => $objProducto->getIdProducto(),
                    'pronombre' => $objProducto->getProNombre(),
                    'prodetalle' => $objProducto->getProDetalle(),
                    'procantstock' => $objProducto->getProCantStock() + $item->getCiCantidad(),
                    'precio' => $objProducto->getPrecio(),
                ];
                $abmProducto->modificacion($datosProducto);
            }
        }

        return $resp;
    }



    /**
     * Lista todos los estados de compra.
     * @return array
     */
    public function listarCompraEstado()
    {
        $listaCompraEstado = $this->buscar(null);
        $arregloSalida = array();
        foreach ($listaCompraEstado as $elemento) {
            $nuevoElemento['idcompraestado'] = $elemento->getIdcompraestado();
            $nuevoElemento['idcompra'] = $elemento->getObjCompra()->getIdcompra();
            $nuevoElemento['idcompraestadotipo'] = $elemento->getObjCompraEstadoTipo()->getIdcompraestadotipo();
            $nuevoElemento['cetdescripcion'] = $elemento->getObjCompraEstadoTipo()->getCetdescripcion();
            $nuevoElemento['cefechaini'] = $elemento->getCefechaini();
            $nuevoElemento['cefechafin'] = $elemento->getCefechafin();
            $nuevoElemento['usnombre'] = $elemento->getObjCompra()->getObjUsuario()->getUsnombre();
            array_push($arregloSalida, $nuevoElemento);
        }
        return $arregloSalida;
    }

    /**
     * Avanza al siguiente estado de compra.
     * @param array $param
     * @return array
     */
    public function siguienteEstadoCompra($param)
    {
        $arreglo["idcompra"] = $param["idcompra"];
        $listaCompraEstadoConId = $this->buscar($arreglo);
        $compraCancelada = false;
        $i = 0;
        while (!$compraCancelada && $i < count($listaCompraEstadoConId)) {
            if ($listaCompraEstadoConId[$i]->getObjCompraEstadoTipo()->getIdcompraestadotipo() == 4) {
                $compraCancelada = true;
            } else {
                $i++;
            }
        }
        $arregloCompraEstado = $this->buscar(null);
        $compraAvanzada2 = false;
        $i = 0;
        while ((!$compraAvanzada2) && ($i < count($arregloCompraEstado))) {
            if (
                $arregloCompraEstado[$i]->getObjCompraEstadoTipo()->getIdcompraestadotipo() > $param["idcompraestadotipo"]
                && $arregloCompraEstado[$i]->getObjCompra()->getIdcompra() == $param["idcompra"]
            ) {
                $compraAvanzada2 = true;
            } else {
                $i++;
            }
        }

        if ($param["idcompraestadotipo"] < 3 && $param["idcompraestadotipo"] > 0) { // verifica que el id de compraestado tipo sea "iniciada" o "aceptada"
            if (!$compraCancelada) { // verifica que la compra no haya sido cancelada
                if (!$compraAvanzada2) { // verifica que la compra no haya sido avanzada
                    // Verificar si la compra tiene productos
                    $objAbmCompraItem = new AbmCompraItem();
                    $compraItems = $objAbmCompraItem->buscar(['idcompra' => $param['idcompra']]);
                    if (count($compraItems) == 0) {
                        // No hay productos en la compra, cambiar el estado a "cancelada"
                        $param['idcompraestadotipo'] = 4; // Suponiendo que 4 es el ID del estado "cancelada"
                        $param['cefechaini'] = date('Y-m-d H:i:s');
                        $param['cefechafin'] = null;
                        $this->cambiarEstado($param);
                        $respuesta["respuesta"] = "La compra ha sido cancelada porque no tiene productos.";
                    } else {
                        $fechaActual = date('Y-m-d H:i:s');
                        $param["cefechafin"] = $fechaActual;
                        if ($this->modificacion($param)) {
                            $param["idcompraestado"] = null;
                            $param["idcompraestadotipo"] = $param["idcompraestadotipo"] + 1;
                            $param["cefechaini"] = $fechaActual;
                            $param["cefechafin"] = null;
                            if ($this->alta($param)) {
                                $respuesta["respuesta"] = "Se cambió el estado de la compra correctamente";
                            } else {
                                $respuesta["errorMsg"] = "No se pudo cambiar el estado de la compra";
                            }
                        } else {
                            $respuesta["errorMsg"] = "No se pudo cambiar el estado de la compra";
                        }
                    }
                } else {
                    $respuesta["errorMsg"] = "La compra ya ha sido avanzada";
                }
            } else {
                $respuesta["errorMsg"] = "La compra ya ha sido cancelada";
            }
        } else {
            $respuesta["errorMsg"] = "No se puede pasar la compra al siguiente estado debido a que el estado 'enviada' o 'cancelada' es el último estado";
        }
        return $respuesta;
    }

    public function cambioEstadoMail($compra, $nuevoEstado)
    {
        $msjsEstados = [1 => 'iniciada', 2 => 'aceptada', 3 => 'enviada', 4 => 'cancelada'];
        $nombreEstado = $msjsEstados[$nuevoEstado];

        $mail = new Mail();
        $usuario = new Usuario();
        // $abmCompra = new abmCompra();

        $objSession = new Session();
        $usuario = $objSession->getUsuario();
        $destinatarioCorreo = $usuario->getUsMail();
        $nombreUsuario = $usuario->getUsNombre();
        $asunto = 'Elixir Patagonico - Cambio Estado de Compra #' . $compra->getIdCompra();

        $contenidoHtml = "<p>Estimado/a {$nombreUsuario},</p><p>El estado de tu compra #{$compra->getIdcompra()} ha sido actualizado a: <strong>{$nombreEstado}</strong>.</p>";
        $contenidoAlt = "Estimado/a {$nombreUsuario},\n\nEl estado de tu compra #{$compra->getIdcompra()} ha sido actualizado a: {$nombreEstado}.";

        $resultado = $mail->enviarCorreo($destinatarioCorreo, $nombreUsuario, $asunto, $contenidoHtml, $contenidoAlt);


        return $resultado['success'];
    }
}
