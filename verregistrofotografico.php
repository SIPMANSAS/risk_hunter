<?php

$idinspeccion = $_GET['idinspeccion'];

?>

 <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
        //include  "clases/otrobloques.class.php";
         include 'conexion/conexion.php';
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="favicon.ico">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista Encabezados</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    </head>    
    <body>
        <div class="titulo_p">
            <center><i class="fa-solid fa-file"></i> REGISTRO FOTOGRAFICO</center>
        </div>
        <div class="contenedor_titulos">
                        <div class=" titulo"><b>Imagenes</b></div>
        </div>
        <div class="contenedor">
             <?php
                        $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$idinspeccion'");
                        while($extraerimagen = $consultaimagenes->fetch_array()){
                        $imagen = $extraerimagen['archivo'];
                        $pie_de_pagina = $extraerimagen['pie_de_imagen'];
                        ?>
                        <div class="campos_f">
                            <img src="<?php echo 'archivos/'.$imagen; ?>" width="250" height="250">
                            <label><?php echo $pie_de_pagina ?></label>
                        </div>
                        <?php
                        }
                        
                        ?>
        </div>
        <div class="inputs_r">
            <input class="btn_azul" type='submit' onclick="close_tab()"  value="CERRAR">
        </div>
        <script>
                function close_tab(){
                    window.close();
                }
            </script>
    </body>