<?php

class Menu
{

    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $padre;
    private $link;
    private $meDeshabilitado;
    private array $roles;
    private $mensajeoperacion;

    public function __construct()
    {

        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->padre = "";
        $this->link = "";
        $this->meDeshabilitado = "";
        $this->roles = array();
        $this->mensajeoperacion = "";
    }

    public function cargar($idMenu, $meNombre, $meDescripcion, $padre, $link, $meDeshabilitado, $roles = [])
    {
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setPadre($padre);
        $this->setLink($link);
        $this->setMeDeshabilitado($meDeshabilitado);
        $this->setRoles($roles);
    }

    //setters

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

    public function setRoles($roles)
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

    public function getPadre()
    {
        return $this->padre;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getMeDeshabilitado()
    {
        return $this->meDeshabilitado;
    }

    public function getRoles()
    {
        return $this->roles;
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
                            $this->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['link'], $row['medeshabilitado'], $roles);
                        }
                    } else {
                        $this->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], null, $row['link'], $row['medeshabilitado'], $roles);
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
        $sql = "INSERT INTO menu (idmenu, menombre, medescripcion, idpadre, link, medeshabilitado)
				VALUES ('" . $this->getIdMenu() . "','" . $this->getMeNombre() . "','" . $this->getMeDescripcion() . "','" . $this->getPadre()->getIdMenu() . "','" . $this->getLink() . "','" . $this->getMeDeshabilitado() . "')";

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
            idpadre='" . $this->getPadre()->getIdMenu() . "', link='" . $this->getLink() . "', medeshabilitado='" . $this->getMeDeshabilitado() .
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
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
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
                        $obj->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $padre, $row['link'], $row['medeshabilitado'], $roles);
                    } else {
                        $obj->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], null, $row['link'], $row['medeshabilitado'], $roles);
                    }

                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar los menus: " . $base->getError());
        }

        return $arreglo;
    }


    public function serializeRoles()
    {
        $roles = array();
        foreach ($this->getRoles() as $rol) {
            array_push($roles, $rol->jsonSerialize()["rol"]);
        }
        return $roles;
    }


    public function jsonSerialize()
    {
        $padre = null;
        if ($this->getPadre() != null) {
            $padre = $this->getPadre()->jsonSerialize();
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
