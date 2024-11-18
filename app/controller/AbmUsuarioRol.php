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

    public function buscarUsuarioRol($cond = "")
    {
        if ($cond != "") {
            $idUsuario = $cond;
        } else {
            $usuarioRolModelo = $this->obtenerDatosUsuarioRol();
            $idUsuario = $usuarioRolModelo['idusuario'];
        }
        $objUsuarioRol = null;
        if ($idUsuario) {
            try {
                $colUsuario = UsuarioRol::listar("idusuario = '" . $idUsuario . "'");
                if (!empty($colUsuario)) {
                    $objUsuarioRol = $colUsuario;
                }
            } catch (PDOException $e) {
                $this->setMsjError('Error conexion bdd: ' . $e->getMessage());
            }
        }
        return $objUsuarioRol;
    }
    public function eliminarUsuarioRol() {
        $resp = false;
        $datos = darDatosSubmitted();
        $objUsuario = new Usuario();
        $objUsuario->cargar($datos['idUsuario'], null, null, null, null, []);
        $objUsuario->buscar();

        $objRol = new Rol();
        $objRol->cargar($datos['idRol'], null);
        $objRol->buscar();

        $objUsuarioRol = new UsuarioRol();
        $objUsuarioRol->cargar($objUsuario, $objRol);
        if ($objUsuarioRol->buscar()) {
            try {
                $resp = true;
                $objUsuarioRol->eliminar();
            } catch (PDOException $e) {
                $this->setMsjError('Error conexion bdd: ' . $e->getMessage());
            }
        }
        return $resp;
    }

    public function agregarUsuarioRol() {}

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
        $rolCliente = $abmRol->obtenerRolCliente();
        var_dump($rolCliente);
        $param['idrol'] = $rolCliente->getIdRol();

        $obj = $this->cargarObjeto($param);
        if ($obj !== null && $obj->getUsuario()->getIdUsuario() !== null && $obj->getRol()->getIdRol() !== null && $obj->insertar()) {
            $salida = true;
        }
        return $salida;
    }

    private function cargarObjeto($param)
    {
        $obj = null;

        if (isset($param['idrol']) && isset($param['idusuario'])) {
            $obj = new UsuarioRol();
            $usuario = new Usuario();
            $usuario->setIdUsuario($param['idusuario']);

            $rol = new Rol();
            $rol->setIdRol($param['idrol']);
            $obj->cargar($usuario, $rol);
        }

        return $obj;
    }
}
