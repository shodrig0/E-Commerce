<?php

class abmCompra
{

    public function abm($datos)
    {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables de instancia del objeto
     * @param array $param
     * @return Compra|null
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        // Validar que las claves necesarias existen en el arreglo

        if (array_key_exists('idcompra', $param) && array_key_exists('cofecha', $param) && array_key_exists('idusuario', $param)) {

            $obj = new Compra();
            $obj->setIdCompra($param['idcompra']);
            $obj->setCoFecha($param['cofecha']);
            $obj->setObjUsuario($param['idusuario']);

            // Intentar cargar el objeto desde la base de datos
            $obj->cargar();
        }

        return $obj;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return 
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompra'])) {
            $obj = new Compra();
            $obj->setidcompra($param['idcompra']);
            $obj->cargar();
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompra']))
            $resp = true;
        return $resp;
    }

    /**
     * Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idcompra'] = null;
        $obj = $this->cargarObjeto($param);

        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            $where .= '';
            if (isset($param['idcompra']))
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            if (isset($param['cofecha']))
                $where .= " and cofecha ='" . $param['cofecha'] . "'";
            if (isset($param['idusuario']))
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
        }
        $obj = new Compra();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function obtenerTotalCompra($compra)
    {
        $total = 0;
        $items = $compra->getItems();
        foreach ($items as $item) {
            $total += $item->getProducto()->getPrecio() * $item->getCiCantidad();
        }
        return $total;
    }

    public function obtenerCantItemsCompra($compra)
    {
        $items = $compra->getItems();
        $cantItems = 0;
        foreach ($items as $item) {
            $cantItems += $item->getCiCantidad();
        }
        return $cantItems;
    }


    /**
     * Da de alta una compra
     * @return bool
     */
    public function iniciarCompra()
    {
        $idcompra = null;
        $session = new Session();
        $usuario = $session->getUsuario();
        $idusuario = $usuario->getIdUsuario();

        $param['idusuario'] = $idusuario;
        $param["cofecha"] = date('Y-m-d H:i:s');

        $alta = $this->alta($param);
        if ($alta) {
            $compra = $this->buscar($param);
            if (count($compra) > 0) {
                $idcompra = $compra[0]->getIdCompra();
            }
        }
        return $idcompra;
    }


    /**
     * Confirmar Compra
     * @return int
     */
    public function realizarCompra()
    {
        $session = new Session;
        $band = false;
        $carrito = $session->getCarritoSession();
        if (count($carrito) > 0) {
            $idcompra = $this->iniciarCompra();

            $i = 0;
            $j = 0;
            do {
                $producto = $carrito[$i];
                $abmProducto = new AbmProducto();
                $objProducto = $abmProducto->buscarProducto(['idproducto' => $producto["idproducto"]])[0];

                $compraItem = new AbmCompraItem();

                $prodCompraItem['idproducto'] = $producto['idproducto'];
                $prodCompraItem['cicantidad'] = $producto['cantidadproducto'];
                $prodCompraItem['idcompra'] = $idcompra;
                if ($compraItem->alta($prodCompraItem)) {

                    $cantVieja = $objProducto->getProCantStock();

                    $cantNueva = $cantVieja - $prodCompraItem['cicantidad'];


                    $objProducto->setProCantStock($cantNueva);

                    $datosModProd = [
                        'idproducto' => $objProducto->getIdProducto(),
                        'pronombre' => $objProducto->getProNombre(),
                        'prodetalle' => $objProducto->getProDetalle(),
                        'procantstock' => $objProducto->getProCantStock(),
                        'precio' => $objProducto->getPrecio()
                    ];
                    $abmProducto->modificacion($datosModProd);
                    $j++;
                } else {
                    $band = true;
                }
                $i++;
            } while ($i < count($carrito) && $band == false);
            $compraExitosa = $this->verificacionCompraItems($j, $i, $idcompra);
        }

        if ($compraExitosa) {
            $abmEstadoCompra = new AbmCompraEstado();
            $estadoInit = 1;
            $compraEstadoDatos = [
                'idcompra' => $idcompra,
                'idcompraestadotipo' => $estadoInit,
                'cefechaini' => date('Y-m-d H:i:s'),
                'cefechafin' => null
            ];
            $abmEstadoCompra->alta($compraEstadoDatos);

            $compra = (new AbmCompra())->buscar(['idcompra' => $idcompra])[0];
            $estadoInicial = 'iniciada';

            $mail = new Mail();
            $usuario = $session->getUsuario();
            $destinatarioCorreo = $usuario->getUsMail();
            $nombreUsuario = $usuario->getUsNombre();

            $asunto = 'Elixir Patagonico - Confirmación de Compra #' . $compra->getIdCompra();

            $contenidoHtml = "<p>Estimado/a {$nombreUsuario},</p>
                              <p>Tu compra #{$compra->getIdcompra()} ha sido registrada exitosamente con el estado: <strong>{$estadoInicial}</strong>.</p>
                              <p>Gracias por confiar en nosotros.</p>";

            $contenidoAlt = "Estimado/a {$nombreUsuario},\n\nTu compra #{$compra->getIdcompra()} ha sido registrada exitosamente con el estado: {$estadoInicial}.\n\nGracias por confiar en nosotros.";

            $mail->enviarCorreo($destinatarioCorreo, $nombreUsuario, $asunto, $contenidoHtml, $contenidoAlt);
        }
        return $compraExitosa;
    }

    /**
     * Verifica la cantidad de productos en el carrito con su
     * @param int $j Cantidad de productos modificados
     * @param int $i Cantidad de productos en el carrito
     * @param int $idcompra Id de la compra
     * @return bool
     */
    private function verificacionCompraItems($j, $i, $idcompra)
    {
        $compraExitosa = false; // Inicializar la variable
        $altaCompraEstado = false;
        $session = new Session();
        if ($j == $i) {
            $datosCompraEstado = [
                "idcompra" => $idcompra,
                "idcompraestadotipo" => 1, // Compra tipo 1 = "Iniciada"
                "cefechaini" => date('Y-m-d H:i:s'),
                "cefechafin" => date('0000-00-00 00:00:00') //el valor anterior era null
            ];
            $abmCompraEstado = new AbmCompraEstado();
            $altaCompraEstado = $abmCompraEstado->alta($datosCompraEstado);
            if ($altaCompraEstado) {
                $compraExitosa = true;
                /* Vacio el carrito */
                $carrito = [];
                $session->setCarritoSession($carrito);
            }
        } else if ($j < $i || $altaCompraEstado == false) {
            $abmCompraItem = new AbmCompraItem();
            $arrCompraItems = $abmCompraItem->buscar(["idcompra" => $idcompra]);
            foreach ($arrCompraItems as $compraItem) {
                $compraItem->baja(["idcompraitem" => $compraItem->getIdCompraItem()]);
            }
            $compraExitosa = false;
        }

        return $compraExitosa;
    }

    function listarCompras($session)
    {
        $arrayRol = $session->getRol();
        $idRol = $arrayRol[0]['idrol'];

        if ($idRol == 3 || $idRol == 1) {

            $arrayCompras = $this->buscar("");
        } else {
            $param['idusuario'] = $session->getUsuario()->getIdUsuario();
            $arrayCompras = $this->buscar($param);
        }
        return $arrayCompras;
    }
}
