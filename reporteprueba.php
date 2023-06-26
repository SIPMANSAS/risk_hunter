    
    <style>
        #areaImprimir {
            margin: 2cm 1cm 1cm 1cm;
            border: black;
        }
        #map {

            width: 100%;
            height: 400px;
            background-color: grey;
        }
       
	    .preloader {
                width: 70px;
                height: 70px;
                border: 10px solid #eee;
                border-top: 10px solid #666;
                border-radius: 50%;
                animation-name: girar;
                animation-duration: 2s;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
                }
                @keyframes girar {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
                }
                
                @media print{
                    .oculto-impresion, .oculto-impresion *{
                        display: none !important;
                    }
                }
                
                html
                { 
                 overflow: hidden
                }
                
        .grafica {
            display: flex;
            justify-content: center;
            width:1106px; 
        }
	    
        
    </style>
    <center>
        <div class="preloader oculto-impresion" ></div> 
    </center>
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="stylesheet" href="style-screen.css" type="text/css" media="screen">
        <link rel="stylesheet" href="style-print.css" type="text/css" media="print">
       <script>
          // window.onmousemove = function(){
               alert('Generando Informe Por favor espere...');
           //}
       </script>
    <?php
    include 'conexion/conexion.php';
    
    $Dato = $_POST['Dato'];
    $identificador = $_POST['identificador'];
    $inspeccion = $_POST['inspeccion'];
    $firmainspectora = $_POST['firmainspectora'];
    $identificacion = $_POST['identificacion'];
    $tipodocumentosolicitante = $_POST['tipodocumentosolicitante'];
    $nombrepersonaatiende = $_POST['nombrepersonaatiende'];
    $fecha_solicitud = $_POST['fecha_solicitudB'];
    $contactofirma = $_POST['contactofirma'];
    $nombreasigna = $_POST['nombreasigna'];
    $pais = $_POST['pais'];
    $ciudad = $_POST['ciudad'];
    $direccion  = $_POST['direccion'];
    $nombreedificacion = $_POST['nombreedificacion'];
    $nombrepersonaatiende = $_POST['nombrepersonaatiende'];
    $contactopersonaatiende = $_POST['contactopersonaatiende'];
    $inspectorasignado = $_POST['inspectorasignado'];
    $bienes = $_POST['bienes'];
    $id_bienes = $_POST['id_bienes'];
    $observaciones = $_POST['observaciones'];
    $descripcion = $_POST['descripcion'];
    $oficina = $_POST['oficina'];
    $longitud = $_POST['longitud'];
    $latitud = $_POST['latitud'];
    $espaciogeografico = $_POST['espaciogeografico'];
    $estrato = $_POST['estrato'];
    $rt_f = $_POST['rt_f'];
    $mapa = $_POST['mapa'];
    $bloque_inspeccion = $_POST['bloque_inspeccion'];
  
    
    ?>
    
   
    <body id="bodyID">
        <h1>
        <center>La <?php echo $firmainspectora ?></center>
    </h1>
        <br><br>
        <center>
       <?php
        $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$identificador'");
        $extraerimagenprimera = $consultaimagenes->fetch_array(MYSQLI_ASSOC);
        $imagenprimera = $extraerimagenprimera['archivo'];
        if($imagenprimera != NULL){
        ?>      
            <div>
                <img src="<?php echo 'archivos/'.$imagenprimera; ?>" width="500" height="500"><br>
            </div>
        <?php
        }
       ?>
    </center>
        <br><br><br><br><br><br> <br><br><br><br><br><br><br><br><br><br><br><br><br>
        <h1>INFORME DE INSPECCIÓN DE RIESGOS <br> <?php echo $inspeccion ?></h1>
        <h2><?php echo $tipodocumentosolicitante.' '.$identificacion ?></h2>
        <br>
        <h2>Persona que atendió la inspección:<br> <?php echo $nombrepersonaatiende ?></h2>
        <br>
        <h2>Fecha de elaboaración: <?php echo $fecha_solicitud ?></h2>
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br>
        <h1 align='center'>DATOS BASICOS DE LA INSPECCIÓN <?php echo $primeraimagen;?></h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    <center>
        <table>
            <td><b><h2>Fecha de Solicitud de la inspección</b></h2></td>
            <td style="color:white">---------------------------------------</td>
            <td><h2><?php echo $fecha_solicitud?></h2></td>
            <tr></tr>
            <td><h2><b>Numero de Inspección</b></h2></td>
            <td></td>
            <td><h2><?php echo $inspeccion?></h2></td>
            <tr></tr>
            <td><h2><b>Firma Inspectora</b></h2></td>
            <td></td>
            <td><h2><?php echo $firmainspectora?></h2></td>
            <tr></tr>
            <td><h2><b>Número de contacto de la firma inspectora</b></h2></td>
            <td></td>
            <td><h2><?php echo $contactofirma?></h2></td>
            <tr></tr>
            <td><h2><b>Pais donde se realizó la inspección</b></h2></td>
            <td></td>
            <td><h2><?php echo $pais?></h2></td>
            <tr></tr>
            <td><h2><b>Ciudad donde se realizó la inspección </b></h2></td>
             <td></td>
            <td><h2><?php echo $ciudad?></h2></td>
            <tr></tr>
            <td><h2><b>Dirección de la inspección</b></h2></td>
             <td></td>
            <td><h2><?php echo $direccion?></h2></td>
            <tr></tr>
            <td><h2><b>Nombre del sitio a inspeccionar</b></h2></td>
             <td></td>
            <td><h2><?php echo $nombreedificacion?></h2></td>
            <tr></tr>
            <td><h2><b>Nombre de la persona que atendió la inspección</b></h2></td>
             <td></td>
            <td><h2><?php echo $nombrepersonaatiende?></h2></td>
            <tr></tr>
            <td><h2><b>Número de contacto de la persona que atendió la inspección</b></h2></td>
             <td></td>
            <td><h2><?php echo $contactopersonaatiende?></h2></td>
            <tr></tr>
            <td><h2><b>Inspector Asignado</b></h2></td>
            <td></td>
            <td><h2><?php echo $inspectorasignado?></h2></td>
            <tr></tr>
            <td><h2><b>Numero de contacto del inspector</b></h2></td>
            <td></td>
            <td><h2><?php echo $contactopersonaatiende?></h2></td>
            <tr></tr>
        </table>
    </center>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <h1 align='center'>INFORMACIÓN GEOESTACIONARIA</h1>
    <br>
    <br>
    <table class="table">
        <thead>
            <th><h2>Longitud</h2></th>
            <th style="color:white;">Latitud</th>
            <th style="color:white;">Latitud</th>
            <th><h2>Latitud</h2></th>
            <th style="color:white;">Latitud</th>
            <th style="color:white;">Latitud</th>
            <th><h2>Estrato</h2></th>
            <th style="color:white;">Latitud</th>
            <th style="color:white;">Latitud</th>
            <th><h2>Ubicación Sociogeografica</h2></th>
        </thead>
        <tbody>
            <tr>
              <td><?php echo $longitud?></td>
              <td style="color:white;">ESPA</td>
              <td style="color:white;">ESPA</td>
              <td><?php echo $latitud?></td>
              <td style="color:white;">ESPA</td>
              <td style="color:white;">ESPA</td>
              <td><?php echo $estrato?></td>
              <td style="color:white;">ESPA</td>
              <td style="color:white;"></td>
              <td><?php echo $espaciogeografico?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <div id="elid">
        <iframe src="//maps.google.com/maps?q=<?php echo $latitud ?>,<?php echo $longitud ?>&z=50&output=embed" width="1650" height="500"></iframe>
    </div>
    <br><br>
    <h2 align='center'>
        <?php
        $consultatextolinderos = $mysqli->query("SELECT p_informe_obligatorio($identificador) AS InformeO");
        $extraerDatosTextoLindero = $consultatextolinderos->fetch_array(MYSQLI_ASSOC);
        echo $textofinlalinderos = $extraerDatosTextoLindero['InformeO'];
        ?>
    </h2>
    
    <br><br><br><br><br>
    <h2 align='center'>LISTA DE BIENES</h2>
    <br><br>
    <table>
        <thead>
            <td style="color:white;">ESPA</td>
            <td style="color:white;">ESPA</td>
            <th>Descripción</th>
            <td style="color:white;">ESPA</td>
            <td style="color:white;">ESPA</td>
            <th>Observaciones</th>
        </thead>
        <tbdody>
                <?php 
               
                $consultabienes = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta='$identificador'");
                while($extraerDatos=$consultabienes->fetch_array()){
                ?>
                <tr>
                    <td style="color:white;">ESPA</td>
                    <td style="color:white;">ESPA</td>
                    <td><?php echo $extraerDatos['descripcion']?></td>
                    <td style="color:white;">ESPA</td>
                    <td style="color:white;">ESPA</td>
                    <td><?php echo $extraerDatos['observaciones']?></td>
                </tr>
                <?php
                }
                ?>
        </tbdody>
    </table>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <h1 align='center'>ANALISIS</h1>
    <?php 
    //SELECT `p_informe_completo`(@p0) AS `p_informe_completo`
    $consultaanalisis = $mysqli->query("SELECT p_informe_completo($identificador) AS p_informe_completo");
    while($extraerpreguntas=$consultaanalisis->fetch_array()){
    echo "<h2><p class='text-justify'>".$texto=$extraerpreguntas['p_informe_completo']."<p></h2>";
    }
    ?>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    
    <h2 align='center'>ANALISIS RISK HUNTER+</h2>
    <?php 
        $consulta_f_ci = $mysqli->query("SELECT f_ci($identificador) AS Parametro");
        $extraerDatos_f_ci = $consulta_f_ci->fetch_array(MYSQLI_ASSOC);
        $f_ci = $extraerDatos_f_ci['Parametro'];
    ?>
    
    <?php
                        $dbHost = 'localhost';
                        $dbUsername = 'u571892443_risk_hunter';
                        $dbPassword = '#6mL0I[Jd7ZW';
                        $dbName = 'u571892443_risk_hunter';
        
                        // Create connection and select db
                        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
                        
                        // Get data from database
                        $result = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = '$identificador' ORDER BY `riesgo` ASC");
                        ?>
         
                        <div class="contenedor">
                            <div id="piechart" class="grafica"></div>
                        </div>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([
                                      ['Language', '', { role: 'style' }],
                                      <?php
                                      if($result->num_rows > 0){
                                          while($row = $result->fetch_assoc()){
                                            echo "['" . utf8_encode($row['riesgo']) . "', " . $row['cr'] . ",'" . $row['color_cr'] . "'],";
                                          }
                                      }else{
                                          echo 'SIN DATOS';
                                      }
                                      ?>
                                ]);
                        
                                var options_val = {
                                        title: 'Calificación de riesgos <?php echo 'Parametro  '.$f_ci?> ',
                                        width: 1600,
                                        height: 1000,
                            };
        
                                var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));
        
                                chart.draw(data, options_val);
                            }
                        </script>        

    <h3 align='center'>DESCRIPCIÓN DE COLORES</h3>
    <table>
        <thead>
            <th style="color:white;">ESPA</th>
            <th style="color:white;">ESPA</th>
            <th>Color</th>
            <th style="color:white;">ESPA</th>
            <th style="color:white;">ESPA</th>
            <th>Descripción</th>
            <th style="color:white;">ESPA</th>
            <th style="color:white;">ESPA</th>
            <th>Valor Inicial</th>
            <th style="color:white;">ESPA</th>
            <th>Valor Final</th>
        </thead>
        
        <tbody>
           
            <?php
            $consultainformaciontablacolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_nr IS NOT NULL");
            while($extraerdatos = $consultainformaciontablacolores->fetch_array()){
            ?>
            <tr>
                <td></td>
                <td></td>
                <td><button size="10px" style="background-color:<?php echo $extraerdatos['codigo'] ?>"></button></td>
                <td></td>
                <td></td>
                <td><?php echo $extraerdatos['descripcion']?></td>
                <td></td>
                <td></td>
                <td><?php echo $extraerdatos['valor_inicial_nr']?></td>
                <td></td>
                <td><?php echo $extraerdatos['valor_final_nr']?></td>
            </tr>
            <?php
            }
            ?>
           
        </tbody>
    </table>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <h2 align='center'>NIVELES DE RIESGO</h2>
    <?php 
        $consulta_f_ci = $mysqli->query("SELECT f_ci($identificador) AS Parametro");
        $extraerDatos_f_ci = $consulta_f_ci->fetch_array(MYSQLI_ASSOC);
        $f_ci = $extraerDatos_f_ci['Parametro'];
    ?>
    
    <?php
                        $dbHost = 'localhost';
                        $dbUsername = 'u571892443_risk_hunter';
                        $dbPassword = '#6mL0I[Jd7ZW';
                        $dbName = 'u571892443_risk_hunter';
        
                        // Create connection and select db
                        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
                        
                        // Get data from database
                        $result = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = '$identificador' ORDER BY `riesgo`");
                        ?>
         
                        <div class="contenedor">
                            <div id="piechartB" class="grafica"></div>
                        </div>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([
                                     ['Language', '', { role: 'style' }],
                                      <?php
                                      if($result->num_rows > 0){
                                          while($row = $result->fetch_assoc()){
                                            echo "['" . utf8_encode($row['riesgo']) . "', " . $row['nr'] . ",'" . $row['color_nr'] . "'],"; //$row['descripcion_riesgo']
                                          }
                                      }else{
                                          echo 'SIN DATOS';
                                      }
                                      ?>
                                ]);
                        
                                var options_val = {
                                        title: 'Niveles de riesgo',
                                        width: 1600,
                                        height: 1000,
                            };
        
                                var chart = new google.visualization.ColumnChart(document.getElementById('piechartB'));
        
                                chart.draw(data, options_val);
                            }
                        </script>
                        
                        <h3 align='center'>DESCRIPCIÓN DE COLORES</h3>
    <table>
        <thead>
            <th style="color:white;">ESPA</th>
            <th style="color:white;">ESPA</th>
            <th>Color</th>
            <th style="color:white;">ESPA</th>
            <th style="color:white;">ESPA</th>
            <th>Descripción</th>
            <th style="color:white;">ESPA</th>
            <th style="color:white;">ESPA</th>
            <th>Valor Inicial</th>
            <th style="color:white;">ESPA</th>
            <th>Valor Final</th>
        </thead>
        
        <tbody>
           
            <?php
            $consultainformaciontablacolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_cr IS NOT NULL");
            while($extraerdatos = $consultainformaciontablacolores->fetch_array()){
            ?>
            <tr>
                <td></td>
                <td></td>
                <td><button type="" style="background-color:<?php echo $extraerdatos['codigo'] ?>"></button></td>
                <td></td>
                <td></td>
                <td><?php echo $extraerdatos['codigo']?></td>
                <td></td>
                <td></td>
                <td><?php echo $extraerdatos['descripcion']?></td>
                <td></td>
                <td></td>
                <td><?php echo $extraerdatos['valor_inicial_cr']?></td>
                <td></td>
                <td><?php echo $extraerdatos['valor_final_cr']?></td>
            </tr>
            <?php
            }
            ?>
           
        </tbody>
    </table>
    <br><br><br><br><br>
     <h3 align='center'>MAPA DE RIESGOS</h2>
    
   <style>
        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
        }
        
        .verticalTextB {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            min-height: 114;
        }
        
        
        
  </style>
<?php


////////////////////////////////////// TAMAÑO DE LA MATRIZ  ///////////////////////////////////////////////////////////////////////////////////////////
$consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
$consultamatriz = $mysqli->query("SELECT f_dimension_matriz() AS Matriz");
$extraerDatos = $consultamatriz->fetch_array(MYSQLI_ASSOC);
$tamano_matriz = $extraerDatos['Matriz'];

$filas = $tamano_matriz;
$columnas = $tamano_matriz;
$textoF = strval($filas+1);
$textoC = strval($filas+3);
$numero = 1;
///////////////////////////////////////// END  TAMAÑO DE LA MATRIZ /////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
$tabla = "<table border='1' width='93%' height='93%'>";
$color_actual = ' ';
$tabla .= "<th colspan='4' style='background-color:#00E0FF'><h2><h2></th>";
$tabla .= "<th colspan='$textoF+$columnas' style='background-color:#00E0FF'><h3>Impacto o Intensidad<h3></th>";
$tabla .= "<tr>";
$tabla .= "";

///////////////////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////////////////////////////////////////////

$consultaFilas = $mysqli->query("SELECT D.nombre,D.identificador ,COUNT(D.identificador) AS Cantidad FROM mat_filas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY `D`.`identificador` DESC");
//////////////////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
$tabla.="   <td class='verticalText' style='background-color:#00E0FF' colspan='3' rowspan='$textoC'>
                <h3>
                    <center>Probabilidad(%)</center>
                </h3>
            </td>
            <td rowspan='$textoC'>
                <table border='1'>";
                
                //////////////////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
                
                //////////////////////////////////AQUI INICIA DONDE SE PINTAN LAS COLUMNAS DE PROBABILIDAD //////////////////////////////////////////////////////////////////////////////////////
                $consultarangos= $mysqli->query("SELECT DISTINCT nombre ,COUNT(nombre) Cantidad FROM mat_filas  C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador DESC");
                $tabla .="<br><br><br>";
                while($extraermatcolumnas = $consultarangos->fetch_array()){
                    $extraermatcolumnas['Cantidad'].'-'.$extraermatcolumnas['nombre'];
                    $ancho = $extraermatcolumnas['Cantidad'];
                    $tabla .= "<td widht='$ancho' colspan='6' class='verticalTextB' ><b>".$extraermatcolumnas['nombre']."</center><b></td><tr>";
                     
                }
                $tabla .="</tr>";
                //$tabla .="<tr>";
                
                $tabla.="</table>
            </td>
            
            ";
            //////////////////////////////////////// END PINTA LOS TITULOS LAS COLUMNAS DE PROBABILIDAD /////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////// CONSULTA LABELS HORIZONTALES (TITULOS IMPACTO (MUY BAJO, BAJO ,MEDIO ,ETC....))//////////////////////////////////////////////////////////////////////////////
$consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
$consultaColumnas = $mysqli->query("SELECT D.identificador ,COUNT(D.identificador) AS Cantidad,D.nombre FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY D.identificador DESC");
while($extraerDatos = $consultalabelshorizontales->fetch_array()){
    while($extraerlongitudes = $consultaColumnas->fetch_array()){
        $tabla .= "<td colspan='".$extraerlongitudes['Cantidad']."'><b><center>".$extraerlongitudes['nombre']."</center><b></td>";
    }
}
$tabla .="<tr>";
/////////////////////////////////////////////////////////////// END CONSULTA LABELS HORIZONTALES (TITULOS IMPACTO (MUY BAJO, BAJO ,MEDIO ,ETC....)) ///////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////// CONSULTA RANGOS IMPACTO O INTENSIDAD /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$consultarangos= $mysqli->query("SELECT * FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador;");
//while($extraermatcolumnas = $consultarangos->fetch_array()){
  //  $tabla .= "<td style='background-color:#C9C6C4'>".'> '.$extraermatcolumnas['valor_inicial'].'% - = '.$extraermatcolumnas['valor_final'].'%'."</td>";
//}
///////////////////////////////////////////////////////////////////// END CONSULTA RANGOS IMPACTO O INTENSIDAD  ///////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////// FOR PARA PINTAR EL CONTENIDO DE LA MATRIZ //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$numeracion = $filas;

for($i = 1; $i <= $filas; $i++) {
    
    $tabla .= "<tr>";

    for($j = 1; $j <= $columnas; $j++) {
                                                                        
             $hay_color = $mysqli->query("SELECT MC.codigo,COUNT(1) AS Cantidad 
                                                                        FROM par_pintar_matriz PM,mat_colores MC
                                                                        WHERE fila='$i' 
                                                                        AND col_inicio_color = '$j'
                                                                        AND MC.identificador = PM.color
                                                                        GROUP BY MC.codigo;");
                                        $datocolor = $hay_color->fetch_array(MYSQLI_ASSOC);
                                        $colorCantidad = $datocolor['Cantidad'];
                                        $color= $datocolor['codigo'];
            if($colorCantidad > 0){
                $color_actual = $color;
            } 
            $texto_celdas = $mysqli->query("SELECT f_texto_matriz($i,$j,$identificador) AS texto_matriz");
            $extraerDatosCelda = $texto_celdas->fetch_array(MYSQLI_ASSOC);
             $datoceldas = $extraerDatosCelda['texto_matriz'];
           
            $tabla .= "<td border='0' valign='top' style='background:$color_actual;font-size:10px' > ".$datoceldas.' '."</td>";
        $numero++;

    }

    $tabla .= "</tr>";

}
//////////////////////////////////////////////////////////////////////////// FIN PINTA MATRIZ CON COLORES (COMPLETA) ////////////////////////////////////////////////////////////////////////////////////////////
$tabla .= "</table>";

echo $tabla;

///////////////////////////////////////////////////////////////////////////////////////////////////END /////////////////////////////////////////////////////////////////////////////////////////////////////
        ?>
    </div>
   <br>
   <br>
    <h2 align='center'>TABLA DE CONVENCIONES</h2>
    <br>
    <br>
    <br>
    <table>
        <thead>
            <td style="color:white;">ESPA</td>
            <td style="color:white;">ESPA</td>
            <td style="color:white;">ESPA</td>
            <td style="color:white;">ESPA</td>
            <th>Descripción</th>
        </thead>
        <tbdody>
                <?php 
                include 'conexion/conexion.php';
                $consultabienes = $mysqli->query("SELECT * FROM v_matriz_r_b WHERE id_inspeccion='$identificador' AND nr<>0");
                while($extraerDatos=$consultabienes->fetch_array()){
                ?>
                <tr>
                    <td style="color:white;">ESPA</td>
                    <td style="color:white;">ESPA</td>
                    <td style="color:white;">ESPA</td>
                    <td style="color:white;">ESPA</td>
                    <td><?php echo $extraerDatos['dsp_riesgo']?></td>
                </tr>
                <?php
                }
                ?>
        </tbdody>
    </table>
    <br>
    
    
    <?php
    $consultatablaconveciones=$mysqli->query("SELECT id_alfanumerico,nombre FROM `cg_valores_dominio` VD,enc_calificacion_riesgos_inmueble RI WHERE id_dominio IN (SELECT identificador FROM cg_dominios WHERE id_grupo_dominio = 3) AND RI.id_inspeccion = '$identificador' AND RI.id_riesgo = VD.identificador ORDER BY 1;")
    ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    
    <h2 align='center'>REGISTRO FOTOGRAFICO</h2>
     <br><br><br><br><br><br> <br><br><br><br><br><br>
     <div class="contenedor">
        <style>
        /*Agregramos el estilo para separar por cada 3 columna las img*/
            .wrapper {
              display: grid;
              grid-template-columns: repeat(3, 1fr);
              grid-gap: 5px;
            }
        /*end*/
        </style>
        <center>
            <div class="wrapper">
                <?php
                $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$identificador'");
                 while($extraerimagen = $consultaimagenes->fetch_array()){
                $imagen = $extraerimagen['archivo'];
                $pie_de_pagina = $extraerimagen['pie_de_imagen'];
                    if($imagen != NULL){
                
                ?>      
                    <div>
                        <img src="<?php echo 'archivos/'.$imagen; ?>" width="250" height="250"><br>
                        <label><?php echo $pie_de_pagina ?></label>
                    </div>
                <?php
                     
                    }
                }
                ?>
            </div>
        </center>
     </div>
</div>

<!--<button type="button" id="btn" onclick="printDiv('paginaImpresion')" value="" style="display:none">Imprimir</button>-->
<!-- Este botón simula el click para ubicar el div del mapa -->
<button id="action-buttonDireccion" onclick="moverseA('elid')" style="display:none;"></button> 
<!-- end -->

<!-- Este botón simula el click para imprimir -->
<button type="button" id="action-button" onclick="window.print();return false;" style="display:none;"></button>
<!-- end -->
 <script src="js/librAjax.js"></script>
    <script>
    
        //// agregamos el evento para llevar al div mapa
        function moverseA(idDelElemento) {
          location.hash = "#" + idDelElemento;
        }
        
        $(document).ready(function() {
            // indicamos que se ejecuta la funcion a los 5 segundos de haberse
            // cargado la pagina
            setTimeout(clickbuttonDireccion, 0000);
                
            function clickbuttonDireccion() { 
            // simulamos el click del mouse en el boton del formulario
                $("#action-buttonDireccion").click();
                //alert("Aqui llega"); //Debugger
            } 
                $('#action-buttonDireccion').on('click',function() {
                    // console.log('action');
                });
        });
        /// end
        
       
        
        //// botón automatico para imprimir
        $(document).ready(function() {
            // indicamos que se ejecuta la funcion a los 5 segundos de haberse
            // cargado la pagina
            setTimeout(clickbutton, 0000);
                                
            function clickbutton() {
            // simulamos el click del mouse en el boton del formulario
                $("#action-button").click();
                //alert("Aqui llega"); //Debugger
                   //document.getElementById('bodyID').style.display = 'none';
                }
                $('#action-button').on('click',function() {
                    // console.log('action');
                });
        });
        //// end
        
        //// llamado de event cancelar del imprimir, para cerrar la ventana
        window.onafterprint = () => { //Al cancelar/guardar la impresión
            window.close();
        }
        //// end
    </script>
</body>