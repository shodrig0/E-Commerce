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
        $sql = "INSERT INTO compraestado ( idcompra, idcompraestadotipo, cefechaini)
				VALUES ('" . $this->getCompra()->getIdCompra() . "','" . $this->getCompraEstadoTipo()->getIdCompraEstadoTipo() . "', '" . $this->getCeFechaIni() . "')";

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
                    $compraEstadoTipo->buscar();
                    $obj->cargar($row['idcompraestado'], $compra, $compraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los compraEstado: " . $base->getError());
        }

        return $arreglo;
    }






    /**
     * Devuelve un arreglo de compras que poseen ese estado enviado por parametro como estado actual.
     */
    public static function obtenerComprasPorEstado($estado_code)
    {
        $arr_compras = [];
        $bd = new BaseDatos();
        $sql = "SELECT * FROM compraestado ce, compra c WHERE ce.idcompra = c.idcompra AND ce.idcompraestadotipo = $estado_code AND ce.cefechafin IS NULL";

        $res = $bd->Ejecutar($sql);
        if ($res > 0) {
            while ($row = $bd->Registro()) {
                $obj = new Compra();
                $usr = new Usuario();
                $usr->setIdUsuario($row['idusuario']);
                $usr->buscar();
                $items = CompraItem::listar("idcompra = " . $row['idcompra']);
                $estados = CompraEstado::listar("idcompra = " . $row['idcompra']);
                $obj->cargar($row['idcompra'], $row['cofecha'], $usr, $items, $estados);
                array_push($arr_compras, $obj);
            }
        }

        return $arr_compras;
    }


    public static function obtenerComprasPorEstadoSerializadas($estado_code)
    {
        $arr_compras = [];
        $bd = new BaseDatos();
        $sql = "SELECT * FROM compraestado ce, compra c WHERE ce.idcompra = c.idcompra AND ce.idcompraestadotipo = $estado_code AND ce.cefechafin IS NULL";

        $res = $bd->Ejecutar($sql);
        $compra = [];
        if ($res > 0) {
            while ($row = $bd->Registro()) {

                $usr = new Usuario();
                $usr->setIdUsuario($row['idusuario']);
                $usr->buscar();
                $compra['idcompra'] = $row['idcompra'];
                $compra['usuario'] = $usr->getUsNombre();
                $compra['items'] = CompraEstado::obtenerCantidadItems($row['idcompra']);
                $estados = CompraEstado::listar("idcompra = " . $row['idcompra'] . " AND cefechafin IS NULL");
                $compra['estado'] = array('id' => $estados[0]->getCompraEstadoTipo()->getIdCompraEstadoTipo(), 'descripcion' => $estados[0]->getCompraEstadoTipo()->getCetDescripcion());
                // $obj->cargar($row['idcompra'], $row['cofecha'], $usr, $items, $estados);
                array_push($arr_compras, $compra);
            }
        }

        return $arr_compras;
    }

    public static function obtenerCantidadItems($idCompra)
    {
        $bd = new BaseDatos();
        $sql = "SELECT SUM(ci.cicantidad) as cantidad FROM compraitem ci WHERE ci.idcompra = $idCompra";
        $res = $bd->Ejecutar($sql);
        $cantidad = 0;
        if ($res > 0) {
            $cantidad = intval($bd->Registro()['cantidad']);
        }
        return $cantidad;
    }

    public function jsonSerialize()
    {

        $compraEstadoTipo = null;
        if ($this->getCompraEstadoTipo() != null) {
            $compraEstadoTipo = $this->getCompraEstadoTipo()->jsonSerialize();
        }

        return [
            'idCompraEstado' => $this->getIdCompraEstado(),
            'compraEstadoTipo' => $compraEstadoTipo,
            'ceFechaIni' => $this->getCeFechaIni(),
            'ceFechaFin' => $this->getCeFechaFin()
        ];
    }
}
