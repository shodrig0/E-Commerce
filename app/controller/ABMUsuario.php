<?php
class ABMUsuario
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
        if ($datos['accion'] == 'quitar_rol') {
            if ($this->quitar_rol($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'asignar_rol') {
            if ($this->asignar_rol($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idusuario', $param)  and array_key_exists('usnombre', $param) and array_key_exists('uspass', $param)
            and array_key_exists('usmail', $param) and array_key_exists('usdeshabilitado', $param)
        ) {
            $obj = new Usuario();
            $obj->cargar($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            $obj = new Usuario();
            $obj->cargar($param['idusuario'], null, null, null, null);
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
        if (isset($param['idusuario']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $param['idusuario'] = null;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function quitar_rol($param)
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new UsuarioRol();
            $rol = new Rol();
            $rol->setIdRol($param['idrol']);
            $elObjtTabla->setRol($rol);
            $usuario = new Usuario();
            $usuario->setIdUsuario($param['idusuario']);
            $elObjtTabla->setUsuario($usuario);
            $resp = $elObjtTabla->eliminar();
        }

        return $resp;
    }

    public function asignar_rol($param)
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new UsuarioRol();
            $rol = new Rol();
            $rol->setIdRol($param['idrol']);
            $elObjtTabla->setRol($rol);
            $usuario = new Usuario();
            $usuario->setIdUsuario($param['idusuario']);
            $elObjtTabla->setUsuario($usuario);
            $resp = $elObjtTabla->insertar();
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
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
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
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Devuelve un arreglo de objetos rol del idusuario pasado por parametro. como arreglo asociativo
     */
    public function darRoles($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['idrol']))
                $where .= " and idrol ='" . $param['idrol'] . "'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);

        $arreglo_obj_roles = array();
        foreach ($arreglo as $obj) {
            $rol = new Rol();
            $rol->setIdRol($obj->getRol()->getIdRol());
            $rol->buscar();
            array_push($arreglo_obj_roles, $rol);
        }

        return $arreglo_obj_roles;
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
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['usnombre']))
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            if (isset($param['usmail']))
                $where .= " and usmail ='" . $param['usmail'] . "'";
            if (isset($param['uspass']))
                $where .= " and uspass ='" . $param['uspass'] . "'";
            if (isset($param['usdeshabilitado']))
                $where .= " and usdeshabilitado is null";
        }
        $obj = new Usuario();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }



    /**
     * Crea un usuario, le setea el rol default y devuelve un array asociativo con el mensaje
     * @param string $usNombre
     * @param string $usPass
     * @param string $usMail
     * @return array
     */
    public function agregarNuevoUsuario($usNombre, $usPass, $usMail)
    {
        $salida = [];
        $param['usnombre'] = $usNombre;
        if (empty($this->buscar($param))) {
            try {
                $usuario = new Usuario();
                $usuario->setUsNombre($usNombre);
                //Encripto la password       
                $usuario->setUsPass(Hash::encriptar_hash($usPass));
                $usuario->setUsMail($usMail);



                if ($usuario->insertar()) {
                    $abmUsuarioRol = new AbmUsuarioRol();
                    $abmUsuarioRol->setearRolDefault($usuario->getIdUsuario());
                    $salida["mensaje"] = "Usuario registrado correctamente.";
                }
            } catch (PDOException $e) {
                $salida["mensaje"] = "Error al registrar el usuario: " . $e->getMessage();
                $salida["error"] = true;
            }
        } else {
            $salida["mensaje"] = "El usuario ya esta registrado.";
            $salida["error"] = true;
        }
        return $salida;
    }


    /**
     * Modifica la contraseña del usuario en la sesion actual
     */
    public function modificarPassword($usPass)
    {
        $session = new Session();
        $usuario = $session->getUsuario();
        $salida = [];
        if ($session->validar()) {
            $usuario->setUsPass(Hash::encriptar_hash($usPass));
            $usuario->modificar();
            $salida["mensaje"] = "Contraseña modificada correctamente.";
            $salida["error"] = false;
        } else {
            $salida["mensaje"] = "Error al modificar la contraseña.";
            $salida["error"] = true;
        }
        return $salida;
    }


    public function modificarEmail($email)
    {
        $session = new Session();
        $usuario = $session->getUsuario();
        $salida = [];
        if ($session->validar()) {
            $usuario->setUsMail($email);
            $usuario->modificar();
            $salida["mensaje"] = "Email modificado correctamente.";
            $salida["error"] = false;
        } else {
            $salida["mensaje"] = "Error al modificar el email.";
            $salida["error"] = true;
        }
        return $salida;
    }


    public function cargarComprasUser()
    {
        $session = new Session();
        $salida = [];
        $compra = new abmCompra();

        if ($session->validar()) {
            $usuario = $session->getUsuario();
            $arr['idusuario'] =  $usuario->getIdUsuario();
            $salida =  $compra->buscar($arr);
        }
        return $salida;
    }

    /**Devuelve un arreglo de compras que tienen estadotipo 0 
     * y tienen fecha fin null de ese estado, (encarrito) */
    public function cargarCarritoUser()
    {

        $session = new Session();
        $idUser  = $session->getUsuario()->getIdUsuario();
        $estado_en_carrito = [];
        /*Obtengo desde la bd mediante una consulta las 
        compras que tienen estadotipo 0 y 
        tienen fecha fin null de ese estado
        y tienen idusuario actual*/
        $bd = new BaseDatos();
        $sql = "SELECT * FROM compra c INNER JOIN compraestado ce ON c.idcompra = ce.idcompra WHERE ce.idcompraestadotipo = 0 AND ce.cefechafin IS NULL AND c.idusuario = " . $idUser;
        $res = $bd->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $bd->Registro()) {
                    $obj = new Compra();
                    $obj->setIdCompra($row['idcompra']);
                    $obj->buscar();
                    array_push($estado_en_carrito, $obj);
                }
            }
        }
        return $estado_en_carrito;
    }
}
