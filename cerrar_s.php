<?php
	session_start();
	session_unset();
	session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de sesion</title>
       <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <link rel="manifest" href="img/site.webmanifest">
        <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
      <link rel="shortcut icon" href="favicon.ico">
</head>
	
</head>
<body>
<div class="titulo_p">Cierre de session</div>
<div class="link_int">
	<div class="titulo2"><a href="log.php"><i class="fa-solid fa-door-open"></i>&nbsp; Acceder</a></div>
</div>
<div class="contenedor_titulos">
	<div class="titulo">session cerrada</div>
</div>
	<div class="contenedor">
		<div class="msj_verde">
			<span>La sesion se ha cerrado</span>
		</div>
	</div>
	<div class="cont_fin"></div>
	<?php include 'footer.php';?>
</body>
</html>