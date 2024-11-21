<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

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
