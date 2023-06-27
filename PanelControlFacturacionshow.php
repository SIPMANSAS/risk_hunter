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

    $FacShow = $mysqli->query('SELECT * FROM fc_facturacion WHERE id="' . $_GET["show"] . '"');

    ?>
    <div class="titulo_p"><i class="fa fa-credit-card"></i>&nbsp;Panel de Control Facturación</div>

    <div class="contenedor_titulos">
        <div class="titulo">Facturación</div>
    </div>

    <div class="contenedor_front" style="margin-bottom: 20px;">
        <center>
            <h2>Visualizar Datos</h2>
            <?php foreach ($FacShow as $row) { ?>
            <div class="campos-p">
                <label>ID</label>
                <input type="text" value="<?php echo $row["id"]; ?>" readonly>
                <label>Tipo de Informe</label>
                <input type="text" value="<?php echo $row["InformeTipo"]; ?>" readonly>
            </div>
            <div class="campos-p">
                <label>fecha inicio</label>
                <input type="text" value="<?php echo $row["fecha_inicio"]; ?>" readonly>
            </div>
            <div class="campos-p">
                <label>fecha Vencimiento</label>
                <input type="text" value="<?php echo $row["fecha_fin"]; ?>" readonly>
            </div>
            <div class="campos-p">
                <label>inspecciones</label>
                <input type="text" value="<?php echo $row["inspecciones"]; ?>" readonly>
            </div>
            <div class="campos-p">
                <label>total inspecciones del cliente</label>
                <input type="text" value="<?php echo $row["inspecciones_cliente"]; ?>" readonly>
            </div>
            <?php } ?>
            <div class="campos-p">
                <a href="PanelControlFacturacion.php" class="btn_azul">Volver al Inicio</a>
            </div>
        </center>

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

        $('input[name=Tipo]').val(this.value);

        if (this.value == 817) {
            $("#ClaseB").css('display', 'none');
            $("#ClaseC").css('display', 'none');

            $("#ClaseA").css('display', 'block');
        } else if (this.value == 818) {
            $("#ClaseA").css('display', 'none');
            $("#ClaseC").css('display', 'none');

            $("#ClaseB").css('display', 'block');
        } else {
            $("#ClaseA").css('display', 'none');
            $("#ClaseB").css('display', 'none');

            $("#ClaseC").css('display', 'block');
        }
    });

    $("#frecuencia").change(function(e) {
        e.preventDefault();

        if (this.value === "mensual") {
            document.getElementById("fecha-inicio").value = 1;
        } else if (this.value === "trimestral") {
            document.getElementById("fecha-inicio").value = 3;
        } else if (this.value === "semestral") {
            document.getElementById("fecha-inicio").value = 6;
        } else {
            document.getElementById("fecha-inicio").value = 12;
        }

    });
    </script>
    <?php include 'footer.php';  ?>
</body>

</html>