<?php

class AbmUsuarioRol
{
    private $msjError;

    public function __construct() {}

    public function getMsjError()
    {
        return $this->msjError;
    }

    public function setMsjError($msjError)
    {
        $this->msjError = $msjError;
    }

    public function cargarObjeto($arreglo){
        $obj = null;
        if (array_key_exists('idusuario', $arreglo) and array_key_exists('idrol', $arreglo)) {
            $objusuario = new Usuario();
            $objusuario->setIdUsuario($arreglo['idusuario']);
            $objusuario->cargar($arreglo['idusuario'], $arreglo['usnombre'], $arreglo['uspass'], $arreglo['usmail'], $arreglo['usdeshabilitado'], $arreglo['idrol']);

            $objrol = new Rol();
            $objrol->cargar($arreglo['idrol'], $arreglo['rodescripcion']);

            $obj = new UsuarioRol();
            $obj->cargar($objusuario, $objrol);
        }
        return $obj;
    }

    public function buscarUsuarioRol()
    {
        $objUsuarioRol = null;

        $usuarioRolModelo = $this->obtenerDatosUsuarioRol();
        $idUsuario = $usuarioRolModelo['idusuario'];

        if ($idUsuario) {
            try {
                $colUsuario = Usuario::listar("idusuario = '" . $idUsuario . "'");
                if (!empty($colUsuario)) {
                    $objUsuarioRol = $colUsuario[0];
                }
            } catch (PDOException $e) {
                $this->setMsjError('Error conexion bdd: ' . $e->getMessage());
            }
        }
        return $objUsuarioRol;
    }

    public function agregarUsuarioRol($param) {
        $resp = false;
        //Creo objeto con los datos
        $obj = $this->cargarObjeto($param);
        //Verifico que el objeto no sea nulo y lo inserto en BD 
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    private function obtenerDatosUsuarioRol()
    {
        $datos = darDatosSubmitted();

        return [
            'idusuario' => $datos['idusuario'] ?? null,
            'idrol' => $datos['idrol'] ?? null
        ];
    }

    public function setearRolDefault($idUsuario)
    {
        $salida = false;
        $param['idusuario'] = $idUsuario;
        $abmRol = new AbmRol();
        $rolCliente = $abmRol->obtenerRolAlumno();
        $param['idrol'] = $rolCliente->getIdRol();

        $obj = $this->cargarObjeto($param);
        if ($obj !== null && $obj->getUsuario()->getIdUsuario() !== null && $obj->getRol()->getIdRol() !== null && $obj->insertar()) {
            $salida = true;
        }
        return $salida;
    }

    // private function cargarObjeto($param)
    // {
    //     $obj = null;

    //     if (isset($param['idrol']) && isset($param['idusuario'])) {
    //         $obj = new UsuarioRol();
    //         $usuario = new Usuario();
    //         $usuario->setIdUsuario($param['idusuario']);

    //         $rol = new Rol();
    //         $rol->setIdRol($param['idrol']);
    //         $obj->cargar($usuario, $rol);
    //     }

    //     return $obj;
    // }
}
