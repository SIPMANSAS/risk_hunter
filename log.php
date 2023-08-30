<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de usuario</title>
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/site.webmanifest">
    <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>
    <?php if ($_POST['id_rol']) { ?>
        <div class="titulo2">
            <i class="fa-solid fa-user"></i>
            <a href=""> Login de Usuario</a>
        </div>
        <div class="contenedor_titulos ">
            <div class="campos titulo">Iniciar Sesión</div>
        </div>
        <div class="contenedor">
            <form class="log" action="index.php" method="post">
                <input type="hidden" name="id_rol" value="<?php echo $_POST['id_rol']; ?>">
                <div class="campos">
                    <legend>usuario</legend>
                    <input type="text" placeholder="Usuario" name="usuario">
                </div>
                <div class="campos">
                    <legend>contraseña</legend>
                    <input type="password" name="password" id="contra" placeholder="Su Contraseña">
                    <br>
                    <!--<button class="btn_azul" type="button" onclick="mostrarContrasena()"><i class="fa fa-eye"></i></button>-->
                </div>
                <div class="campos">
                    <input type="checkbox" name="check_mostrar" onclick='handleClick(this);'><b> Mostrar contraseña</b><br>
                    <script>
                        function handleClick(cb) {
                            if (cb.checked)
                                $('#contra').attr("type", "text");
                            else
                                $('#contra').attr("type", "password");
                        }

                        function mostrarContrasena() {
                            var tipo = document.getElementById("contra");
                            if (tipo.type == "password") {
                                tipo.type = "text";
                            } else {
                                tipo.type = "password";
                            }
                        }
                    </script>
                </div>
                <div class="campos">
                <div class="g-recaptcha" data-sitekey="6Lfe_IQeAAAAAPZAHvytP-yX9HYSfydu20cSD-Iz"></div>
                    <input class="btn_azul" type="submit" value="Entrar" name="entrar">
                </div>
            </form>
        </div>
        <div class="cont_fin">
            <div class="campos"><label for="Recuerdame">Recuérdame</label> <input type="checkbox" name="Recuerdame" id=""></div>
            <div class="campos"><a href="recordar.php">Olvidó su contraseña?</a></div>
        </div>
    <?php } else { ?>
        <?php
        include 'conexion/conexion.php';
        $result = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio = 36;");


        ?>
        <div class="contenedor_titulos ">
            <div class="campos titulo">Seleccione</div>
        </div>
        <div class="contenedor">
            <form class="log" action="log.php" method="post">
                <input type="hidden" name="id_rol" id="textfield">
                <div class="campos">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<input type='submit' class='btn_azul' onclick='Click(" . $row['identificador'] . ");' value=" . $row['nombre'] . ">";
                    }
                    ?>

                </div>

            </form>
        </div>
        <script>
            function Click(value) {

                $('#textfield').val(value);
            }
        </script>
    <?php } ?>
    <?php include 'footer.php'; ?>
</body>

</html>