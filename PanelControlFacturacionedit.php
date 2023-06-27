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

    $FacShow = $mysqli->query('SELECT * FROM fc_facturacion WHERE id="' . $_GET["edit"] . '"');

    ?>
    <div class="titulo_p"><i class="fa fa-credit-card"></i>&nbsp;Panel de Control Facturación</div>

    <div class="contenedor_titulos">
        <div class="titulo">Facturación</div>
    </div>

    <div class="contenedor_front" style="margin-bottom: 20px;">
        <center>
            <h2>Visualizar Datos</h2>
            <form action="controller/controllerFacturacion.php" method="post">
                <input type="hidden" name="update" value="update">
                <?php foreach ($FacShow as $row) { ?>
                <div class="campos-p">
                    <label>ID</label>
                    <input type="text" name="id" value="<?php echo $row["id"]; ?>">
                    <label>Tipo de Informe</label>
                    <input type="text" name="Tipo" value="<?php echo $row["InformeTipo"]; ?>">
                </div>
                <div class="campos-p">
                    <label>fecha inicio</label>
                    <input type="date" id="fechaInicio" name="FInicio" value="<?php echo $row["fecha_inicio"]; ?>">
                </div>
                <div class="campos-p">
                    <label>fecha Vencimiento</label>
                    <input type="date" id="diferenciaFecha" name="FTermino" value="<?php echo $row["fecha_fin"]; ?>">
                </div>
                <div class="campos-p">
                    <label>inspecciones</label>
                    <input type="text" name="inspecciones" value="<?php echo $row["inspecciones"]; ?>">
                </div>
                <div class="campos-p">
                    <label>total inspecciones del cliente</label>
                    <input type="text" name="InsCliente" value="<?php echo $row["inspecciones_cliente"]; ?>">
                </div>
                <?php } ?>
                <div class="campos-p">
                    <button type="submit" class="btn_azul">Guardar</button>
                </div>
            </form>
            <div class="campos-p">
                <a href="PanelControlFacturacion.php" class="btn_azul">Volver al Inicio</a>
            </div>
        </center>

    </div>
    <?php include 'footer.php';  ?>
</body>

</html>