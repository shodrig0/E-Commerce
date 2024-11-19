<?php
class Producto
{
    private $idProducto;
    private $proNombre;
    private $proDetalle;
    private $precio;
    private $proCantStock;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idProducto = "";
        $this->proNombre = "";
        $this->proDetalle = "";
        $this->precio = "";
        $this->proCantStock = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idProducto, $proNombre, $proDetalle, $precio, $proCantStock)
    {
        $this->setIdProducto($idProducto);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setPrecio($precio);
        $this->setProCantStock($proCantStock);
    }

    public function cargarClave($parametro)
    {
        foreach ($parametro as $clave => $value) {
            switch ($clave) {
                case 'idProducto':
                    $this->setIdProducto($value);
                    break;
                case 'proNombre':
                    $this->setProNombre($value);
                    break;
                case 'proDetalle':
                    $this->setProDetalle($value);
                    break;
                case 'precio':
                    $this->setPrecio($value);
                    break;
                case 'proCantStock':
                    $this->setProCantStock($value);
                    break;
                default:
                    break;
            }
        }
    }
    

    //getters

    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function getProNombre()
    {
        return $this->proNombre;
    }

    public function getProDetalle()
    {
        return $this->proDetalle;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getProCantStock()
    {
        return $this->proCantStock;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    //setters

    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function setProNombre($proNombre)
    {
        $this->proNombre = $proNombre;
    }

    public function setProDetalle($proDetalle)
    {
        $this->proDetalle = $proDetalle;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function setProCantStock($proCantStock)
    {
        $this->proCantStock = $proCantStock;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idproducto = " . $this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->cargar($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['precio'], $row['procantstock']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Producto->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO producto (pronombre, prodetalle, precio, procantstock)
        VALUES ('"
            . $this->getProNombre() . "', '"
            . $this->getProDetalle() . "', '"
            . $this->getPrecio() . "', '"
            . $this->getProCantStock() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdProducto($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Producto->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->insertar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET pronombre='" . $this->getProNombre() . "', prodetalle='" . $this->getProDetalle() . "', precio='" . $this->getPrecio() . "', procantstock='" . $this->getProCantStock() .
            "'  WHERE idproducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new Producto();
                    $obj->cargar($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['precio'], $row['procantstock']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los productos: " . $base->getError());
        }
        return $arreglo;
    }



    public function jsonSerialize()
    {
        return [
            'idProducto' => $this->getIdProducto(),
            'proNombre' => $this->getProNombre(),
            'proDetalle' => $this->getProDetalle(),
            'precio' => $this->getPrecio(),
            'proCantStock' => $this->getProCantStock()
        ];
    }
}
