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

    $result = $mysqli->query("SELECT * FROM fc_servicios");

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

            <?php
            if ($result->fetch_assoc()["id"]) {
                echo `<div style="background-color: #5cb85c;height: 30px;margin: 20px;" id="AlertSucess">
                <h2 style="color: white;">Se creo el registro correctamente</h2>
            </div>`;
            } else {
                echo `<div style="background-color: #d9534f;height: 30px;margin: 20px;" id="AlertDanger">
                <h2 style="color: white;">No se puede crear el registro</h2>
            </div>`;
            }

            ?>
            <h2>Crear servicio para facturacion</h2>
            <form action="controller/controllerFacturacion.php" method="post">
                <div class="campos-p">
                    <label>Tipo Cliente</label>
                        <input type="hidden" name="id_dominio">
                        <input type="hidden" name="descripcion">
                        <input type="hidden" name="tipo_estado">
                        <input type="hidden" name="estado">
                    <select id="CondicionTipo" require>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = $ValoresDominio->fetch_assoc()) { ?>
                            <option value="<?php echo $row['identificador']; ?>"><?php echo $row['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="campos-p">
                    <label>Tipo de Informe</label>
                    <input type="number" name="precio">
                </div>
                <div class="campos-p">
                    <button type="submit" class="btn_azul">Guardar</button>
                </div>
            </form>
        </center>

        <table style="margin: 50px;">
            <thead>
                <tr class="titulo">
                    <th>Nombre</th>
                    <th>fecha vigencia</th>
                    <th>fecha vencimiento</th>
                    <th>Precio</th>
                    <th>porcentaje Iva</th>
                    <th>porcentaje descuento</th>
                    <th>meses</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo $row["nombre"]; ?></td>
                        <td><?php echo $row["fecha_vengencia"]; ?></td>
                        <td><?php echo $row["fecha_creacion"]; ?></td>
                        <td><?php echo "$" . number_format($row["precio"], 0, ',', '.'); ?></td>
                        <td><?php echo $row["porcentaje_Iva"]; ?></td>
                        <td><?php echo $row["porcentaje_descuento"]; ?>
                        </td>
                        <td>
                            <a class="btn_azul" href="PanelControlFacturacion.php?show=<?php echo $row["id"]; ?>">Visualizar</a>
                            <a class="btn_azul" href="PanelControlFacturacion.php?edit=<?php echo $row["id"]; ?>">editar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
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