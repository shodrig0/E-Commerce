<?php
class Compra
{

    private $idcompra;
    private $cofecha;
    private Usuario $usuario;
    private $mensajeOperacion;
    private array $items;
    private array $estados;


    public function __construct()
    {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->usuario = new Usuario();
        $this->items = array();
        $this->estados = array();
    }

    public function cargar($idcompra, $cofecha, $usuario, $items = [], $estados = [])
    {
        $this->setIdCompra($idcompra);
        $this->setCoFecha($cofecha);
        $this->setUsuario($usuario);
        $this->setItems($items);
        $this->setEstados($estados);
    }

    public function getIdCompra()
    {
        return $this->idcompra;
    }

    public function setIdCompra($idcompra)
    {
        $this->idcompra = $idcompra;
    }

    public function getCoFecha()
    {
        return $this->cofecha;
    }

    public function setCoFecha($cofecha)
    {
        $this->cofecha = $cofecha;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function getEstados()
    {
        return $this->estados;
    }

    public function setEstados($estados)
    {
        $this->estados = $estados;
    }




    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $usr = new Usuario();
                    $usr->setIdUsuario($row['idusuario']);
                    $usr->buscar();
                    $items =  CompraItem::listar("idcompra = " . $this->getIdCompra());
                    $estados = CompraEstado::listar("idcompra = " . $this->getIdCompra());
                    $this->cargar($row['idcompra'], $row['cofecha'], $usr, $items, $estados);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Compra->buscar: " . $base->getError());
        }
        return $resp;
    }



    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compra(cofecha, idusuario) 
            VALUES ('" . $this->getCoFecha() . "', '" . $this->getUsuario()->getIdUsuario() . "')";
        if ($base->Iniciar()) {

            if ($idCompra = $base->Ejecutar($sql)) {
                $this->setIdCompra($idCompra);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->insertar:" . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compra SET cofecha = '" . $this->getCoFecha() . "', idusuario=" . $this->getUsuario()->getIdUsuario() . " WHERE idcompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra = " . $this->getIdCompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra";
        if ($parametro != "") {
            $sql .= ' WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Compra();
                    $usr = new Usuario();
                    $usr->setIdUsuario($row['idusuario']);
                    $usr->buscar();
                    $items = CompraItem::listar("idcompra = " . $row['idcompra']);
                    $estados = CompraEstado::listar("idcompra = " . $row['idcompra']);
                    $obj->cargar($row['idcompra'], $row['cofecha'], $usr, $items, $estados);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar las compras: " . $base->getError());
        }
        return $arreglo;
    }


    public function serializeItems()
    {
        $items = array();
        if ($this->getItems() != null) {
            foreach ($this->getItems() as $item) {
                array_push($items, $item->jsonSerialize());
            }
        }
        return $items;
    }

    public function serializeEstados()
    {
        $estados = array();
        if ($this->getEstados() != null) {
            foreach ($this->getEstados() as $estado) {
                array_push($estados, $estado->jsonSerialize());
            }
        }
        return $estados;
    }


    public function jsonSerialize()
    {
        $usr = null;
        if ($this->getUsuario() != null) {
            $usr = $this->getUsuario()->jsonSerialize();
        }

        return [
            'idcompra' => $this->getIdCompra(),
            'cofecha' => $this->getCoFecha(),
            'usuario' => $usr,
            'items' => $this->serializeItems(),
            'estados' => $this->serializeEstados()
        ];
    }
}
