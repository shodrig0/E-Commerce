<?php
class UsuarioRol
{

    private Usuario $usuario;
    private Rol $rol;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->mensajeOperacion = "";
    }

    public function cargar($usuario, $rol)
    {
        $this->setUsuario($usuario);
        $this->setRol($rol);
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getUsuario()->getIdUsuario() . " AND idrol = " . $this->getRol()->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $usr = new Usuario();
                    $usr->setIdUsuario($row['idusuario']);
                    $rol = new Rol();
                    $rol->setIdRol($row['idrol']);
                    $this->cargar($usr, $rol);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("usuariorol->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol (idusuario, idrol)
        VALUES ('"
            . $this->getUsuario()->getIdUsuario() . "', '"
            . $this->getRol()->getIdRol() .
            "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                // $this->setIdUsuario($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("usuariorol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->insertar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuariorol SET idusuario='" . $this->getUsuario()->getIdUsuario() . "', idrol='" . $this->getRol()->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario=" . $this->getUsuario()->getIdUsuario() . " AND idrol=" . $this->getRol()->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new UsuarioRol();
                    $usr = new Usuario();
                    $usr->setIdUsuario($row['idusuario']);
                    $usr->buscar();
                    $rol = new Rol();
                    $rol->setIdRol($row['idrol']);
                    $rol->buscar();
                    $obj->cargar($usr, $rol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los usuarioRol: " . $base->getError());
        }

        return $arreglo;
    }

    public function jsonSerialize()
    {
        if ($this->getUsuario() != null) {
            $usuario = $this->getUsuario()->jsonSerialize();
        } else {
            $usuario = null;
        }

        if ($this->getRol() != null) {
            $rol = $this->getRol()->jsonSerialize();
        } else {
            $rol = null;
        }


        return [
            'usuario' => $usuario,
            'rol' => $rol,
        ];
    }
}
