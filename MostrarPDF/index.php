<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Documento pdf</title>
    <style>
    .page-break {
        page-break-after: always;
    }

    body {
        font-family: "Calibri Light", sans-serif !important;
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
        <center>La <?php echo $firmainspectora ; ?></center>
    </h1>
    <br>
    <br>
    <br>
    <?php
    if($rutaImagen == NULL){
        $rutaImagen = "../../img/IES.jpg";
    ?>
    <center>
        <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter" . str_replace("..", "", $rutaImagen); ?>"
            alt="" width="500" height="500">
    </center>
    <?php
    }else{
    ?>
    <center>
        <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter" . str_replace("..", "", $rutaImagen); ?>"
            alt="" width="500" height="500">
    </center>
    <?php
    }
    ?>
    <br>
    <b>INFORME DE INSPECCIÓN DE RIESGOS</b><br><?php echo $inspeccion ?>
    <br>
    <br>
    <?php echo $identificacion ?>
    <br>
    <br>
    <br>
    <b>Persona que atendion la inspeccion</b><br><?php echo $nombrepersonaatiende ?>
    <br>
    <br>
    <br>
    <b>Fecha de Elaboración</b><br><?php echo $fecha_elaboracion ?>
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
                <h4>Ubicación Sociogeografica</h4>
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
                <td><?php echo $estrato ?></td>
                <td style="color:white;">ESPA</td>
                <td style="color:white;"></td>
                <td><?php echo $espaciogeografico ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter/MostrarPDF/mapa.png" ?>" alt="map not found"
        width="600" height="300">

    <?php echo "<h2 align='center'>" . $textofinlalinderos . "</h2>"; ?>

    <div class="page-break"></div>
    <h1>
        <center>
            LISTA DE BIENES
        </center>
    </h1>
    <br>
    <?php echo $result; ?>
    <div class="page-break"></div>
    <h1>
        <center>
            ANÁLISIS GENERAL
        </center>
    </h1>
    <br>
    <br>
    <?php echo $texto_informe ?>
    <div class="page-break"></div>
    <h1>
        <center>MAPA DE RIESGOS</center>
    </h1>
    <?php echo $tabla;//str_replace('&nbsp;', '', ); ?>
    <h1>
        <center>ANÁLISIS RISK HUNTER +
    </h1>
    <br>
    <h2>
        <center>
            Niveles Por Riesgo
        </center>
    </h2>
    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter/MostrarPDF/Imagen_Grafica.png" ?>"
        alt="Gráfico de nivel de riesgos" width="500" height="300">
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
    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter/MostrarPDF/Imagen_Grafica2.png" ?>"
        alt="Gráfico de nivel de riesgos" width="500" height="300">
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php echo $ColorRiesgo2 ?>
    <?php
    if ($origen == 1) {
    ?>
    <h1>
        CALIFICACIÓN DE RIESGOS
        <?php 
                    include '../conexion.php';
                    $consultafi = $mysqli->query("SELECT f_ci($identificador) AS f_ci");
                    $extraer_f_ci = $consultafi->fetch_array(MYSQLI_ASSOC);
                    echo $f_ci = $extraer_f_ci['f_ci'];
                ?>
    </h1>
    <br>
    <?php
    } ?>
    <div class="page-break"></div>

    <h1>
        <center>CONVENCIONES</center>
        <br>
    </h1>
    <?php echo $convensiones; ?>
    <div class="page-break"></div>
    <h1>
        <center>REGISTRO FOTOGRAFICO</center>
    </h1>
    <?php if ($imagen != NULL) { ?>
    <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/risk_hunter" . str_replace("..", "", $imagen); ?>"
        width="250" height="250"><br>
    <label><?php echo $pie_de_pagina ?></label>
    <?php  } ?>
</body>

</html>