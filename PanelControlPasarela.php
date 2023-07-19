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

    $result = $mysqli->query("SELECT * FROM PaymentGateway");

    ?>
    <div class="titulo_p"><i class="fa fa-credit-card"></i>&nbsp;Panel de Control Facturación</div>


    <div class="contenedor_titulos">
        <div class="titulo">Facturación</div>
    </div>

    <div class="contenedor_front" style="margin-bottom: 20px;">
        <?php if ($_GET["edit"]) { ?>
            <center>
            <h2>Crear facturacion para clientes prepago y postpago</h2>
            <form action="funcioness/pasarela.php" method="post">
                <div class="campos-p">
                    <label>llave de token</label>
                    <input type="text" name="key">
                    <input type="hidden" name="id" value="<?php echo $_GET["edit"]; ?>">
                    <input type="hidden" name="update" value="0">
                </div>
                <div class="campos-p">
                    <button type="submit" class="btn_azul">Guardar</button>
                </div>
            </form>
        </center>
        <?php } else { ?>
            <center>
                <h2>Crear facturacion para clientes prepago y postpago</h2>
                <form action="funcioness/pasarela.php" method="post">
                    <div class="campos-p">
                        <label>llave de token</label>
                        <input type="text" name="key">
                    </div>
                    <div class="campos-p">
                        <label>Divisa</label>
                        <select name="currency">
                            <option value="" selected disabled>Seleccione una opcion</option>
                            <option value="cop">Peso colombiano</option>
                        </select>
                        <input type="hidden" name="insert" value="0">
                        <input type="hidden" name="tax_base" value="0">
                        <input type="hidden" name="tax" value="0">
                        <input type="hidden" name="country" value="co">
                        <input type="hidden" name="lang" value="es">
                        <input type="hidden" name="external" value="false">
                        <input type="hidden" name="confirmation" value="http://secure2.payco.co/prueba_curl.php">
                        <input type="hidden" name="response" value="http://secure2.payco.co/prueba_curl.php">
                    </div>
                    <div class="campos-p">
                        <button type="submit" class="btn_azul">Guardar</button>
                    </div>
                </form>
            </center>
        <?php  } ?>

        <table style="margin: 50px;">
            <thead>
                <tr class="titulo">
                    <th>#</th>
                    <th>Llave de la pasarela</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["gateway_key"]; ?></td>
                        <td><a class="btn_azul" href="PanelControlPasarela.php?edit=<?php echo $row["id"]; ?>">editar</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
    <?php include 'footer.php';  ?>
</body>

</html>