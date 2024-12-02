<?php

class AbmMenu {

    public function __construct(){

    }

    public function obtenerMenu()
    {
        $objMenu = new Menu();
        $resultado = [];
        try {
            $resultado = $objMenu->ordenMenu();
        } catch (PDOException $e) {
            throw new PDOException('Error: ' . $e->getMessage());
        }
        return $resultado; 
    }

        /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idmenu', $param) and array_key_exists('menombre', $param) and array_key_exists('medescripcion', $param) and array_key_exists('idpadre', $param) and array_key_exists('medeshabilitado', $param)) {
            $obj = new Menu();
            $objMenuPadre = new Menu();
            $objMenuPadre->setIdmenu($param["idpadre"]);
            $objMenuPadre->cargar();
            $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objMenuPadre, $param["medeshabilitado"]);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idmenu'])) {
            $obj = new Menu();
            $obj->setear($param['idmenu'], null, null, null, null);
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
        if (isset($param['idmenu'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Permite crear un objeto.
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idmenu'] = null;
        $objMenu = $this->cargarObjeto($param);
        if ($objMenu != null and $objMenu->insertar()) {
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
            $objMenu = $this->cargarObjetoConClave($param);
            if ($objMenu != null and $objMenu->cambiarEstado()) {
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
            $objMenu = $this->cargarObjeto($param);
            if ($objMenu != null and $objMenu->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Permite buscar un objeto.
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idmenu'])) {
                $where .= " and idmenu =" . $param['idmenu'];
            }
            if (isset($param['menombre'])) {
                $where .= " and menombre ='" . $param['menombre'] . "'";
            }
            if (isset($param['medescripcion'])) {
                $where .= " and medescripcion ='" . $param['medescripcion'] . "'";
            }
            if (isset($param['idpadre'])) {
                $where .= " and idpadre =" . $param['idpadre'];
            }
            if (isset($param['medeshabilitado'])) {
                $where .= " and medeshabilitado ='" . $param['medeshabilitado'] . "'";
            }
        }
        $objMenu = new Menu();
        $arreglo = $objMenu->listar($where);
        return $arreglo;
    }

    public function crearMenu($param)
    {
        $arreglo["idmenu"] = $param["idpadre"];
        $param["medeshabilitado"] = null;
        if ($this->buscar($arreglo)) {
            if ($this->alta($param)) {
                $respuesta["respuesta"] = "Se dio de alta el Menú correctamente";
            } else {
                $respuesta["errorMsg"] = "No se pudo realizar el alta del Menú";
            }
        } else {
            $respuesta["errorMsg"] = "No existe un Menú con el idpadre ingresado";
        }
        return $respuesta;
    }

    public function editarMenues($param)
    {
        $arreglo["idmenu"] = $param["idmenu"];
        $listaMenues = $this->buscar($arreglo);
        $param["medeshabilitado"] = $listaMenues[0]->getMedeshabilitado();
        $arreglo1["idmenu"] = $param["idpadre"];
        if ($this->buscar($arreglo1)) {
            if ($this->modificacion($param)) {
                $respuesta["respuesta"] = "Se modificó el Menú correctamente";
            } else {
                $respuesta["errorMsg"] = "No se pudo modificar el Menú";
            }
        } else {
            $respuesta["errorMsg"] = "No existe un Menú con el idpadre ingresado";
        }
        return $respuesta;
    }

    public function listarMenues()
    {
        $listaMenues = $this->buscar(null);
        $arregloSalida = array();
        if (is_array($listaMenues)) {
            foreach ($listaMenues as $elemento) {
            $nuevoElemento['idmenu'] = $elemento->getIdmenu();
            $nuevoElemento['menombre'] = $elemento->getMenombre();
            $nuevoElemento['medescripcion'] = $elemento->getMedescripcion();
            if ($elemento->getObjMenu() != NULL) {
                $nuevoElemento['idpadre'] = $elemento->getObjMenu()->getIdmenu();
            } else {
                $nuevoElemento['idpadre'] = NULL;
            }
            if ($elemento->getMedeshabilitado() == null || $elemento->getMedeshabilitado() == "0000-00-00 00:00:00") {
                $nuevoElemento['medeshabilitado'] = "Habilitado";
            } else {
                $nuevoElemento['medeshabilitado'] = "Deshabilitado (" . $elemento->getMedeshabilitado() . ")";
            }
            array_push($arregloSalida, $nuevoElemento);
            }
        }
        return $arregloSalida;
        return $arregloSalida;
    }
}