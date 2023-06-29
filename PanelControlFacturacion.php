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

    $facturacion = $mysqli->query('SELECT fc_facturacion.id,fc_facturacion.InformeTipo,ter_terceros.nombres,fc_facturacion.fecha_inicio,fc_facturacion.fecha_fin,fc_facturacion.inspecciones,fc_facturacion.inspecciones_cliente,fc_facturacion.valor_total  FROM fc_facturacion INNER JOIN ter_terceros ON ter_terceros.identificacion = fc_facturacion.cliente_id;');

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

    <div class="contenedor_titulos">
        <div class="titulo">Facturación</div>
    </div>

    <div class="contenedor_front" style="margin-bottom: 20px;">
        <center>

            <?php
            if ($facturacion->fetch_assoc()["id"]) {
                echo `<div style="background-color: #5cb85c;height: 30px;margin: 20px;" id="AlertSucess">
                <h2 style="color: white;">Se creo el registro correctamente</h2>
            </div>`;
            } else {
                echo `<div style="background-color: #d9534f;height: 30px;margin: 20px;" id="AlertDanger">
                <h2 style="color: white;">No se puede crear el registro</h2>
            </div>`;
            }

            ?>
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
                        <input type="number" min="0" name="ClaseAInspeccion">
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
                    <th>Clasificado</th>
                    <th>Periocidad</th>
                    <th>Comienzo</th>
                    <th>Vencimiento</th>
                    <th>precio</th>
                    <th>Inspecciones</th>
                    <th>Ins hecha cliente</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturacion as $row) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>

                        <td><?php echo ($row["InformeTipo"] == 817) ? 'Clase A' : (($row["InformeTipo"] == 818) ? 'Clase B' : 'Clase C'); ?>
                        </td>
                        <td><?php echo $row["nombres"]; ?></td>
                        <td><?php echo ($row["fecha_inicio"]) ? $row["fecha_inicio"] : "SIN FECHA"; ?></td>
                        <td><?php echo ($row["fecha_fin"]) ? $row["fecha_fin"] : "SIN FECHA"; ?></td>
                        <td><?php echo "$" . number_format($row["valor_total"], 0, ',', '.'); ?></td>
                        <td><?php echo $row["inspecciones"]; ?></td>
                        <td><?php echo ($row["inspecciones_cliente"]) ? $row["inspecciones_cliente"] : 0; ?>
                        </td>
                        <td>
                            <a class="btn_azul" href="PanelControlFacturacionshow.php?show=<?php echo $row["id"]; ?>">Visualizar</a>
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
                case "2":
                    $("#ClaseA").css('display', 'none');

                    $("input[name=Tipo]").val(numero);
                    $("#ClaseB").css('display', 'block');
                    break;
                case "3":
                    $("#ClaseA").css('display', 'none');

                    $("input[name=Tipo]").val(numero);
                    $("#ClaseB").css('display', 'block');
                    break;

                case "4":
                    $("#ClaseA").css('display', 'none');

                    $("input[name=Tipo]").val(numero);
                    $("#ClaseB").css('display', 'block');
                    break;

                case "5":
                    $("#ClaseA").css('display', 'none');

                    $("input[name=Tipo]").val(numero);
                    $("#ClaseB").css('display', 'block');
                    break;
                default:
                    break;
            }


            var fechaInicio = new Date($('#fechaInicio').val());
            var fechaFin = new Date(fechaInicio);

            if (numero === "2") {
                fechaFin.setMonth(fechaFin.getMonth() + 1);
            } else if (numero === "3") {
                fechaFin.setMonth(fechaFin.getMonth() + 3);
            } else if (numero === "4") {
                fechaFin.setMonth(fechaFin.getMonth() + 6);
            } else if (numero === "5") {
                fechaFin.setFullYear(fechaFin.getFullYear() + 1);
            }

            var year = fechaFin.getFullYear();
            var month = (fechaFin.getMonth() + 1).toString().padStart(2, '0');
            var day = fechaFin.getDate().toString().padStart(2, '0');
            var fechaFinFormateada = year + '-' + month + '-' + day;

            $('#diferenciaFecha').val(fechaFinFormateada);
        });

        function hideSucess() {
            var alertElement = document.getElementById('AlertSucess');
            alertElement.style.display = 'none';
        }

        function hideDanger() {
            var alertElement = document.getElementById('AlertDanger');
            alertElement.style.display = 'none';
        }
        setTimeout(hideSucess, 2000);
        setTimeout(hideDanger, 2000);
    </script>
    <?php include 'footer.php';  ?>
</body>

</html>