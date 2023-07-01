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

    $result = $mysqli->query("SELECT fc.identificador,fc.nombre AS FCnombre,cg.nombre AS CGnombre,cg.descripcion AS CGdesc,fc. fecha_vigencia,fc.fecha_creacion,fc.precio,fc.porcentaje_Iva,fc.porcentaje_descuento,fc.meses FROM fc_servicios fc INNER JOIN cg_valores_dominio cg ON cg.identificador = fc.clase_usuario_dom;");

    $ter_terceros = $mysqli->query('SELECT ter_terceros.identificacion,ter_terceros.nombres FROM ter_terceros');
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
            <h2>Crear servicio para facturacion</h2>
            <form action="controller/controllerFacturacion.php" method="post">
                <div class="campos-p">
                    <input type="hidden" name="service" value="1">
                    <label>Nombre Servicio</label>
                    <input type="text" name="servicio" require>
                </div>
                <div class="campos-p">
                    <label>% iva</label>
                    <input type="number" min="0" name="iva" require>
                </div>
                <div class="campos-p">
                    <label>% descuento</label>
                    <input type="number" min="0" name="descuento" require>
                </div>
                <div class="campos-p">
                    <label>meses</label>
                    <input type="number" min="0" name="meses" require>
                </div>
                <div class="campos-p">
                    <label>Precio</label>
                    <input type="number" name="precio" require>
                </div>
                <div class="campos-p">
                    <label>Fecha vigencia</label>
                    <input type="date" name="vigencia" id="" require>
                </div>
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

        <table style="margin: 50px;">
            <thead>
                <tr class="titulo">
                    <th>#</th>
                    <th>Nombre</th>
                    <th>clase de usuario</th>
                    <th>F Creación</th>
                    <th>F Vigencia</th>
                    <th>Precio</th>
                    <th>% Iva</th>
                    <th>% desc</th>
                    <th>Meses</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo $row["identificador"]; ?></td>
                        <td><?php echo $row["FCnombre"]; ?></td>
                        <td style="max-width: 200px;"><?php echo $row["CGnombre"] . " - " . $row["CGdesc"]; ?></td>
                        <td><?php echo $row["fecha_creacion"]; ?></td>
                        <td><?php echo $row["fecha_vigencia"]; ?></td>
                        <td><?php echo "$" . number_format($row["precio"], 0, ',', '.'); ?></td>
                        <td><?php echo $row["porcentaje_Iva"]; ?></td>
                        <td><?php echo $row["porcentaje_descuento"]; ?>
                        <td><?php echo $row["meses"]; ?>
                        </td>
                        <td>
                            <a class="btn_azul" href="PanelControlFacturacionServiciosedit.php?edit=<?php echo $row["identificador"]; ?>">editar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php';  ?>
</body>

</html>