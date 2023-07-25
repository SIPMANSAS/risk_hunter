<!DOCTYPE html>
<!--INDEX FREE DESDE LOCAL --->
<html lang="en">
<style>
    .rotated {
        transform: rotate(45deg); /* Equal to rotateZ(45deg) */
        background-color: pink;
    }
    
    #container {
      display: flex;
      width: 1000px;
      height: 250px;
    }
    
    .fragment {
      display: inline-flex;
      width: 25%;
      height: 100%;
      overflow: hidden;
    }

    #fragment2 img {
        margin-left: -250px;
    }
</style>
<head>
    <meta charset="UTF-8">
    <title>Reporte Inspección Freeeee <?php echo $numeroInspeccion ?></title>
    <style>
        .page-break {
            page-break-after: always;
        }

        body {
            font-family: "Calibri Light", sans-serif;
            font-size: 11px;
        }

        /*
        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
        }

        .verticalTextB {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            min-height: 114;
        }
        */


        /*  
        *{
            font-family: "Calibri Light", sans-serif !important;
            font-size: 11px;
        }
    */
    </style>
    <?php
    /*
        CA -----> $origen = 1
        IN -----> $origen = 2
        FI -----> $origen = 3
        */
    ?>
</head>

<body>
    <h1>
        <center>REPORTE DE INSPECCIÓN FREEMIUM <?php echo $numeroInspeccion ; ?></center>
    </h1>
    <br>
    <br>
    <br>
    <center>
        <?php
        $rutaImagen = "../img/IES.jpg";
        ?>
        <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter" . str_replace("..", "", $rutaImagen); ?>" alt="" width="500" height="500">
    </center>

    <br>
    <b>INFORME DE INSPECCIÓN DE RIESGOS</b><br><?php echo $numeroInspeccion ?>
    <br>
    <br>
    <?php echo $identificacion ?>
    <br>
    <br>
    <br>
    <b>Persona que solicita la inspección</b><br><?php echo $nombresolicitante ?>
    <br>
    <br>
    <br>
    <b>Fecha de Solicitud</b><br><?php echo $fecha_solicitud ?>
    <div class=" page-break"></div>

    <?php
    if ($origen == 1) {
    ?>
        <h1>
            <center>DATOS BASICOS DE LA INSPECCIÓN</center>
        </h1>
        <br>
        <br>
        <center>
            <table>
                <td><b>
                        <h5>Fecha de Solicitud de la inspección
                    </b></h5>
                </td>
                <td style="color:white">---------------------------------------</td>
                <td>
                    <h5><?php echo $fecha_elaboracion ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Numero de Inspección</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $inspeccion ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Firma Inspectora</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $firmainspectora ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Número de contacto de la firma inspectora</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $contactofirma ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Pais donde se realizó la inspección</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $pais ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Ciudad donde se realizó la inspección </b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $ciudad ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Dirección de la inspección</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $direccion ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Nombre del sitio a inspeccionar</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $nombreedificacion ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Nombre de la persona que atendió la inspección</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $nombrepersonaatiende ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Número de contacto de la persona que atendió la inspección</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $contactopersonaatiende ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Inspector Asignado</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $inspectorasignado ?></h5>
                </td>
                <tr></tr>
                <td>
                    <h5><b>Numero de contacto del inspector</b></h5>
                </td>
                <td></td>
                <td>
                    <h5><?php echo $contactopersonaatiende ?></h5>
                </td>
                <tr></tr>
            </table>
        </center>
    <?php
    }
    ?>
    <h1>
        <center>
            INFORMACIÓN GEOESTACIONARIA
        </center>
    </h1>
    <br>
    <table class="table">
        <thead>
            <th>
                <h4>Longitud</h4>
            </th>
            <th style="color:white;">Latitud</th>
            <th style="color:white;">Latitud</th>
            <th>
                <h4>Latitud</h4>
            </th>
            <th style="color:white;">Latitud</th>
            <th style="color:white;">Latitud</th>
            <th>
                <h4>Estrato</h4>
            </th>
            <th style="color:white;">Latitud</th>
            <th style="color:white;">Latitud</th>
            <th>
                <h4>Ubicación Socio Geográfica </h4>
            </th>
        </thead>
        <tbody>
            <tr>

                <td><?php echo $longitud ?></td>
                <td style="color:white;">ESPA</td>
                <td style="color:white;">ESPA</td>
                <td><?php echo $latitud ?></td>
                <td style="color:white;">ESPA</td>
                <td style="color:white;">ESPA</td>
                <td>
                    <?php
                    if($estrato == '784'){
                        echo 'Uno' ;
                    }elseif($estrato == '785'){
                        echo 'Dos' ;
                    }elseif($estrato == '786'){
                        echo 'Tres' ;
                    }elseif($estrato == '787'){
                        echo 'Cuatro' ;
                    }elseif($estrato == '788'){
                        echo 'Cinco' ;
                    }elseif($estrato == '789'){
                        echo 'Seis' ; 
                    }
                    echo $estrato
                    ?>
                </td>
                <td style="color:white;">ESPA</td>
                <td style="color:white;"></td>
                <td>
                    <?php
                    if ($espacio == '790') {
                        echo 'Rural';
                    } else {
                        echo 'Urbano';
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter/MostrarPDF/mapa_$identificador.png" ?>" alt="map not found" width="600" height="300">

    <?php echo "<h2 align='center'>" . $textofinlalinderos . "</h2>"; ?>

    <div class="page-break"></div>
    
    <h1>
        <center>
            ANÁLISIS GENERAL
        </center>
    </h1>
    <br>
    <br>
    <?php echo $informe_texto ?>
    <div class="page-break"></div>
    <h2>
        <center>MAPA DE RIESGOS</center>
    </h2>
    <?php echo str_replace('&nbsp;', '', $tabla); ?>
    <div class="page-break"></div>
    <h1>
        <center>ANÁLISIS RISK HUNTER +
    </h1>
    <br>
    <h2>
        <center>
            Niveles Por Riesgo
        </center>
    </h2>
    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter/MostrarPDF/Imagen_Grafica_$identificador.png" ?>" alt="Gráfico de nivel de riesgos" width="500" height="300">
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php echo $ColorRiesgo ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php /*<img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter/MostrarPDF/Imagen_Grafica2.png" ?>" alt="Gráfico de nivel de riesgos" width="500" height="300">*/?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php //echo $ColorRiesgo2 ?>
    <?php
    if ($origen == 1) {
    ?>
        <h1>
            <center>
                CALIFICACIÓN DE RIESGOS
                <?php
                include '../conexion.php';
                $consultafi = $mysqli->query("SELECT f_ci($identificador) AS f_ci");
                $extraer_f_ci = $consultafi->fetch_array(MYSQLI_ASSOC);
                $f_ci = $extraer_f_ci['f_ci'];
                ?>
            </center>
        </h1>
        <br>
    <?php echo 'F CI' . $f_ci . 'SELECT f_ci(' . $identificacion . ') AS f_ci';
    } ?>
  
    <h1>
        <center>CONVENCIONES</center>
        <br>
    </h1>
    <?php echo $convensiones; ?>
    <div class="page-break"></div>
    <h1>
        <center>REGISTRO FOTOGRÁFICO</center>
    </h1>
    <?php 
    $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion = '$identificador'");
    while ($extraerimagen = $consultaimagenes->fetch_array()) {
        $imagen = $extraerimagen['archivo'];
        $pie_de_pagina = $extraerimagen['pie_de_imagen'];
        if ($imagen != NULL) { ?>
            <div id="container">
                <div class="fragment cycle-slideshow" id="fragment1" data-duration="8000">
                    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter" . str_replace("..", "", $imagen); ?>" width="150" height="150">
                    <h5><?php echo $pie_de_pagina ?></h5>
                </div>
            </div>
    <?php  
        }else{
    ?>
            <label>No existe registro fotográfico</label>
    <?php
        } 
    }
    ?>
    </body>

</html>