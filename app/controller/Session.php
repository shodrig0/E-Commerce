<?php

class Session
{
    public function __construct()
    {
        session_start();
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados.
     */
    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $objAbmUsuario = new ABMUsuario();
        $resultado = $objAbmUsuario->buscarUsuario("usnombre = '" . $nombreUsuario . "'");

        if ($resultado) {
            $usuario = $resultado;
            if ($psw === $usuario->getUsPass()) {
                $_SESSION['idusuario'] = $usuario->getIdUsuario();
                $resp = true;
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
        if ($this->activa() && isset($_SESSION['idusuario']))
            $resp = true;
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
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscarUsuario($param);
            if ($resultado) {
                $usuario = $resultado;
            }
        }
        return $usuario;
    }

    /**
     * Devuelve el rol del usuario logeado.
     */
    // public function getRol(){
    //     $list_rol = null;
    //     if($this->validar()){
    //         $obj = new ABMUsuario();
    //          $param['idusuario']=$_SESSION['idusuario'];
    //         //  $resultado = $obj->darRoles($param);
    //         if(count($resultado) > 0){
    //             $list_rol = $resultado;
    //         }
    //     }
    //     return $list_rol;
    // }

    /**
     *Cierra la sesión actual.
     */
    public function cerrar()
    {
        // $_SESSION
        $resp = true;
        // $_SESSION['nombreUsuario'] = $_SESSION['usnombre'];
        session_destroy();
        return $resp;
    }
}
