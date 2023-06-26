<?php include "sec_login.php"; ?>
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
</head>
<body>
   <?php include'header-rh.php';?>
   <div class="titulo_p">Menu Principal</div>
   <div class="contenedor_titulos">
       <div class="titulo">Funciones del Aplicativo</div>
   </div>
   <div class="contenedor_front">
    <div class="front">
        <div><img src="img/logorh.png" alt=""></div>
        <div>
            <p>Desarrollo del aplicativo 
            web (Risk Hunter Plus – RH+), de acceso rápido y seguro, capaz de recolectar información en 
            tiempo real, usando un formulario que se pueda diligenciar usando celular, tableta o computador 
            portátil; <br> <br> aplicativo en el que se puedan cargar y guardar fotografías, que pueda hacer cálculos para 
            determinar niveles de riesgo, tanto numéricamente como mediante imágenes y gráficos, para la 
            obtención de un documento descargable (Informe de inspección) que se obtiene automáticamente 
            con base en los resultados obtenidos</p>
        </div>
    </div>
    <div class="menu_secundario" style="display:none;">        
    <nav class="main-nav">
            <ul class="menu" id="menu">
            <?php
                $sql = "select * from v_menus_x_usuario where id_menu and id_usuario = '$id_menu_p'";
                $result = mysqli_query($conect, $sql); 
                while($mostrar=mysqli_fetch_array($result)) { ?>
                <?php echo $mostrar['codigo']; ?>
            <?php } ?>    
            </ul>
        </nav>          
    </div>
   </div>
   <div class="cont_fin"></div>
    <?php include'footer.php';    ?>
</body>
</html>   