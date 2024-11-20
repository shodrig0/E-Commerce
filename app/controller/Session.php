<?php

// require_once $_SESSION['ROOT'] . 'controller/AbmUsuario.php';
require_once __DIR__ . '/AbmUsuario.php'; // Esto carga AbmUsuario.php relativo a la ubicación de Session.php
require_once __DIR__ . '/AbmUsuarioRol.php'; // Esto carga AbmUsuario.php relativo a la ubicación de Session.php
require_once __DIR__ . '/../model/Usuario.php'; // Esto carga AbmUsuario.php relativo a la ubicación de Session.php
require_once __DIR__ . '/../model/UsuarioRol.php'; // Esto carga AbmUsuario.php relativo a la ubicación de Session.php
require_once __DIR__ . '/../model/Rol.php'; // Esto carga AbmUsuario.php relativo a la ubicación de Session.php


class Session
{

    private static $instance = null;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $objAbmUsuario = new AbmUsuario();
        $resultado = $objAbmUsuario->buscarUsuario("usnombre = '" . $nombreUsuario . "'");

        if ($resultado) {
            $usuario = $resultado;

            if (is_null($usuario->getUsDeshabilitado())) {
                if ($psw === $usuario->getUsPass()) {
                    $_SESSION['idusuario'] = $usuario->getIdUsuario();
                    $resp = true;
                } else {
                    $this->cerrar();
                }
            } else {
                $this->cerrar();
            }
        } else {
            $this->cerrar();
        }
        return $resp;
    }

    /**
     * Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar()
    {
        $resp = false;
        if ($this->activa() && isset($_SESSION['idusuario'])) $resp = true;
        return $resp;
    }

    /**
     *Devuelve true o false si la sesión está activa o no.
     */
    public function activa()
    {
        $resp = false;
        if (php_sapi_name() !== 'cli') {
            $resp = session_status() === PHP_SESSION_ACTIVE;
        }
        return $resp;
    }

    /**
     * Devuelve el usuario logeado.
     */
    public function getUsuario()
    {
        $usuario = null;
        if ($this->validar()) {
            $obj = new AbmUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];

            // var_dump($_SESSION['ROOT']);
            $resultado = $obj->buscarUsuario('idusuario = ' . $param['idusuario']);
            if ($resultado) {
                $usuario = $resultado;
            }
        }
        return $usuario;
    }

    /**
     * Devuelve el rol del usuario logeado.
     */
    public function getRol()
    {
        $colRoles = null;
        if ($this->validar()) {
            $obj = new AbmUsuarioRol();
            $idUsuario = $_SESSION['idusuario'];
            $resultado = $obj->buscarUsuarioRol($idUsuario);
            if ($resultado && count($resultado) > 0) {
                $colRoles = [];
                foreach ($resultado as $usuarioRol) {
                    $objRol = $usuarioRol->getRol();
                    if ($objRol) {
                        $colRoles[] = [
                            'idrol' => $objRol->getIdRol(),
                            'rodescripcion' => $objRol->getRoDescripcion()
                        ];
                    }
                }
            }
        }
        return $colRoles;
    }

    /**
     *Cierra la sesión actual.
     */
    public function cerrar()
    {
        $resp = true;
        session_destroy();
        return $resp;
    }
}
