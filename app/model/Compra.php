<?php

class Compra
{
    private $idcompra;
    private $cofecha;
    private $objUsuario;
    private $metodo;
    private $mensajeoperacion;

    /**
     * Constructor de la clase Compra.
     * Inicializa los atributos de la clase.
     */
    public function __construct()
    {
        $this->idcompra = null;
        $this->cofecha = null;
        $this->objUsuario = new Usuario();
        $this->metodo = null;
        $this->mensajeoperacion = "";
    }

    /**
     * Setea los atributos de la clase Compra.
     * @param int $idcompraS
     * @param string|null $cofechaS
     * @param Usuario $objUsuarioS
     * @param string|null $metodoS
     */
    public function setear($idcompraS, $cofechaS, $objUsuarioS, $metodoS)
    {
        $this->setIdcompra($idcompraS);
        $this->setCofecha($cofechaS);
        $this->setObjUsuario($objUsuarioS);
        $this->setMetodo($metodoS);
    }

    public function getIdcompra()
    {
        return $this->idcompra;
    }
    public function setIdcompra($nuevoIdcompra)
    {
        $this->idcompra = $nuevoIdcompra;
    }

    public function getCofecha()
    {
        return $this->cofecha;
    }
    public function setCofecha($nuevoCofecha)
    {
        $this->cofecha = $nuevoCofecha;
    }

    public function getObjUsuario()
    {
        return $this->objUsuario;
    }
    public function setObjUsuario($nuevoObjUsuario)
    {
        $this->objUsuario = $nuevoObjUsuario;
    }

    public function getMetodo()
    {
        return $this->metodo;
    }
    public function setMetodo($nuevoMetodo)
    {
        $this->metodo = $nuevoMetodo;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($nuevomensajeoperacion)
    {
        $this->mensajeoperacion = $nuevomensajeoperacion;
    }

    /**
     * Carga los datos de una compra desde la base de datos.
     * @return boolean
     */
    public function cargar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdcompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objUsuario = new Usuario();
                    $objUsuario->setIdusuario($row["idusuario"]);
                    $objUsuario->cargar();
                    $this->setear($row["idcompra"], $row["cofecha"], $objUsuario, $row["metodo"]);
                    $respuesta = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Compra->listar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Inserta una nueva compra en la base de datos.
     * @return boolean
     */
    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        if ($this->getCofecha() == null) {
            $coFecha = "(NULL, ";
        } else {
            $coFecha = "('" . $this->getCofecha() . "', ";
        }
        $sql = "INSERT INTO compra (cofecha, idusuario, metodo) 
            VALUES " . $coFecha .
            $this->getObjUsuario()->getIdusuario() .
            ",'" . $this->getMetodo() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdcompra($elid);
                $respuesta = true;
            } else {
                $this->setmensajeoperacion("Compra->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->insertar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Modifica una compra existente en la base de datos.
     * @return boolean
     */
    public function modificar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        if ($this->getCofecha() == null) {
            $coFecha = " cofecha = NULL";
        } else {
            $coFecha = " cofecha = '" . $this->getCofecha() . "'";
        }
        $sql = "UPDATE compra 
            SET " . $coFecha .
            ", idusuario = " . $this->getObjUsuario()->getIdusuario() .
            ", metodo = '" . $this->getMetodo() .
            "' WHERE idcompra = " . $this->getIdcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setmensajeoperacion("Compra->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->modificar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Elimina una compra de la base de datos.
     * @return boolean
     */
    public function eliminar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra = " . $this->getIdcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $respuesta = true;
            } else {
                $this->setmensajeoperacion("Compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->eliminar: " . $base->getError());
        }
        return $respuesta;
    }

    /**
     * Lista las compras de la base de datos que cumplen con el parámetro dado.
     * @param string $parametro
     * @return array
     */
    public function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= "WHERE " . $parametro;
        }
        $respuesta = $base->Ejecutar($sql);
        if ($respuesta > -1) {
            if ($respuesta > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Compra();
                    $objUsuario = new Usuario();
                    $objUsuario->setIdusuario($row["idusuario"]);
                    $objUsuario->cargar();
                    $obj->setear($row["idcompra"], $row["cofecha"], $objUsuario, $row["metodo"]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("Compra->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
