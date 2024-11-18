<?php
require_once('../../../config.php');
require_once('../../model/Usuario.php');
require_once('../../controller/AbmUsuario.php');
require_once '../../controller/AbmUsuarioRol.php';
require_once '../../model/UsuarioRol.php';
require_once '../../controller/AbmRol.php';
require_once '../../model/Rol.php';

$abmUsuario = new AbmUsuario();
$usuarios = $abmUsuario->listarUsuarios();
?>

<table class="ui celled table">
    <thead>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Deshabilitado</th>
            <th>Roles</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario->getIdUsuario()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getUsNombre()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getUsMail()); ?></td>
                <td><?php echo $usuario->getUsDeshabilitado() === null ? "Miembro Habilitado" : htmlspecialchars($usuario->getUsDeshabilitado()); ?></td>
                <td>
                    <?php
                    $objUsRol = new AbmUsuarioRol();
                    $colUsRol = $objUsRol->buscarUsuarioRol($usuario->getIdUsuario());
                    $roles = [];
                    foreach ($colUsRol as $usRol) {
                        $roles[] = $usRol->getRol()->getRoDescripcion();
                    }
                    $rolesString = implode(", ", $roles);
                    ?>
                    <div class="ui list"><?php echo htmlspecialchars($rolesString); ?></div>
                </td>
                <td>
                    <!-- Botón de editar -->
                    <button class="ui button editar-usuario" data-id="<?php echo htmlspecialchars($usuario->getIdUsuario()); ?>">Editar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div id="editarUsuario" class="ui segment"></div>
<script>
    $(document).ready(function() {
        // Maneja el clic en el botón de editar
        $('.editar-usuario').on('click', function() {
            let userId = $(this).data('id'); // Obtiene el ID del usuario desde el atributo data-id

            // Realiza una petición AJAX para cargar el formulario de edición
            $.ajax({
                url: './Action/editarUsuario.php', // Archivo PHP donde se cargará el formulario
                type: 'POST',
                data: { idUsuario: userId },
                success: function(response) {
                    // Inserta la respuesta en el contenedor
                    $('#editarUsuario').html(response);
                },
                error: function() {
                    alert('Hubo un error al cargar los datos del usuario.');
                }
            });
        });
    });
</script>

