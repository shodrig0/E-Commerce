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
                    $this->notificarAdministradores(
                        'Nuevo usuario registrado',
                        "El usuario $name ($email) se ha registrado en el sitio"
                    );
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

    public function modificarUsuario()
    {
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

    private function notificarAdministradores($asunto, $mensaje)
    {
        $administradores = $this->listarUsuariosPorRol('Administrador');

        $mailService = new Mail();
        foreach ($administradores as $admin) {
            try {
                $mailService->enviarCorreo(
                    $admin->getUsMail(),
                    $admin->getUsNombre(),
                    $asunto,
                    $mensaje,
                    strip_tags($mensaje)
                );
            } catch (Exception $e) {
            }
        }
    }

    public function listarUsuariosPorRol($rolDescripcion)
    {
        $usuarios = [];
        try {
            $roles = Rol::listar("rodescripcion = '{$rolDescripcion}'");
            if (!empty($roles)) {
                $rol = $roles[0];
                $usuarios = Usuario::listar("idrol = {$rol->getIdRol()}");
            }
        } catch (PDOException $e) {
            $this->setMsjError('Error al listar usuarios por rol: ' . $e->getMessage());
        }
        return $usuarios;
    }

    private function verificarCambios($usuario, $usuarioSent)
    {
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

    private function verificarCambioRol($idUsuario, $rolesNuevos)
    {
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

    public function habilitarUsuario($idUsuario)
    {
        $resp = false;
        $usuario = $this->buscarUsuario("idusuario = " . $idUsuario);

        if ($usuario) {
            if ($usuario->habilitar()) {
                $resp = true;
            }
        }

        return $resp;
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

    public function registrar($datos)
    {
        $rpta = [];
        if (!isset($datos['usnombre']) || !isset($datos['usemail']) || !isset($datos['uspass'])) {
            return [
                'success' => false,
                'error' => 'Todos los campos son obligatorios.'
            ];
        }

        try {
            if (!empty($this->buscarUsuario("usnombre='" . $datos['usnombre'] . "'"))) {
                $rpta = [
                    'success' => false,
                    'error' => 'El usuario ya existe.'
                ];
            }

            $usuario = new Usuario();
            $usuario->setUsNombre($datos['usnombre']);
            $usuario->setUsMail($datos['usemail']);
            $usuario->setUsPass($datos['uspass']);

            if (!$usuario->insertar()) {
                $rpta =  [
                    'success' => false,
                    'error' => 'Error al insertar el usuario en la base de datos.'
                ];
            }

            $abmUsuarioRol = new AbmUsuarioRol();
            $abmUsuarioRol->setearRolDefault($usuario->getIdUsuario());

            $mailService = new Mail();
            $asunto = 'Bienvenido a nuestra plataforma';
            $contenidoHtml = "
            <h1>¡Hola {$datos['usnombre']}!</h1>
            <p>Gracias por registrarte en nuestro sistema.</p>
            <p>Esperamos que disfrutes de tu experiencia.</p>
            <p>Saludos,<br>El equipo de Soporte</p>
        ";
            $contenidoAlt = "¡Hola {$datos['usnombre']}! Gracias por registrarte en Elixir Patagonico. Esperamos que disfrutes de tu experiencia en la mejor vinoteca digital.";

            try {
                $mailService->enviarCorreo($datos['usemail'], $datos['usnombre'], $asunto, $contenidoHtml, $contenidoAlt);
            } catch (\Exception $e) {
                $rpta =  [
                    'success' => true,
                    'message' => 'Registro exitoso, pero no se pudo enviar el correo.'
                ];
            }

            $rpta =  [
                'success' => true,
                'message' => 'Registro exitoso y correo enviado.'
            ];
        } catch (\Exception $e) {
            $rpta =  [
                'success' => false,
                'error' => 'Error en el proceso de registro: ' . $e->getMessage()
            ];
        }
        return $rpta;
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
