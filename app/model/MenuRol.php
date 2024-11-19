<?php
class MenuRol
{

    private Menu $menu;
    private Rol $rol;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->menu = new Menu();
        $this->rol = new Rol();
        $this->mensajeOperacion = "";
    }

    public function cargar($menu, $rol)
    {
        $this->setMenu($menu);
        $this->setRol($rol);
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMenu($menu)
    {
        $this->menu = $menu;
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
        $sql = "SELECT * FROM menurol WHERE idmenu = " . $this->getMenu()->getIdMenu() . " AND idrol = " . $this->getRol()->getIdRol();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $menu = new Menu();
                    $menu->setIdMenu($row['idmenu']);
                    $rol = new Rol();
                    $rol->setIdRol($row['idrol']);

                    $this->cargar($menu, $rol);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("MenuRol->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol (idmenu, idrol)
        VALUES ('"
            . $this->getMenu()->getIdMenu() . "', '"
            . $this->getRol()->getIdRol() .
            "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                //$this->setMenu($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("MenuRol->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->insertar: " . $base->getError());
        }
        return $respuesta;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menurol SET idmenu='" . $this->getMenu()->getIdMenu() . "', idrol='" . $this->getRol()->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menurol WHERE idmenu=" . $this->getMenu()->getIdMenu() . " AND idrol=" . $this->getRol()->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("MenuRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";
        if (is_array($parametro)) {
            $parametro = implode(" AND ", $parametro);
        }
        if ($parametro != ""){
            $sql .= " WHERE $parametro";
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new MenuRol();
                    $menu = new Menu();
                    $menu->setIdMenu($row['idmenu']);
                    // $menu->buscar();
                    $rol = new Rol();
                    $rol->setIdRol($row['idrol']);
                    $rol->buscar();
                    $obj->cargar($menu, $rol);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los menuRoles: " . $base->getError());
        }

        return $arreglo;
    }

    public function jsonSerialize()
    {
        if ($this->getMenu() != null) {
            $menu = $this->getMenu()->jsonSerialize();
        } else {
            $menu = null;
        }

        if ($this->getRol() != null) {
            $rol = $this->getRol()->jsonSerialize();
        } else {
            $rol = null;
        }

        return [
            'menu' => $menu,
            'rol' => $rol
        ];
    }
}
