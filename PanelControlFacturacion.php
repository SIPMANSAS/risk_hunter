<?php
include "sec_login.php";
include 'conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
    <?php
    include 'header-rh.php';

    $result = $mysqli->query("SELECT * FROM fc_servicios");

    $facturacion = $mysqli->query('SELECT fc.id,fc.InformeTipo,ter.nombres,fc.fecha_inicio,fc.fecha_fin,fc.inspecciones,fc.inspecciones_cliente,fc.valor_total,fc.valor_iva,fc.valor_descuento,fc.valor_neto  FROM fc_facturacion fc INNER JOIN ter_terceros ter ON ter.identificacion = fc.cliente_id');

    $ter_terceros = $mysqli->query('SELECT ter_terceros.identificacion,ter_terceros.nombres FROM ter_terceros');

    $response = null;
    while ($row = $result->fetch_assoc()) {
        $response .= "<option value=" . $row['identificador'] . ">" . $row['nombre'] . "</option>";
    }

    $html = null;
    while ($row = $ter_terceros->fetch_assoc()) {
        $html .= "<option value=" . $row['identificacion'] . ">" . $row['nombres'] . "</option>";
    }

    ?>
    <div class="titulo_p"><i class="fa fa-credit-card"></i>&nbsp;Panel de Control Facturación</div>


    <div class="link_int">
        <div class=""></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="PanelControlPasarela.php"> Crear Pasarela de pago</a></div>
    </div>

    <div class="contenedor_titulos">
        <div class="titulo">Facturación</div>
    </div>

    <div class="contenedor_front" style="margin-bottom: 20px;">
        <center>

            <h2>Crear facturacion para clientes prepago y postpago</h2>
            <div class="campos-p">
                <label>Tipo Cliente</label>
                <select id="CondicionTipo" require>
                    <option value="" selected disabled>Seleccione una opcion</option>
                    <option value="1">Prepago</option>
                    <option value="2">Pago al terminal</option>
                </select>
            </div>

            <div id="Response" style="display: none;">
                <div class="campos-p">
                    <label>Tipo de Informe</label>
                    <select name="Tipo" id="CondicionFactura" require>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php echo $response; ?>
                    </select>
                </div>
            </div>

            <div id="ClaseA" style="display: none;">
                <form action="controller/controllerFacturacion.php" method="post">
                    <input type="hidden" name="Tipo">
                    <div class="campos-p">
                        <label>Seleccione el Cliente</label>
                        <select name="ClaseACliente" require>
                            <option value="" selected disabled>Seleccione una opcion</option>
                            <?php echo $html; ?>
                        </select>
                    </div>
                    <div class="campos-p">
                        <label>Ingrese el Total de Inspecciones</label>
                        <input type="number" min="0" name="ClaseAInspeccion" require>
                    </div>
                    <div class="campos-p">
                        <button type="submit" class="btn_azul">Guardar</button>
                    </div>
                </form>
            </div>

            <div id="ClaseB" style="display: none;">
                <form action="controller/controllerFacturacion.php" method="post">
                    <input type="hidden" name="Tipo">
                    <div class="campos-p">
                        <label>Seleccione el Cliente</label>
                        <select name="ClaseBCliente" required>
                            <option value="" selected disabled>Seleccione una opcion</option>
                            <?php echo $html; ?>
                        </select>
                    </div>
                    <div class="campos-p"> <label>Fecha inicio</label>
                        <input type="date" id="fechaInicio" value="<?php echo date("Y-m-d"); ?>" name="ClaseBFInicio" readonly>
                        <label>Fecha fin</label>
                        <input type="date" id="diferenciaFecha" name="ClaseBFTermino" readonly>
                    </div>
                    <div class="campos-p">
                        <button type="submit" class="btn_azul">Guardar</button>
                    </div>
                </form>
            </div>
        </center>

        <table style="margin: 50px;">
            <thead>
                <tr class="titulo">
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th>Comienzo</th>
                    <th>Vencimiento</th>
                    <th>valor servicio</th>
                    <th>iva</th>
                    <th>descuento</th>
                    <th>valor neto</th>
                    <th>Cupos</th>
                    <th>Cupos cliente</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturacion as $row) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["InformeTipo"]; ?>
                        </td>
                        <td style="max-width: 100px;"><?php echo $row["nombres"]; ?></td>
                        <td><?php echo ($row["fecha_inicio"]) ? $row["fecha_inicio"] : "SIN FECHA"; ?></td>
                        <td><?php echo ($row["fecha_fin"]) ? $row["fecha_fin"] : "SIN FECHA"; ?></td>
                        <td><?php echo "$" . number_format($row["valor_total"], 0, ',', '.'); ?></td>
                        <td><?php echo "$" . number_format($row["valor_iva"], 0, ',', '.'); ?></td>
                        <td><?php echo "$" . number_format($row["valor_descuento"], 0, ',', '.'); ?></td>
                        <td><?php echo "$" . number_format($row["valor_neto"], 0, ',', '.'); ?></td>
                        <td><?php echo $row["inspecciones"]; ?></td>
                        <td><?php echo ($row["inspecciones_cliente"]) ? $row["inspecciones_cliente"] : 0; ?>
                        </td>
                        <td>
                            <a class="btn_azul" href="PanelControlFacturacionedit.php?edit=<?php echo $row["id"]; ?>">editar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
    <script>
        $('#CondicionTipo').change(function(e) {
            e.preventDefault();

            if (this.value == 1) {
                $("#Response").css('display', 'block');
            } else {
                $('#Response').css('display', 'none');
                $('#ClaseA').css('display', 'none');
                $('#ClaseB').css('display', 'none');
                $('#ClaseC').css('display', 'none');
            }
        });

        $('#CondicionFactura').change(function(e) {
            e.preventDefault();

            var numero = this.value;

            switch (numero) {
                case "1":
                    $("#ClaseB").css('display', 'none');

                    $("input[name=Tipo]").val(numero);
                    $("#ClaseA").css('display', 'block');
                    break;
                default:
                    $("#ClaseA").css('display', 'none');

                    $("input[name=Tipo]").val(numero);
                    $("#ClaseB").css('display', 'block');
                    break;
            }

            var fechaInicio = new Date($('#fechaInicio').val());
            var fechaFin = new Date(fechaInicio);

            $.ajax({
                type: "POST",
                url: "controller/controllerFacturacion.php",
                data: {
                    filtro: numero,
                },
                success: function(response) {
                    var parsedResponse = parseInt(response);

                    fechaFin.setMonth(fechaFin.getMonth() + parsedResponse);

                    var year = fechaFin.getFullYear();
                    var month = (fechaFin.getMonth() + 1).toString().padStart(2, '0');
                    var day = fechaFin.getDate().toString().padStart(2, '0');
                    var fechaFinFormateada = year + '-' + month + '-' + day;

                    $('#diferenciaFecha').val(fechaFinFormateada);
                }
            });

        });
    </script>
    <?php include 'footer.php';  ?>
</body>

</html>