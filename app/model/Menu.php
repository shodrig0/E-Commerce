<?php

class Menu{
    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre;
    private $meDeshabilitado;
    private $meOrden;
    private array $objRoles;
    private $link;
    private $mensajeoperacion;

    public function __construct()
    {

        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->padre = "";
        $this->link = "";
        $this->meDeshabilitado = "";
        $this->meOrden = "";
        $this->objRoles = [];
        $this->mensajeoperacion = "";
    }

    public function cargar($idMenu, $meNombre, $meDescripcion, $idPadre, $meDeshabilitado, $meOrden,$roles = [], $link)
    {
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setPadre($idPadre);
        $this->setMeDeshabilitado($meDeshabilitado);
        $this->setMeOrden($meOrden);
        $this->setObjRoles($roles);
        $this->setLink($link);
    }

    //setters
    public function setMeOrden($meOrden){
        $this->meOrden = $meOrden;
    }
    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
    }

    public function setMeNombre($meNombre)
    {
        $this->meNombre = $meNombre;
    }

    public function setMeDescripcion($meDescripcion)
    {
        $this->meDescripcion = $meDescripcion;
    }

    public function setPadre($padre)
    {
        $this->padre = $padre;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setMeDeshabilitado($meDeshabilitado)
    {
        $this->meDeshabilitado = $meDeshabilitado;
    }

    public function setObjRoles($roles)
    {
        $this->roles = $roles;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //getters

    public function getIdMenu()
    {
        return $this->idMenu;
    }

    public function getMeNombre()
    {
        return $this->meNombre;
    }

    public function getMeDescripcion()
    {
        return $this->meDescripcion;
    }

    public function getIdPadre()
    {
        return $this->idPadre;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getMeDeshabilitado()
    {
        return $this->meDeshabilitado;
    }

    public function getObjRoles()
    {
        return $this->objRoles;
    }

    public function getMeOrden(){
        return $this->meOrden;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function buscar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idmenu = " . $this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $roles = MenuRol::listar("idmenu = " . $this->getIdMenu());
                    if (isset($row['idpadre'])) {
                        $padre = new Menu();
                        $padre->setIdMenu($row['idpadre']);
                        $padre->buscar();
                        // Comparo para que no se genere un bucle infinito
                        if ($padre->getIdMenu() != $this->getIdMenu()) {
                            $this->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['medeshabilitado'], $row['meorden'],$roles, $row['link']);
                        }
                    } else {
                        $this->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], null, $row['medeshabilitado'], $row['meorden'],$roles, $row['link']);
                    }
                }
            }
        } else {
            $this->setMensajeOperacion("Menu->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $sql = "INSERT INTO menu (idmenu, menombre, medescripcion, idpadre, medeshabilitado, meorden, roles, link)
        VALUES ('" . $this->getIdMenu() . "','" . $this->getMeNombre() . "','" . $this->getMeDescripcion() . "','" . $this->getIdPadre() ? $this->getIdPadre()->getIdMenu() : 'NULL' . "','" . $this->getMeDeshabilitado() . "','" . $this->getMeOrden() . "','" . $this->getObjRoles() . "','" . $this->getLink() . "')";


        if ($base->Iniciar()) {
            $idUser = $base->Ejecutar($sql);
            if ($idUser > -1) {
                $this->setIdMenu($idUser);
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("Menu->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menu SET menombre='" . $this->getMeNombre() . "', medescripcion='" . $this->getMeDescripcion() . "', 
            idpadre='" . $this->getIdPadre()->getIdMenu() . "', medeshabilitado='" . $this->getMeDeshabilitado() . "', meorden='" . $this->getMeOrden() . "', roles='" . $this->getObjRoles() . "', link='" . $this->getLink() .
            "'  WHERE idmenu=" . $this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menu WHERE idmenu=" . $this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";
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
                    $obj = new Menu();
                    $roles = MenuRol::listar("idmenu = " . $row['idmenu']);


                    if ($row['idpadre']) {
                        $padre = new Menu();
                        $padre->setIdMenu($row['idpadre']);
                        $padre->buscar();
                        $obj->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['medeshabilitado'], $row['meorden'], $roles, $row['link']);
                    } else {
                        $obj->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['medeshabilitado'], $row['meorden'], $roles, $row['link']);
                    }

                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los menus: " . $base->getError());
        }

        return $arreglo;
    }

    public function ordenMenu(){
        $db = new BaseDatos();
        $sql = "SELECT * FROM menu ORDER BY idpadre ASC, meorden ASC";
        if ($db->Ejecutar($sql) > 0) {
            $menu = [];
            while ($row = $db->Registro()) {
                if ($row['idpadre'] === NULL) {
                    $menu[$row['idmenu']] = $row;
                    $menu[$row['idmenu']]['subitems'] = [];
                } else {
                    $menu[$row['idpadre']]['subitems'][] = $row;
                }
            }
        } else {
            $this->setMensajeoperacion('No se cargaron los menus' . $db->getError());
            $menu = [];
        }
        return $menu;
    }


    public function serializeRoles()
    {
        $roles = array();
        foreach ($this->getObjRoles() as $rol) {
            array_push($roles, $rol->jsonSerialize()["rol"]);
        }
        return $roles;
    }


    public function jsonSerialize()
    {
        $padre = null;
        if ($this->getIdPadre() != null) {
            $padre = $this->getIdPadre()->jsonSerialize();
        }
        return [
            'idMenu' => $this->getIdMenu(),
            'meNombre' => $this->getMeNombre(),
            'meDescripcion' => $this->getMeDescripcion(),
            'padre' => $padre,
            'link' => $this->getLink(),
            'meDeshabilitado' => $this->getMeDeshabilitado(),
            'roles' => $this->serializeRoles()
        ];
    }

    public function setearPadreNulo()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE `menu` SET `idpadre` = NULL WHERE `menu`.`idmenu` = " . $this->getIdMenu() . ";";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->setearPadreNulo: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->setearPadreNulo: " . $base->getError());
        }
        return $resp;
    }
}
