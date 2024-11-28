<?php
require_once '../../../../config.php';
require_once '../../layouts/header.php';

$abmCompra = new AbmCompra;
$arrayCompras = $abmCompra->listarCompras($session);

?>

<div class="ui container">
    <h2 class="ui header">Listado de Compras</h2>
    <table class="ui celled table">
        <thead>
            <tr>
                <th>ID Compra</th>
                <th>Fecha Inicio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($arrayCompras)) : ?>
                <?php foreach ($arrayCompras as $compra) :
                    $abmEstado = new AbmCompraEstado;
                    $idCompra = $compra->getIdCompra();
                    $paramIdCompra = ["idcompra" => $idCompra];
                    $estado = $abmEstado->buscar($paramIdCompra);
                    $contadorEstado = (count($estado)-1);
                    $idCompraEstadoTipo =$estado[$contadorEstado]->getCompraEstadoTipo()->getIdcompraestadotipo();
                    ?>
                    <tr>
                        <td><?= $compra->getIdCompra();?></td>
                        <td><?= $compra->getCoFecha(); ?></td>
                        <td><?= $estado[$contadorEstado]->getCompraEstadoTipo()->getCetdescripcion();?></td>
                        <td>

                            <button class="ui button red boton-cancelar" <?=($idCompraEstadoTipo == 4 ||$idCompraEstadoTipo == 3) ? 'disabled' : ''; ?> data-idcompra="<?=$compra->getIdCompra(); ?> " data-idestado="<?= $idCompraEstadoTipo; ?>">
                                <i class="ui trash alternate icon"></i>Cancelar
                            </button>
                            <button class="ui button blue boton-cambiar" <?= ($idCompraEstadoTipo == 4 ||$idCompraEstadoTipo == 3) ? 'disabled' : ''; ?> data-idestado="<?= $idCompraEstadoTipo; ?>"data-idcompra="<?=$compra->getIdCompra(); ?>"  >
                                <i></i> Siguiente Estado
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="ui modal">
    <div class="header">Confirmar Acci&oacute;n</div>
    <div class="content">
        <p id="modal-mensaje">¿Est&aacute;s seguro de que deseas cambiar el estado de la compra?</p>
    </div>
    <div class="actions">
        <div class="ui red deny button">Cancelar</div>
        <div class="ui green approve button">Confirmar</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.boton-cancelar').click(function() {
            const fila = $(this).closest('tr')
            const idCompra = fila.find('td:first').text()
            const idEstado = $(this).data('idestado')
            const data = {
                accion: 'cancelar',
                idcompra: idCompra,
                idcompraestadotipo: idEstado
            };
            $.ajax({
                url: './action/actionCambiarEstadoCompra.php',
                method: 'POST',
                data: data,
                success: function(response) {
                    $('#modal-mensaje').text('¿Est$aacute;s segurx de que deseas cancelar esta compra?')
                    $('.ui.modal').modal('show')
                },
                error: function(error) {
                    alert('Hubo problemas al cancelar la compra')
                }
            })
        })
        $('.boton-cambiar').click(function() {
            const fila = $(this).closest('tr')
            const idCompra = fila.find('td:first').text()
            const idEstado = $(this).data('idestado')
            const data = {
                accion: 'siguienteEstado',
                idcompra: idCompra,
                idcompraestadotipo: idEstado
            };

            $.ajax({
                url: './action/actionCambiarEstadoCompra.php',
                method: 'POST',
                data: data,
                success: function(response) {
                    alert('Funciona el cambio de la compra')
                },
                error: function(error) {
                    alert('Hubo problemas al cancelar la compra')
                }
            })
        })
    })
</script>