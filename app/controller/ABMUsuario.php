<?php
class AbmUsuario
{
    private $msjError;

    public function __construct() {}

    public function getMsjError()
    {
        return $this->msjError;
    }

    public function setMsjError($msjError)
    {
        $this->msjError = $msjError;
    }

    public function buscarUsuario($condicion)
    {
        // $objUsuario = new Usuario();
        // $objUsuario->setIdUsuario($param);

        $objUsuario = null;

        try {
            $colUsuario = Usuario::listar($condicion);
            if (!empty($colUsuario)) {
                $objUsuario = $colUsuario[0];
            }
        } catch (PDOException $e) {
            $this->setMsjError('Error PDO: ' . $e->getMessage());
        }

        return $objUsuario;
    }

    public function agregarUsuario($name, $email, $pass)
    {
        $msj = '';

        $usuarioModelo = $this->obtenerDatosUsuario();
        $dato = $usuarioModelo['usnombre'];
        $objUsuario = new Usuario();
        if (empty($this->buscarUsuario("usnombre='" . $dato . "'"))) {
            try {
                $objUsuario->setUsNombre($usuarioModelo['usnombre']);
                $objUsuario->setUsMail($usuarioModelo['usemail']);
                $objUsuario->setUsPass($usuarioModelo['uspass']);
                if ($objUsuario->insertar()) {
                    $abmObjUsuarioRol = new AbmUsuarioRol();
                    $abmObjUsuarioRol->setearRolDefault($objUsuario->getIdUsuario());
                    $msj = 'Éxito';
                }
            } catch (PDOException $e) {
                $this->setMsjError('Error PDO: ' . $e->getMessage());
                $msj = 'Error';
            }
        } else {
            $msj = 'Usuario existente';
        }
        return $msj;
    }


    public function modificarUsuario() {}

    public function listarUsuarios($condicion = '')
    {
        try {
            $colUsuarios = Usuario::listar($condicion);
        } catch (PDOException $e) {
            $this->setMsjError($e->getMessage());
            $colUsuarios = [];
        }
        return $colUsuarios;
    }

    public function borrarLogico($idUsuario)
    {
        $resp = false;
        $usuario = $this->buscarUsuario("idusuario = " . $idUsuario);

        if ($usuario) {
            if ($usuario->deshabilitar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    private function obtenerDatosUsuario()
    {
        $datos = darDatosSubmitted();

        return [
            'idusuario' => $datos['idusuario'] ?? null,
            'usnombre' => $datos['usnombre'] ?? null,
            'uspass' => $datos['uspass'] ?? null,
            'usemail' => $datos['usemail'] ?? null,
            'usDeshab' => $datos['usDeshab'] ?? null
        ];
    }
}
