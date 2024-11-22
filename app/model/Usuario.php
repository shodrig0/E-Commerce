<?php
require_once __DIR__ . '/connection/BaseDatos.php';
class Usuario
{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private array $roles = [];
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idUsuario = "";
        $this->usNombre = "";
        $this->usPass = "";
        $this->usMail = "";
        $this->roles = array();
        $this->usDeshabilitado = "";
    }


    public function setear($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado, $roles = [])
    {
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
        $this->setRoles($roles);
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getUsNombre()
    {
        return $this->usNombre;
    }

    public function setUsNombre($usNombre)
    {
        $this->usNombre = $usNombre;
    }

    public function getUsPass()
    {
        return $this->usPass;
    }

    public function setUsPass($usPass)
    {
        $this->usPass = $usPass;
    }

    public function getUsMail()
    {
        return $this->usMail;
    }

    public function setUsMail($usMail)
    {
        $this->usMail = $usMail;
    }

    public function getUsDeshabilitado()
    {
        return $this->usDeshabilitado;
    }

    public function setUsDeshabilitado($usDeshabilitado)
    {
        $this->usDeshabilitado = $usDeshabilitado;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getIdusuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row["idusuario"], $row["usnombre"], $row["uspass"], $row["usmail"], $row["usdeshabilitado"]);
                    $respuesta = true;
                }
            }
        } else {
            $this->setmensajeoperacion("usuario->listar: " . $base->getError());
        }
        return $respuesta;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setIdUsuario($row['idusuario']);
                    $this->setUsNombre($row['usnombre']);
                    $this->setUsPass($row['uspass']);
                    $this->setUsMail($row['usmail']);
                    $this->setUsDeshabilitado($row['usdeshabilitado']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Usuario->buscar: " . $base->getError());
        }
        return $resp;
    }


    public static function listar($condicion = "")
    {
        $arregloUsuarios = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        // var_dump($condicion);
        if (is_array($condicion)) {
            $condicion = implode(" AND ", $condicion);
        }
        if ($condicion != ""){
            $sql .= " WHERE $condicion";
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Usuario();
                    $roles = UsuarioRol::listar("idusuario = " . $row['idusuario']);
                    $obj->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado'], $roles);
                    array_push($arregloUsuarios, $obj);
                }
            }
        } else {
            throw new Exception("Usuario->listar: " . $base->getError());
        }
        return $arregloUsuarios;
    }


    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario(usnombre, uspass, usmail) VALUES('" . $this->getUsNombre() . "','" . $this->getUsPass() . "','" . $this->getUsMail() . "')";
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $id = $base->getLastInsertId();
                if ($id) {
                    $this->setIdUsuario($id); // Asignar el ID al objeto
                    $resp = true;
                } else {
                    $this->setMensajeOperacion("Usuario->insertar: Error al obtener el ID insertado.");
                }
            } else {
                $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }
        
        return $resp;
    }
    


    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $usDeshabilitado = $this->getUsDeshabilitado() != null ? "'" . $this->getUsDeshabilitado() . "'" : "NULL";
        $sql = "UPDATE usuario SET usnombre = '" . $this->getUsNombre() . "', uspass = '" . $this->getUsPass() . "', usmail = '" . $this->getUsMail() . "', usdeshabilitado = " . $usDeshabilitado . " WHERE idusuario = " . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
        }
        return $resp;
    }


    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario = " . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function habilitar()
    {
        $db = new BaseDatos();
        $resp = false;
    
        $sql = "UPDATE usuario SET usdeshabilitado = NULL WHERE idusuario = " . $this->getIdUsuario();
    
        if ($db->Ejecutar($sql) >= 0) {
            $resp = true;
        }
        return $resp;
    }

    public function deshabilitar()
    {
        $db = new BaseDatos();
        $resp = false;
        $sql = "UPDATE usuario SET usdeshabilitado = CURRENT_TIMESTAMP WHERE idusuario = " . $this->getIdUsuario();

        if ($db->Ejecutar($sql) >= 0) {
            $resp = true;
        }

        return $resp;
    }

    public function serializeRoles()
    {
        $roles = array();
        foreach ($this->getRoles() as $rol) {

            array_push($roles, $rol->jsonSerialize());
        }
        return $roles;
    }


    public function jsonSerialize()
    {
        //Serializo lo que necesito solamente.
        $roles = $this->serializeRoles();

        return [
            'idUsuario' => $this->getIdUsuario(),
            'usNombre' => $this->getUsNombre(),
            'usMail' => $this->getUsMail(),
            'roles' => $roles,
            'usDeshabilitado' => $this->getUsDeshabilitado()
        ];
    }
}
