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
        $usuarioModelo = $this->obtenerDatosUsuario();
        $dato = $usuarioModelo['usnombre'];
        $objUsuario = new Usuario();
        if (empty($this->buscarUsuario("usnombre='" . $dato . "'"))) {
            try {
                $objUsuario->setUsNombre($name);
                $objUsuario->setUsMail($email);
                $objUsuario->setUsPass($pass);
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

    public function modificarUsuario() {
        $msj = '';
        try {
            $usuarioSent = darDatosSubmitted();
            
    
            if ($usuarioSent === null) {
                throw new Exception("Datos inválidos enviados.");
            }
    
            $usuario = new Usuario();
            $usuario->setear($usuarioSent['idUsuario'], null, null, null, null, []);
            
            if (!$usuario->buscar()) {
                throw new PDOException("El usuario no existe.");
            }
    
            $usuarioCambiado = $this->verificarCambios($usuario, $usuarioSent);
            $rolCambio = false;
            if (isset($usuarioSent['roles'])) {
                $rolCambio = $this->verificarCambioRol($usuario->getIdUsuario(), $usuarioSent['roles']);
                $abmUsuarioRol = new AbmUsuarioRol();
            }

            if ($usuarioCambiado || $rolCambio) {
                $actualizado = $usuarioCambiado ? $usuario->modificar() : false;
                $rolActualizado = $rolCambio ? $abmUsuarioRol->agregarUsuarioRol($usuario, $rolCambio) : false;
    
                if ($actualizado || $rolActualizado) {
                    $msj = $actualizado ? true : "Rol del Usuario modificado exitosamente.";
                } else {
                    $msj = "Error al modificar el usuario: " . $usuario->getMensajeOperacion();
                }
            } else {
                $msj = "No se detectaron cambios en los datos del usuario.";

            }
        } catch (PDOException $e) {
            $msj = "Ocurrió un error: " . $e->getMessage();
        }
        return $msj;
    }
    
    
    private function verificarCambios($usuario, $usuarioSent) {
        $cambios = false;
    
        $campos = [
            'usNombre' => 'setUsNombre',
            'uspass' => 'setUsPass',
            'usMail' => 'setUsMail',
            'usdeshabilitado' => 'setUsDeshabilitado',
        ];
    
        foreach ($campos as $campo => $setter) {
            if (isset($usuarioSent[$campo]) && $usuario->{"get" . ucfirst($campo)}() !== $usuarioSent[$campo]) {
                $usuario->$setter($usuarioSent[$campo]);
                $cambios = true;
            }
        }
    
        return $cambios ? $usuario : null;
    }
    
    private function verificarCambioRol($idUsuario, $rolesNuevos) {
        $abmUsuarioRol = new AbmUsuarioRol();
        $rolesActuales = $abmUsuarioRol->buscarUsuarioRol($idUsuario);
    
        $rolesActualesIds = array_map(fn($rol) => $rol->getRol()->getIdRol(), $rolesActuales);
    
        if (!in_array($rolesNuevos, $rolesActualesIds)) {
            $nuevoRol = new Rol();
            $nuevoRol->cargar($rolesNuevos, null);
            $nuevoRol->buscar();
            return $nuevoRol;
        }
        return null;
    }
    
    
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

    public function registrar()
    {
    $datos = darDatosSubmitted();

    if (!isset($datos['usnombre']) || !isset($datos['usemail']) || !isset($datos['uspass'])) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios.']);
        return;
    }

    $registroExitoso = true;

    if ($registroExitoso) {
        $mailService = new Mail();
        $asunto = 'Bienvenido a nuestra plataforma';
        $contenidoHtml = "
        <h1>¡Hola {$datos['usnombre']}!</h1>
        <p>Gracias por registrarte en nuestro sistema.</p>
        <p>Esperamos que disfrutes de tu experiencia.</p>
        <p>Saludos,<br>El equipo de Soporte</p>
        ";
        $contenidoAlt = "¡Hola {$datos['usnombre']}! Gracias por registrarte en nuestro sistema. Esperamos que disfrutes de tu experiencia.";

        try {
            $mailService->enviarCorreo($datos['usemail'], $datos['usnombre'], $asunto, $contenidoHtml, $contenidoAlt);
            echo json_encode(['success' => true, 'message' => 'Registro exitoso y correo enviado.']);
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => 'Registro exitoso, pero no se pudo enviar el correo.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al registrar el usuario.']);
    }
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
