<?php

class CompraEstado
{

    private $idCompraEstado;
    private Compra $compra;
    private CompraEstadoTipo $compraEstadoTipo;
    private $ceFechaIni;
    private $ceFechaFin;
    private $mensajeoperacion;

    public function __construct()
    {

        $this->idCompraEstado = "";
        $this->compra = new Compra();
        $this->compraEstadoTipo = new CompraEstadoTipo();
        $this->ceFechaIni = "";
        $this->ceFechaFin = "";
        $this->mensajeoperacion = "";

    }

    public function cargar($idCompraEstado, $compra, $compraEstadoTipo, $ceFechaIni, $ceFechaFin)
    {
        $this->setIdCompraEstado($idCompraEstado);
        $this->setCompra($compra);
        $this->setCompraEstadoTipo($compraEstadoTipo);
        $this->setCeFechaIni($ceFechaIni);
        $this->setCeFechaFin($ceFechaFin);
    }

    //setters

    public function setIdCompraEstado($idCompraEstado)
    {
        $this->idCompraEstado = $idCompraEstado;
    }

    public function setCompra($compra)
    {
        $this->compra = $compra;
    }

    public function setCompraEstadoTipo($compraEstadoTipo)
    {
        $this->compraEstadoTipo = $compraEstadoTipo;
    }

    public function setCeFechaIni($ceFechaIni)
    {
        $this->ceFechaIni = $ceFechaIni;
    }

    public function setCeFechaFin($ceFechaFin)
    {
        $this->ceFechaFin = $ceFechaFin;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //getters

    public function getIdCompraEstado()
    {
        return $this->idCompraEstado;
    }

    public function getCompra()
    {
        return $this->compra;
    }

    public function getCompraEstadoTipo()
    {
        return $this->compraEstadoTipo;
    }

    public function getCeFechaIni()
    {
        return $this->ceFechaIni;
    }

    public function getCeFechaFin()
    {
        return $this->ceFechaFin;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = " . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $compra = new Compra();
                    $compra->setIdCompra($row['idcompra']);
                    $compraEstadoTipo = new CompraEstadoTipo();
                    $compraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $this->cargar($row['idcompraestado'], $compra, $compraEstadoTipo, $row['cefechaini'], $row['cefechafin']);

                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->listar: " . $base->getError());
        }
        return $resp;


    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $sql = "INSERT INTO compraestado ( idcompra, idcompraestadotipo, cefechaini, cefechafin)
				VALUES ('" . $this->getCompra()->getIdCompra() . "','" . $this->getCompraEstadoTipo()->getIdCompraEstadoTipo() . "', '" . $this->getCeFechaIni() . "', '".$this->getCeFechaFin()."')";

        if ($base->Iniciar()) {
            $idUser = $base->Ejecutar($sql);
            if ($idUser > -1) {
                $this->setIdCompraEstado($idUser);
                $resp = true;
            }

        } else {
            $this->setMensajeOperacion("CompraEstado->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestado SET idcompra='" . $this->getCompra()->getIdCompra() . "', idcompraestadotipo='" . $this->getCompraEstadoTipo()->getIdCompraEstadoTipo() . "', 
        cefechaini='" . $this->getCeFechaIni() . "', cefechafin='" . $this->getCeFechaFin() .
            "'  WHERE idcompraestado=" . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestado WHERE idcompraestado=" . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("CompraEstado->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new CompraEstado();
                    $compra = new Compra();
                    $compra->setIdCompra($row['idcompra']);
                    //$compra->buscar();
                    $compraEstadoTipo = new CompraEstadoTipo();
                    $compraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $compraEstadoTipo->cargar();
                    $obj->cargar($row['idcompraestado'], $compra, $compraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }

            }

        } else {
            throw new Exception("Error al listar los compraEstado: " . $base->getError());
        }

        return $arreglo;
    }

    
}