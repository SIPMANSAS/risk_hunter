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
</head>
<body>  
    <div class="titulo2">
        <i class="fa-solid fa-user"></i>
        <a href=""> Login de Usuario</a>
    </div>
    <div class="contenedor_titulos ">
        <div class="campos titulo">Iniciar Sesión</div>
    </div>
    <div class="contenedor">
        <form class="log" action="index.php" method="post">
            <div class="campos">
                <legend>usuario</legend>
                <input type="text" placeholder="Usuario" name="usuario">
            </div>
            <div class="campos">
                <legend>contraseña</legend>
                <input type="password" name="password" id="" placeholder="Su Contraseña">
            </div>
            <div class="campos">
                <input class="btn_azul" type="submit" value="Entrar" name="entrar">
            </div>
        </form>
    </div>
    <div class="cont_fin">
        <div class="campos"><label for="Recuerdame">Recuérdame</label> <input type="checkbox" name="Recuerdame" id=""></div>
        <div class="campos"><a href="recordar.php">Olvidó su contraseña?</a></div>
    </div>
    <?php include'footer.php';?>
</body>
</html>