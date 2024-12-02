<?php

class AbmMenuRol
{

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idmenu', $param) and array_key_exists('idrol', $param)) {
            $obj = new MenuRol();
            $objMenu = new Menu();
            $objMenu->setIdmenu($param["idmenu"]);
            $objMenu->cargar();
            $objRol = new Rol();
            $objRol->setIdrol($param["idrol"]);
            $objRol->cargar();
            $obj->setear($objMenu, $objRol);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $obj = new MenuRol();
            $objMenu = new Menu();
            $objMenu->setIdmenu($param["idmenu"]);
            $objMenu->cargar();
            $objRol = new Rol();
            $objRol->setIdrol($param["idrol"]);
            $objRol->cargar();
            $obj->setear($objMenu, $objRol);
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
        if (isset($param['idmenu']) and isset($param["idrol"])) {
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
        //$param['Patente'] = null;
        $objMenuRol = $this->cargarObjeto($param);
        // verEstructura($objAuto);
        if ($objMenuRol != null and $objMenuRol->insertar()) {
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
            $objMenuRol = $this->cargarObjetoConClave($param);
            if ($objMenuRol != null and $objMenuRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }
    // duda sobre si se puede modificar
    /**
     * Permite modificar un objeto.
     * @param array $param
     * @return boolean
     */
    /*
        public function modificacion($param){
            $resp = false;
            if ($this -> seteadosCamposClaves($param)) {
                $objRol = $this -> cargarObjeto($param);
                if ($objRol != null and $objRol -> modificar()) {
                    $resp = true;
                }
            }
            return $resp;
        }
        */

    /**
     * Permite buscar un objeto.
     * @param array $param
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idmenu'])) {
                $where .= " and idmenu =" . $param['idmenu'];
            }
            if (isset($param['idrol'])) {
                $where .= " and idrol =" . $param['idrol'];
            }
        }
        $objMenuRol = new MenuRol();
        $arreglo = $objMenuRol->listar($where);
        if (!is_array($arreglo)) {
            return [];
        }
        return $arreglo;
    }

    public function crearMenuRol($param)
    {
        $objAbmMenu = new AbmMenu();
        $objAbmRol = new AbmRol();
        $arreglo1["idmenu"] = $param["idmenu"];
        $arreglo2["idrol"] = $param["idrol"];
        if ($objAbmMenu->buscar($arreglo1)) {
            if ($objAbmRol->buscar($arreglo2)) {
                if ($this->buscar($param)) {
                    $respuesta["errorMsg"] = "Ya existe un MenuRol con ese idmenu e idrol";
                } else {
                    if ($this->alta($param)) {
                        $respuesta["respuesta"] = "Se dio de alta el MenuRol correctamente";
                    } else {
                        $respuesta["errorMsg"] = "No se pudo realizar el alta del MenuRol";
                    }
                }
            } else {
                $respuesta["errorMsg"] = "No existe un Rol con el idrol ingresado";
            }
        } else {
            $respuesta["errorMsg"] = "No existe un Menú con el idmenu ingresado";
        }
        return $respuesta;
    }

    public function listarMenuRoles()
    {
        $listaMenuRoles = $this->buscar(null);
        $arregloSalida = array();
        foreach ($listaMenuRoles as $elemento) {
            $nuevoElemento['idmenu'] = $elemento->getObjMenu()->getIdmenu();
            $nuevoElemento['menombre'] = $elemento->getObjMenu()->getMenombre();
            $nuevoElemento['idrol'] = $elemento->getObjRol()->getIdrol();
            $nuevoElemento['rodescripcion'] = $elemento->getObjRol()->getRodescripcion();
            array_push($arregloSalida, $nuevoElemento);
        }
        return $arregloSalida;
    }
}
