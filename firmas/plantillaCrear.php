<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>plantilla crear</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link href="css/styledynam2.css" rel="stylesheet">
</head>
<body>  
<?php    /*agreho el header*/    include 'header.php';?>
<div class="titulo_p">
    <i class="fa-solid fa-user"> </i>&nbsp;
    Registro 
</div>
<div class="link_int">
    
<div class="titulo2">
    <i class="fa-solid fa-user"></i>
    <a href="registro1.php"> Nuevo Usuario</a>
</div>
</div>
<div class="contenedor_titulos ">
    <div class="campos titulo">Nuevo registro</div>
</div>
<div class="contenedor">
    <form class="registro" action="crearusuariosrh.php" method="post">'; 
        <div class="inputs_r">
            <label for="nombre">Nombres</label>
            <input class="inp_med" name="nombre" type="text" value="'.$nombre.'" required>
        </div>
    </form>
    <div class="registr-b">
        div para mensajes de exito o error
    </div>
</div> 
<div class="cont_fin"></div>
<?php include /*agreho el footer*/   'footer.php';?>
</script>
</body>
</html>