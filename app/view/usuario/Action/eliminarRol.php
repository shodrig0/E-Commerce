<?php
require_once('../../../../config.php');
require_once('../../../model/Usuario.php');
require_once('../../../controller/AbmUsuario.php');
require_once '../../../controller/AbmUsuarioRol.php';
require_once '../../../model/UsuarioRol.php';
require_once '../../../controller/AbmRol.php';
require_once '../../../model/Rol.php';

if (isset($_POST['idRol']) && isset($_POST['idUsuario'])) {
    $idRol = $_POST['idRol'];
    $idUsuario = $_POST['idUsuario'];

    $abmUsuarioRol = new AbmUsuarioRol();

    if ($abmUsuarioRol->buscarUsuarioRol($idUsuario) > 1) {
        $resultado = $abmUsuarioRol->eliminarUsuarioRol();
        echo $resultado ? "Rol eliminado correctamente." : "Error al eliminar el rol.";
    } else {
        echo "No se puede eliminar el único rol del usuario.";
    }
} else {
    echo "Datos insuficientes.";
}
?>
