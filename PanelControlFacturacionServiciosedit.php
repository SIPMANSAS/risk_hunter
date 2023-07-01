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

    $ValoresDominio = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE identificador BETWEEN 817 AND 820");

    $result = $mysqli->query('SELECT * FROM fc_servicios WHERE  identificador="' . $_GET["edit"] . '"');

    ?>
    <div class="titulo_p"><i class="fa fa-credit-card"></i>&nbsp;Panel de Control Facturación</div>

    <div class="contenedor_titulos">
        <div class="titulo">Facturación</div>
    </div>

    <div class="contenedor_front" style="margin-bottom: 20px;">
        <center>
            <h2>Editar Servicio</h2>
            <form action="controller/controllerFacturacion.php" method="post">
                <div class="campos-p">
                    <input type="hidden" name="Updateservice" value="<?php echo $_GET["edit"]; ?>">
                    <?php foreach ($result as $row) { ?>
                        <label>Nombre Servicio</label>
                        <input type="text" name="servicio" value="<?php echo $row["nombre"]; ?>" require>
                </div>
                <div class="campos-p">
                    <label>% iva</label>
                    <input type="number" min="0" name="iva" value="<?php echo $row["porcentaje_Iva"]; ?>" require>
                </div>
                <div class="campos-p">
                    <label>% descuento</label>
                    <input type="number" min="0" name="descuento" value="<?php echo $row["porcentaje_descuento"]; ?>" require>
                </div>
                <div class="campos-p">
                    <label>meses</label>
                    <input type="number" min="0" name="meses" value="<?php echo $row["meses"]; ?>" require>
                </div>
                <div class="campos-p">
                    <label>Precio</label>
                    <input type="number" name="precio" value="<?php echo $row["precio"]; ?>" require>
                </div>
                <div class="campos-p">
                    <label>Fecha vigencia</label>
                    <input type="date" name="vigencia" value="<?php echo $row["fecha_vigencia"]; ?>" require>
                </div>
            <?php } ?>
            <div class="campos-p">
                <label>Tipo Cliente</label>
                <select id="CondicionTipo" name="clase_usuario_dom" require>
                    <option value="" selected disabled>Seleccione una opcion</option>
                    <?php while ($row = $ValoresDominio->fetch_assoc()) { ?>
                        <option value="<?php echo $row['identificador']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="campos-p">
                <button type="submit" class="btn_azul">Guardar</button>
            </div>
            </form>
        </center>
    </div>

    <?php include 'footer.php';  ?>
</body>

</html>