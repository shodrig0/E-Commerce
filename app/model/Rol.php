<?php

class Rol
{

    private $idRol;
    private $roDescripcion;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idRol = 0;
        $this->roDescripcion = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idRol, $roDescripcion)
    {
        $this->setIdRol($idRol);
        $this->setRoDescripcion($roDescripcion);
    }

    public function getIdRol()
    {
        return $this->idRol;
    }

    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;
    }

    public function getRoDescripcion()
    {
        return $this->roDescripcion;
    }

    public function setRoDescripcion($roDescripcion)
    {
        $this->roDescripcion = $roDescripcion;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol WHERE idrol = " . $this->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->cargar($row['idrol'], $row['rodescripcion']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Rol->buscar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $sql = "INSERT INTO rol (rodescripcion)
            VALUES ('" . $this->getRoDescripcion() . "')";

        if ($base->Iniciar()) {
            $idRol = $base->Ejecutar($sql);
            if ($idRol > -1) {
                $this->setIdRol($idRol);
                $resp = ["idRol" => $idRol, "status" => true];
            }
        } else {
            $this->setMensajeOperacion("Rol->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE rol SET rodescripcion = '" . $this->getRoDescripcion() . "' WHERE idrol = " . $this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM rol WHERE idrol = " . $this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol";
        if ($parametro != "") {
            $sql .= ' WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Rol();
                    $obj->cargar($row['idrol'], $row['rodescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los roles: " . $base->getError());
        }
        return $arreglo;
    }

    public function jsonSerialize()
    {
        return [
            'idRol' => $this->getIdRol(),
            'roDescripcion' => $this->getRoDescripcion()
        ];
    }
}
