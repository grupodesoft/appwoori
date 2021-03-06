<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>PAGOS DE:
                                <?php
                                if (isset($nombre_alumno) && !empty($nombre_alumno)) {
                                    echo $nombre_alumno;
                                }
                                ?></strong>
                        </h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                               <?php if (isset($pago_inicio) && empty($pago_inicio)) { ?>
                                <a href="<?php echo site_url('Tutores/pagoi/' . $idalumno . '/' . $idperiodo . '/' . $idnivel . '/1') ?>"
                                   class="btn btn-default waves-effect"> <i class="fa fa-money"></i> PAGAR REINSCRIPCIÓN/INSCRIPCIÓN</a>
                               <?php } if (isset($meses) && !empty($meses) && isset($pago_inicio) && !empty($pago_inicio)) { ?>
                                <a href="<?php echo site_url('Tutores/pagoc/' . $idalumno . '/' . $idperiodo . '/' . $idnivel . '/2') ?>"
                                   class="btn btn-primary waves-effect"><i class="fa fa-money"></i> PAGAR COLEGIATURA</a>
                                    <?php } ?>
                            <hr>

                            <table id="tablageneral2" class="table table-striped   dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead class="bg-teal">
                                    <tr>
                                        <th>#</th>
                                        <th>F. PAGO</th>
                                        <th>PAGÓ</th>
                                        <th>ESTATUS</th>
                                        <th>CONCEPTO</th>
                                        <th>DESCUENTO</th>
                                        <th>FECHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($pago_inicio) && !empty($pago_inicio)) {
                                        $i = 1;
                                        foreach ($pago_inicio as $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $value->nombretipopago ?></td>
                                                <td>
                                                    <?php
                                                    if ($value->online == 0) {
                                                        echo '<label class="label label-default">EN OFICINA</label>';
                                                    } else {
                                                        echo '<label class="label label-primary">EN LINEA</label>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($value->pagado == 1) {
                                                        echo '<label class="label label-success">PAGADO</label>';
                                                    } elseif ($value->online == 1 && $value->pagado == 0) {
                                                        echo '<label class="label label-warning">EN PROCESO</label>';
                                                    } else {
                                                        echo '<label class="label label-warning">SIN DEFINIR</label>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $value->concepto ?></td>
                                                <td><strong>$<?php echo number_format($value->descuento, 2) ?> </strong></td>
                                                <td><?php echo $value->fecharegistro ?> </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if (isset($pago_colegiaturas) && !empty($pago_colegiaturas)) {
                                        if (!isset($i)) {
                                            $i = 1;
                                        }
                                        foreach ($pago_colegiaturas as $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $value->nombretipopago ?></td>
                                                <td>
                                                    <?php
                                                    if ($value->online == 0) {
                                                        echo '<label class="label label-default">EN OFICINA</label>';
                                                    } else {
                                                        echo '<label class="label label-primary">EN LINEA</label>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($value->pagado == 1) {
                                                        echo '<label class="label label-success">PAGADO</label>';
                                                    } elseif ($value->online == 1 && $value->pagado == 0) {
                                                        echo '<label class="label label-warning">EN PROCESO</label>';
                                                    } else {
                                                        echo '<label class="label label-warning">SIN DEFINIR</label>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo 'MENSUALIDAD DE ' . $value->mes; ?></td>
                                                <td><strong>$<?php echo number_format($value->descuento, 2) ?> </strong></td>
                                                <td><?php echo $value->fechapago ?> </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer content -->
    <footer>
        <div class="copyright-info">
            <p class="pull-right">SICE - Sistema Integral para el Control Escolar</a>
            </p>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

</div>
<!-- /page content -->
</div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#tablageneral2').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

    });
</script>