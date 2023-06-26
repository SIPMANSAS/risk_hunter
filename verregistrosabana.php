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

      <script>
        $(document).ready(function() {
          $('#search').on('keyup', function() {
            var search = $(this).val();
            var dataString = 'search=' + search;
            var parametros = {
              "search": search,
            }
            //url: "funcioness/obtienesearchfirmas.php",
            $.ajax({
              type: "POST",
              url: "funcioness/obtienesearchencabezadofirmas.php",
              data: parametros,
              success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function() {
                  //Obtenemos la id unica de la sugerencia pulsada
                  var id = $(this).attr('id');
                  //Editamos el valor del input con data de la sugerencia pulsada
                  $('#search').val($('#' + id).attr('data'));

                  //Hacemos desaparecer el resto de sugerencias
                  $('#sugerencia').fadeOut(1000);
                  $('#identificau').val(id);
                  $('#idusuario').val(id);
                  $('#identifu').val('d');
                  $('#ident').val(id);


                  document.getElementById('form').submit();
                  return false;
                });
              }
            });
          });
        });
      </script>

    </head>

    <body>
      <?php
      /*
            include "conexion/Conexion2.php";
            include_once  "clases/Json.class.php";
            $db =  connect();
            $query = $db->query("select * from rg_paises");
            $countries = array();
            while ($r = $query->fetch_object()) {
              $countries[] = $r;
            }*/
      ?>

      <?php include 'header-rh.php'; ?>
      <?php

      if (isset($_POST["identificau"]))
        $identificador = $_POST["identificau"];
      elseif (isset($_POST["idusuario"]))
        $identificador = $_POST["idusuario"];
      else
        $identificador = "1";
      $filtro = "1";
      if (isset($_POST["identificau"]) or (isset($_POST["idusuario"]))) {
        /* entrada al metodo post para mostrar informacion de usuario y actualizar */

        if (isset($_POST["identificau"]))
          $identificador = $_POST["identificau"];
        elseif (isset($_POST["idusuario"]))
          $identificador = $_POST["idusuario"];
      }
      $id_inspeccion = $_POST['id'];
      ?>

      <div class="titulo_p">
        <center><i class="fa-solid fa-file"></i> CONSULTA COMPLETA DE INSPECCIONES</center>
      </div>
      <div class="link_int">
        <div class="titulo2"><i class="fa-solid fa-list"></i><a href="listasabana.php"> Regresar</a></div>
        <div class="titulo3">
          <form action="exportacion/exportainformacionsabanacompleta.php" method="POST">
            <input type="hidden" name="id_inspeccion" value="<?php echo $id_inspeccion ?>">
            <button type="submit"><i class="fa-solid fa-download"></i> Exportar</button>
          </form>
        </div>
      </div>
      <div class="contenedor_titulos">
        <div class=" titulo">Número de <br>Inspección</div>
        <div class=" titulo"><b>Fecha Solicitud</b></div>
        <div class=" titulo">Compañía de <br> Seguros</div>
        <div class=" titulo">Nombre de <br> Quien Asigna</div>
        <div class=" titulo"><b>Ubicación de <br>realización</b></div>
        <div class=" titulo"><b>Nombre edificación</b></div>
        <div class=" titulo"><b>Dirección del <br>bien</b></div>
        <div class=" titulo"><b>Fecha de <br>inspección</b></div>
        <div class=" titulo"><b>Fecha de <br>actualizacion</b></div>
        <div class=" titulo"><b>Quien realizo la <br>actualizacion</b></div>
      </div>

      <?php
      if (isset($_POST['ident'])) {
        //echo 'ENTRA BOTON ID';
        $id_inspeccion = $_POST['id'];
        $consultabuscador = $mysqli->query("SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion'");
        $extraerdatos = $consultabuscador->fetch_array(MYSQLI_ASSOC);
        $numero_inspeccion = $extraerdatos['numero_inspeccion'];
        $fecha_solicitud = $extraerdatos['fecha_solicitud'];
        $companiaseguros = $extraerdatos['cia_seguros'];
        $nombreasigna = $extraerdatos['nombre_asigna'];
        $pais_id = $extraerdatos['pais'];
        $departamento_id = ($extraerdatos['departamento']);
        $ciudad = $extraerdatos['ciudad'];
        $direccion = $extraerdatos['direccion'];
        $fechainspeccion = $extraerdatos['fecha_inspeccion'];
        $identificador = $extraerdatos['identificador'];
        $fecha_actualizacion = $extraerdatos['fecha_actualizacion'];
        $usuarioactualizacion = $extraerdatos['usuario_actualizacion'];

        $nombresolicita = $extraerdatos['nombre_solicita'];
        $tipodocumentosolicitante = $extraerdatos['des_td_solicitante'];
        $numeroidentificacio = $extraerdatos['nid_solicita'];
        $tomador = $extraerdatos['tomador'];
        $npersonaatiende = $extraerdatos['nombre_persona_atiende'];
        $cpersonaatiende = $extraerdatos['contacto_persona_atiende'];
        $asegurado = $extraerdatos['asegurado'];
        $direccion = $extraerdatos['direccion'];


        $inspectorasignadoF = $extraerdatos['nombre_inspector'];
        $contactofirma = $extraerdatos['contacto_firma'];
        $inspectorasignado = $extraerdatos['inspectorasignado'];
        $oficinaB = $extraerdatos['nombre_oficina'];
        $firmainspectora = $extraerdatos['firma_inspectora'];
        $nombreedificacion = $extraerdatos['nombre_edificacion'];
        $fecha_posible_inspeccion = $extraerdatos['fecha_posible_inspeccion'];

        $estado = $extraerdatos['estado'];

        $longitud = $extraerdatos['longitud'];
        $latitud = $extraerdatos['latitud'];
        $espaciogeografico = $extraerdatos['espacio_geografico'];
        $estrato = $extraerdatos['estrato'];

      ?>
        <div class="contenedor">
          <div class="campos_f">
            <?php
            echo $identificador = $extraerdatos['numero_inspeccion'];
            ?>
          </div>
          <div class="campos_f">
            <?php echo $fecha_solicitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $companiaseguros; ?>
          </div>
          <div class="campos_f">
            <?php echo $nombreasigna; ?>
          </div>
          <div class="campos_f">
            <?php echo $departamento_id . '-' . $ciudad; ?>
          </div>
          <div class="campos_f">
            <?php echo ($nombreedificacion); ?>
          </div>
          <div class="campos_f">
            <?php echo $direccion; ?>
          </div>

          <div class="campos_f">
            <?php echo $fecha_posible_inspeccion; ?>
          </div>

          <div class="campos_f">
            <?php echo $fecha_actualizacion; ?>
          </div>

          <div class="campos_f">
            <?php
            $informacionusuario = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador = '$usuarioactualizacion'");
            $extraerDatos = $informacionusuario->fetch_array(MYSQLI_ASSOC);
            $datos_usuario_actualizacion = $extraerDatos['nombre'] . ' ' . $extraerDatos['apellidos'];
            echo $datos_usuario_actualizacion;
            ?>
          </div>
        </div>
        <br>
        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-user"></i> INFORMACIÓN SOLICITANTE </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Solicitante</div>
          <div class=" titulo">Número de <br>Identificación</div>
          <div class=" titulo"><b>Tomador</b></div>
          <div class=" titulo">Encargado de <br>atender la inspección</div>
          <div class=" titulo"><b>Contacto del encargado</b></div>
          <div class=" titulo">Asegurado</div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php echo ($nombresolicita); ?>
          </div>
          <div class="campos_f">
            <?php echo $tipodocumentosolicitante . ' ' . $numeroidentificacio; ?>
          </div>
          <div class="campos_f">
            <?php echo utf8_decode($tomador) ?>
          </div>
          <div class="campos_f">
            <?php echo ($npersonaatiende); ?>
          </div>
          <div class="campos_f">
            <?php echo ($cpersonaatiende); ?>
          </div>
          <div class="campos_f">
            <?php echo ($asegurado); ?>
          </div>
        </div>
        </div>


        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-search"></i> INFORMACIÓN INSPECTOR - FIRMA INSPECTORA </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Firma Inspectora</div>
          <div class=" titulo"><b>Contacto Firma</b></div>
          <div class=" titulo">Compañía de <br> Seguros</div>
          <div class=" titulo">Oficina</div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php
            echo $firmainspectora;
            ?>
          </div>
          <div class="campos_f">
            <?php echo $contactofirma; ?>
          </div>
          <div class="campos_f">
            <?php echo $companiaseguros; ?>
          </div>
          <div class="campos_f">
            <?php echo $oficinaB; ?>
          </div>
        </div>
        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-location-dot"></i> UBICACIÓN GEOESTACIONARIA</center>
          <?php
          $bloques    = new bloques;
          $consulta = $bloques->iniciarVariables();
          $filtro = $id_inspeccion;
          $consultainmuebles = $bloques->consultainmuebles($filtro);
          ?>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Longitud</div>
          <div class=" titulo"><b>Latitud</b></div>
          <div class=" titulo"><b>Estrato</b></div>
          <div class=" titulo"><b>Espacio Sociogeografico</b></div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php echo $longitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $latitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $estrato; ?>
          </div>
          <div class="campos_f">
            <?php echo $espaciogeografico; ?>
          </div>
        </div>
        <div class="contenedor">
          <iframe width="1770" height="500" src="https://maps.google.com/maps?q=<?php echo $latitud; ?>,<?php echo $longitud; ?>&output=embed"></iframe>
        </div>

        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-check"></i> INFORMACIÓN DE BIENES A INSPECCIONAR</center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Identificador</div>
          <div class=" titulo">Bien Principal</div>
          <div class=" titulo">Inmueble</div>
          <div class=" titulo">Tipo de Inmueble</div>
          <div class=" titulo">Dirección</div>
          <div class=" titulo">Acciones</div>
        </div>
        <?php

        while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)) {
        ?>
          <div class="contenedor">
            <form action="verinmuebles.php" id="form" method="POST">
              <input type="hidden" value="<?php echo $id = $extraerDatos['identificador'] ?>" name="identificador">
              <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
              <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
            </form>
            <div class="campos_f">
              <?php echo $identificadorI = $extraerDatos['identificador']; ?>
            </div>
            <div class="campos_f">
              <?php echo ($extraerDatos['bien_contenedor']); ?>
            </div>
            <div class="campos_f">
              <?php echo ($extraerDatos['descripcion']); ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['tipo_de_bien']; ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['observaciones']; ?>
            </div>
            <div class="campos_f">
              <form action="detalleinspeccion.php" method="POST" target="_blank">
                <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_encuesta">
                <input type="hidden" value="<?php echo $id = $extraerDatos['identificador'] ?>" name="identificador">
                <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                <button class="btn_azul" name="inspeccionar">Consultar</button>
              </form>


              <form action="riesgosinmueble.php" method="GET" target="_blank">
                <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador">
                <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_encuesta">
                <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                <button class="btn_verde">Calificación<br>Riesgos</button>
              </form>
              <?php
              /*
                          openWindow()
                           <form action="asignarinspectores.php" method="POST">
                              <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                              <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                              <button class="btn_verde" type="submit">Asignar Inspectores</button>
                          </form>
                          */
              ?>
            </div>
          </div>

        <?php
        }
        ?>
        <br>

        <div class="titulo_p">
          <center><i class="fa-solid fa-image"></i> REGISTRO FOTOGRAFICO </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo"><b>Ver Imagenes</b></div>
        </div>
        <div class="contenedor">
          <a class="btn_verde" href="javascript:popUp('verregistrofotografico.php?idinspeccion=<?php echo $id_inspeccion ?>')">Ver Imagenes</a>
          <? php/*
                        $id_inspeccion;
                        $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$id_inspeccion'");
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
                        */
          ?>
        </div>
        <script type="text/javascript">
          function popUp(URL) {
            window.open(URL, 'Nombre de la ventana', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=300,height=200,left = 390,top = 50');
          }
        </script>
        <br>
       
        <div class="titulo_p">
          <center><i class="fa-solid fa-grid-2"></i> MATRIZ DE RIESGOS </center>
        </div>

        <div class="contenedor_titulos">
          <div class="titulo">Matriz de riesgos</div>
        </div>

        <center>
          <div class="contenedor center">
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

              .table {
                width: 50%;
                height: 300px;
              }

              .center {
                display: flex;
                align-items: center;
                justify-content: center;
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
            $textoF = strval($filas + 1);
            $textoC = strval($filas + 3);
            $numero = 1;
            ///////////////////////////////////////// END  TAMAÑO DE LA MATRIZ /////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //////////////////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
            $tabla = "<table border='1' width='60' height='60'>";
            $color_actual = ' ';
            $tabla .= "<th colspan='4' style='background-color:#00E0FF'><h2><h2></th>";
            $tabla .= "<th colspan='$textoF+$columnas' style='background-color:#00E0FF'><h3>Impacto o Intensidad<h3></th>";
            $tabla .= "<tr>";
            $tabla .= "";

            ///////////////////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $consultaFilas = $mysqli->query("SELECT D.nombre,D.identificador ,COUNT(D.identificador) AS Cantidad FROM mat_filas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY `D`.`identificador` DESC");
            //////////////////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
            $tabla .= "   <td class='verticalText' style='background-color:#00E0FF' colspan='3' rowspan='$textoC'>
                                            <h3>
                                                <center>Probabilidad(%)</center>
                                            </h3>
                                        </td>
                                        <td rowspan='$textoC'>
                                            <table border='1'>";

            //////////////////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////

            //////////////////////////////////AQUI INICIA DONDE SE PINTAN LAS COLUMNAS DE PROBABILIDAD //////////////////////////////////////////////////////////////////////////////////////
            $consultarangos = $mysqli->query("SELECT DISTINCT nombre ,COUNT(nombre) Cantidad FROM mat_filas  C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador DESC");
            $tabla .= "<br><br><br>";
            while ($extraermatcolumnas = $consultarangos->fetch_array()) {
              $extraermatcolumnas['Cantidad'] . '-' . $extraermatcolumnas['nombre'];
              $ancho = $extraermatcolumnas['Cantidad'];
              $tabla .= "<td widht='$ancho' class='verticalTextB' ><b>" . $extraermatcolumnas['nombre'] . "</center><b></td><tr>";
            }
            $tabla .= "</tr>";
            //$tabla .="<tr>";

            $tabla .= "</table>
                                        </td>
                                        
                                        ";
            //////////////////////////////////////// END PINTA LOS TITULOS LAS COLUMNAS DE PROBABILIDAD /////////////////////////////////////////////////////////////////////

            ////////////////////////////////////////////////////// CONSULTA LABELS HORIZONTALES (TITULOS IMPACTO (MUY BAJO, BAJO ,MEDIO ,ETC....))//////////////////////////////////////////////////////////////////////////////
            $consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
            $consultaColumnas = $mysqli->query("SELECT D.identificador ,COUNT(D.identificador) AS Cantidad,D.nombre FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY D.identificador DESC");
            while ($extraerDatos = $consultalabelshorizontales->fetch_array()) {
              while ($extraerlongitudes = $consultaColumnas->fetch_array()) {
                $tabla .= "<td colspan='" . $extraerlongitudes['Cantidad'] . "'><b><center>" . $extraerlongitudes['nombre'] . "</center><b></td>";
              }
            }
            $tabla .= "<tr>";
            /////////////////////////////////////////////////////////////// END CONSULTA LABELS HORIZONTALES (TITULOS IMPACTO (MUY BAJO, BAJO ,MEDIO ,ETC....)) ///////////////////////////////////////////////////////////////////

            /////////////////////////////////////////////////////////// CONSULTA RANGOS IMPACTO O INTENSIDAD /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $consultarangos = $mysqli->query("SELECT * FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador;");
            //while($extraermatcolumnas = $consultarangos->fetch_array()){
            //  $tabla .= "<td style='background-color:#C9C6C4'>".'> '.$extraermatcolumnas['valor_inicial'].'% - = '.$extraermatcolumnas['valor_final'].'%'."</td>";
            //}
            ///////////////////////////////////////////////////////////////////// END CONSULTA RANGOS IMPACTO O INTENSIDAD  ///////////////////////////////////////////////////////////////////////////////////////////////

            ////////////////////////////////////////////// FOR PARA PINTAR EL CONTENIDO DE LA MATRIZ //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $numeracion = $filas;

            for ($i = 1; $i <= $filas; $i++) {

              $tabla .= "<tr>";

              for ($j = 1; $j <= $columnas; $j++) {

                $hay_color = $mysqli->query("SELECT MC.codigo,COUNT(1) AS Cantidad 
                                                                                                    FROM par_pintar_matriz PM,mat_colores MC
                                                                                                    WHERE fila='$i' 
                                                                                                    AND col_inicio_color = '$j'
                                                                                                    AND MC.identificador = PM.color
                                                                                                    GROUP BY MC.codigo;");
                $datocolor = $hay_color->fetch_array(MYSQLI_ASSOC);
                $colorCantidad = $datocolor['Cantidad'];
                $color = $datocolor['codigo'];
                if ($colorCantidad > 0) {
                  $color_actual = $color;
                }
                $texto_celdas = $mysqli->query("SELECT f_texto_matriz($i,$j,$id_inspeccion) AS texto_matriz");
                $extraerDatosCelda = $texto_celdas->fetch_array(MYSQLI_ASSOC);
                $datoceldas = $extraerDatosCelda['texto_matriz'];

                $tabla .= "<td border='0' valign='top' style='background:$color_actual;font-size:10px;padding-right: 10px;' > " . $datoceldas . ' ' . "</td>";
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
        </center>
        <!--<div class="contenedor">
                           <iframe width="1250" height="1250"  src="matrizframe.php"  align="center"></iframe>
                    </div>-->
        

        <div class="titulo_p">
          <center><i class="fa-solid fa-info"></i> TABLA DE DESCRIPCIÓN DE COLORES GRAFICA GENERAL DE RIESGOS </center>
        </div>
        <div class="contenedor_titulos">
            <div class="titulo">Descripción de Colores Por Riesgo</div>
        </div>
        <div class="contenedor">
           <div class=" titulo">Descripción</div>
           <div class=" titulo"><b>Valor Calificación Inicial</b></div>
           <div class=" titulo"><b>Valor Calificación Final</b></div>
           <div class=" titulo"><b>Sugerencias</b></div>
           
        </div>
        
            <?php
            $consultavaloresdescripcioncolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_cr IS NOT NULL");
            while($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores->fetch_array()){
            ?>
            <div class="contenedor">
                <div class="campos_f">
                 <button type="" style="background-color:<?php echo $extraerDatosdescripcioncolores['codigo'] ?>"><?php echo $identificadorI = $extraerDatosdescripcioncolores['descripcion']; ?></button>
                </div>
                 <div class="campos_f">
                  <?php echo $identificadorI = $extraerDatosdescripcioncolores['valor_inicial_cr']; ?>
                </div>
                <div class="campos_f">
                  <?php echo $identificadorI = $extraerDatosdescripcioncolores['valor_final_cr']; ?>
                </div>
                <div style="background-color:<?php echo $extraerDatosdescripcioncolores['codigo'] ?>" class="campos_f">
                     <?php echo $identificadorI = '<b>'.$extraerDatosdescripcioncolores['descripcion_texto_cr'].'</b>'; ?>
                </div>
            </div>
            <?php
            }
            ?>
        <br>

        <div class="titulo_p">
          <center><i class="fa-solid fa-signal"></i> GRAFICA GENERAL DE RIESGOS </center>
        </div>
        <?php
        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';

        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Get data from database
        $result = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = '$id_inspeccion' ORDER BY `riesgo` ASC;");
        ?>
        <div class="contenedor_titulos">
          <div class="titulo">Grafica General de Riesgos</div>
        </div>

        <div class="contenedor">
          <div id="piechart"></div>
        </div>
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['corechart']
          });

          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Language', '', { role: 'style' }],
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                echo "['" . utf8_encode($row['riesgo']) . "', " . $row['cr'] . ",'" . $row['color_cr'] . "'],";
                }
              } else {
                echo 'SIN DATOS';
              }
              ?>
            ]);

            var options_val = {
              title: 'Calificación de riesgos',
              width: 1615,
              height: 500,
              legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));

            chart.draw(data, options_val);
          }
        </script>
        <script type="text/javascript">
          function popUp(URL) {
            window.open(URL, 'Nombre de la ventana', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=1500,height=1500,left = 0,top = 0');
          }
        </script>
        
         <div class="titulo_p">
          <center><i class="fa-solid fa-info"></i> TABLA DE DESCRIPCIÓN DE COLORES NIVELES DE RIESGO </center>
        </div>
        <div class="contenedor_titulos">
            <div class="titulo">Descripción de Colores Nivel de Riesgo</div>
        </div>
        <div class="contenedor">
           <div class=" titulo">Descripción</div>
           <div class=" titulo"><b>Valor Nivel Inicial</b></div>
           <div class=" titulo"><b>Valor Nivel Final</b></div>
           <div class=" titulo"><b>Sugerencias</b></div>
        </div>
        
             <?php
            $consultavaloresdescripcioncolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_nr IS NOT NULL");
            while($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores->fetch_array()){
            ?>
            <div class="contenedor">
                <div class="campos_f">
                 <button type="" style="background-color:<?php echo $extraerDatosdescripcioncolores['codigo'] ?>"><?php echo $identificadorI = $extraerDatosdescripcioncolores['descripcion']; ?></button>
                </div>
                 <div class="campos_f">
                  <?php echo $identificadorI = $extraerDatosdescripcioncolores['valor_inicial_nr']; ?>
                </div>
                <div class="campos_f">
                  <?php echo $identificadorI = $extraerDatosdescripcioncolores['valor_final_nr']; ?>
                </div>
                <div style="background-color:<?php echo $extraerDatosdescripcioncolores['codigo'] ?>" class="campos_f">
                     <?php echo $identificadorI = '<b>'.$extraerDatosdescripcioncolores['descripcion_texto_nr'].'</b>'; ?>
                </div>
            </div>
            <?php
            }
            ?>
        <br>
        
        
        <div class="titulo_p">
          <center><i class="fa-solid fa-signal"></i> NIVEL DE RIESGO </center>

        </div>
        <?php
        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';

        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Get data from database
        $result = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = '$id_inspeccion' ORDER BY `riesgo` ASC;");
        ?>
        <div class="contenedor_titulos">
          <div class="titulo">Grafica Niveles de Riesgo</div>
        </div>

        <div class="contenedor">
          <div id="piechartB"></div>
        </div>
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Language', '', { role: 'style' }],
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "['" . utf8_encode($row['riesgo']) . "', " . $row['nr'] . ",'" . $row['color_nr'] . "'],"; //$row['descripcion_riesgo']
                }
              } else {
                echo 'SIN DATOS';
              }
              ?>
            ]);

            var options_val = {
              title: 'Nivel de riesgos',
              width: 1615,
              height: 500,
              legend: 'none'
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('piechartB'));

            chart.draw(data, options_val);
          }
        </script>
      <?php
      } else {
        // echo 'BUSQUEDA';
        $id_inspeccion = $_POST['id'];
        $consultabuscador = $mysqli->query("SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion'");
        $extraerdatos = $consultabuscador->fetch_array(MYSQLI_ASSOC);
        $numero_inspeccion = $extraerdatos['numero_inspeccion'];
        $fecha_solicitud = $extraerdatos['fecha_solicitud'];
        $companiaseguros = $extraerdatos['cia_seguros'];
        $nombreasigna = $extraerdatos['nombre_asigna'];
        $pais_id = $extraerdatos['pais'];
        $departamento_id = ($extraerdatos['departamento']);
        $ciudad = $extraerdatos['ciudad'];
        $direccion = $extraerdatos['direccion'];
        $fechainspeccion = $extraerdatos['fecha_inspeccion'];
        $identificador = $extraerdatos['identificador'];

        $nombresolicita = $extraerdatos['nombre_solicita'];
        $tipodocumentosolicitante = $extraerdatos['des_td_solicitante'];
        $numeroidentificacio = $extraerdatos['nid_solicita'];
        $tomador = $extraerdatos['tomador'];
        $npersonaatiende = $extraerdatos['nombre_persona_atiende'];
        $cpersonaatiende = $extraerdatos['contacto_persona_atiende'];
        $asegurado = $extraerdatos['asegurado'];
        $direccion = $extraerdatos['direccion'];


        $inspectorasignadoF = $extraerdatos['nombre_inspector'];
        $contactofirma = $extraerdatos['contacto_firma'];
        $inspectorasignado = $extraerdatos['inspectorasignado'];
        $oficinaB = $extraerdatos['nombre_oficina'];
        $firmainspectora = $extraerdatos['firma_inspectora'];
        $nombreedificacion = $extraerdatos['nombre_edificacion'];
        $fecha_posible_inspeccion = $extraerdatos['fecha_posible_inspeccion'];

        $estado = $extraerdatos['estado'];

        $longitud = $extraerdatos['longitud'];
        $latitud = $extraerdatos['latitud'];
        $espaciogeografico = $extraerdatos['espacio_geografico'];
        $estrato = $extraerdatos['estrato'];

      ?>
        <div class="contenedor">
          <div class="campos_f">
            <?php
            echo $identificador = $extraerdatos['numero_inspeccion'];
            ?>
          </div>
          <div class="campos_f">
            <?php echo $fecha_solicitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $companiaseguros; ?>
          </div>
          <div class="campos_f">
            <?php echo $nombreasigna; ?>
          </div>
          <div class="campos_f">
            <?php echo $departamento_id . '-' . $ciudad; ?>
          </div>
          <div class="campos_f">
            <?php echo ($nombreedificacion); ?>
          </div>
          <div class="campos_f">
            <?php echo $direccion; ?>
          </div>

          <div class="campos_f">
            <?php echo $fecha_posible_inspeccion; ?>
          </div>
        </div>
        <br>
        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-user"></i> INFORMACIÓN SOLICITANTE </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Solicitante</div>
          <div class=" titulo">Número de <br>Identificación</div>
          <div class=" titulo"><b>Tomador</b></div>
          <div class=" titulo">Encargado de atender la inspección</div>
          <div class=" titulo"><b>Contacto del encargado</b></div>
          <div class=" titulo">Asegurado</div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php echo ($nombresolicita); ?>
          </div>
          <div class="campos_f">
            <?php echo $tipodocumentosolicitante . ' ' . $numeroidentificacio; ?>
          </div>
          <div class="campos_f">
            <?php echo utf8_decode($tomador) ?>
          </div>
          <div class="campos_f">
            <?php echo ($npersonaatiende); ?>
          </div>
          <div class="campos_f">
            <?php echo ($cpersonaatiende); ?>
          </div>
          <div class="campos_f">
            <?php echo utf8_decode($asegurado); ?>
          </div>
        </div>
        </div>


        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-search"></i> INFORMACIÓN INSPECTOR - FIRMA INSPECTORA </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Firma Inspectora</div>
          <div class=" titulo"><b>Contacto Firma</b></div>
          <div class=" titulo">Compañía de <br> Seguros</div>
          <div class=" titulo">Oficina</div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php
            echo $firmainspectora;
            ?>
          </div>
          <div class="campos_f">
            <?php echo $contactofirma; ?>
          </div>
          <div class="campos_f">
            <?php echo $companiaseguros; ?>
          </div>
          <div class="campos_f">
            <?php echo $oficinaB; ?>
          </div>
        </div>
        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-check"></i> UBICACIÓN GEOESTACIONARIA</center>
          <?php
          $bloques    = new bloques;
          $consulta = $bloques->iniciarVariables();
          echo $filtro = $id_inspeccion;
          $consultainmuebles = $bloques->consultainmuebles($filtro);
          ?>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Longitud</div>
          <div class=" titulo"><b>Latitud</b></div>
          <div class=" titulo"><b>Estrato</b></div>
          <div class=" titulo"><b>Espacio Sociogeografico</b></div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php echo $longitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $latitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $estrato; ?>
          </div>
          <div class="campos_f">
            <?php echo $espaciogeografico; ?>
          </div>
        </div>
        <div class="contenedor">
          <iframe width="1770" height="500" src="https://maps.google.com/maps?q=<?php echo $latitud; ?>,<?php echo $longitud; ?>&output=embed"></iframe>
        </div>

        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-check"></i> INFORMACIÓN DE BIENES A INSPECCIONAR</center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Identificador</div>
          <div class=" titulo">Bien Principal</div>
          <div class=" titulo">Inmueble</div>
          <div class=" titulo">Tipo de Inmueble</div>
          <div class=" titulo">Dirección</div>
          <div class=" titulo">Acciones</div>
        </div>
        <?php

        while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)) {
        ?>
          <div class="contenedor">
            <form action="verinmuebles.php" id="form" method="POST">
              <input type="hidden" value="<?php echo $id = $extraerDatos['identificador'] ?>" name="identificador">
              <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
              <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
            </form>
            <div class="campos_f">
              <?php echo $identificadorI = $extraerDatos['identificador']; ?>
            </div>
            <div class="campos_f">
              <?php echo ($extraerDatos['bien_contenedor']); ?>
            </div>
            <div class="campos_f">
              <?php echo ($extraerDatos['descripcion']); ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['tipo_de_bien']; ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['observaciones']; ?>
            </div>
            <div class="campos_f">
              <form action="detalleinspeccion.php" method="POST" target="_blank">
                <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_encuesta">
                <input type="hidden" value="<?php echo $id = $extraerDatos['identificador'] ?>" name="identificador">
                <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                <button class="btn_azul" name="inspeccionar">Consultar</button>
              </form>


              <form action="riesgosinmueble.php" method="GET" target="_blank">
                <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador">
                <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_encuesta">
                <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                <button class="btn_verde">Calificación<br>Riesgos</button>
              </form>
              <?php
              /*
                          openWindow()
                           <form action="asignarinspectores.php" method="POST">
                              <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                              <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                              <button class="btn_verde" type="submit">Asignar Inspectores</button>
                          </form>
                          */
              ?>
            </div>
          </div>

        <?php
        }
        ?>
        <br>

        <div class="titulo_p">
          <center><i class="fa-solid fa-image"></i> REGISTRO FOTOGRAFICO </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Fotografias</div>
          <a class="btn_verde" href="javascript:popUp('verregistrofotografico.php?idinspeccion=<?php echo $id_inspeccion ?>')">Ver Imagenes</a>
        </div>
        <br>
    
        
        <div class="titulo_p">
          <center><i class="fa-solid fa-image"></i> MATRIZ DE RIESGOS </center>
        </div>

        <div class="contenedor_titulos">
          <div class="titulo">Matriz de riesgos</div>
        </div>

        <div class="contenedor">Aqui va la matriz</div>
        <!--<div class="contenedor">
                           
                    </div>-->

        <div class="titulo_p">
          <center><i class="fa-solid fa-image"></i> GRAFICA GENERAL DE RIESGOS </center>
        </div>

        <?php
        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';

        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Get data from database
        $result = $db->query("SELECT * v_matriz_riesgos_x_inspeccion WHERE  id_inspeccion='$id_inspeccion'");
        ?>
        <div class="contenedor_titulos">
          <div class="titulo">Grafica General de Riesgos</div>
        </div>

        <div class="contenedor">
          <div id="piechart"></div>
        </div>
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Language', 'Calificación'],
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "['" . utf8_encode($row['riesgo']) . "', " . $row['cr'] . "],"; //$row['descripcion_riesgo']
                }
              } else {
                echo 'SIN DATOS';
              }
              ?>
            ]);

            var options_val = {
              title: 'Niveles de riesgo',
              width: 1615,
              height: 500,
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));

            chart.draw(data, options_val);
          }
        </script>

        <div class="titulo_p">
          <center><i class="fa-solid fa-signal"></i> NIVEL DE RIESGO </center>

        </div>
        <?php
        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';

        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Get data from database
        $result = $db->query("SELECT * v_matriz_riesgos_x_inspeccion WHERE id_inspeccion='$id_inspeccion'");
        ?>
        <div class="contenedor_titulos">
          <div class="titulo">Grafica Niveles de Riesgo</div>
        </div>

        <div class="contenedor">
          <div id="piechartB"></div>
        </div>
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Language', 'Nivel de Riesgo'],
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "['" . utf8_encode($row['riesgo']) . "', " . $row['nr'] . "],"; //$row['descripcion_riesgo']
                }
              } else {
                echo 'SIN DATOS';
              }
              ?>
            ]);

            var options_val = {
              title: 'Nivel de riesgos',
              width: 1615,
              height: 500,
              colorAxis: {
                colors: ['red']
              }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('piechartB'));

            chart.draw(data, options_val);
          }
        </script>

      <?php
      }
      if (isset($_POST['identVer'])) {

        $id_inspeccion = $_POST['id'];
        echo 'ENTRA BOTON VER';

        /*$bloques    = new bloques;
                $consulta = $bloques->iniciarVariables();
                $consultasabana = $bloques->consultabuscadorsabana($id_inspeccion);
                $extraerdatos =  $bloques->obtener_fila($consultasabana);
               */

        $consultabuscador = $mysqli->query("SELECT * FROM v_sabana WHERE identificador = '$id_inspeccion'");
        $extraerdatos = $consultabuscador->fetch_array(MYSQLI_ASSOC);
        $id_inspeccion = $extraerdatos['identificador'];
        $numero_inspeccion = $extraerdatos['numero_inspeccion'];
        $fecha_solicitud = $extraerdatos['fecha_solicitud'];
        $companiaseguros = $extraerdatos['cia_seguros'];
        $nombreasigna = $extraerdatos['nombre_asigna'];
        $pais_id = $extraerdatos['pais'];
        $departamento_id = ($extraerdatos['departamento']);
        $ciudad = $extraerdatos['ciudad'];
        $direccion = $extraerdatos['direccion'];
        $fechainspeccion = $extraerdatos['fecha_inspeccion'];
        $identificador = $extraerdatos['identificador'];

        $nombresolicita = $extraerdatos['nombre_solicita'];
        $tipodocumentosolicitante = $extraerdatos['des_td_solicitante'];
        $numeroidentificacio = $extraerdatos['nid_solicita'];
        $tomador = $extraerdatos['tomador'];
        $npersonaatiende = $extraerdatos['nombre_persona_atiende'];
        $cpersonaatiende = $extraerdatos['contacto_persona_atiende'];
        $asegurado = $extraerdatos['asegurado'];
        $direccion = $extraerdatos['direccion'];


        $inspectorasignadoF = $extraerdatos['nombre_inspector'];
        $contactofirma = $extraerdatos['contacto_firma'];
        $inspectorasignado = $extraerdatos['inspectorasignado'];
        $oficinaB = $extraerdatos['nombre_oficina'];
        $firmainspectora = $extraerdatos['firma_inspectora'];
        $nombreedificacion = $extraerdatos['nombre_edificacion'];
        $fecha_posible_inspeccion = $extraerdatos['fecha_posible_inspeccion'];

        $estado = $extraerdatos['estado'];

        $longitud = $extraerdatos['longitud'];
        $latitud = $extraerdatos['latitud'];
        $espaciogeografico = $extraerdatos['espacio_geografico'];
        $estrato = $extraerdatos['estrato'];
      ?>

        <div class="contenedor">
          <div class="campos_f">
            <?php
            echo $identificador = $extraerdatos['numero_inspeccion'];
            ?>
          </div>
          <div class="campos_f">
            <?php echo $fecha_solicitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $companiaseguros; ?>
          </div>
          <div class="campos_f">
            <?php echo $nombreasigna; ?>
          </div>
          <div class="campos_f">
            <?php echo $departamento_id . '-' . $ciudad; ?>
          </div>
          <div class="campos_f">
            <?php echo ($nombreedificacion); ?>
          </div>
          <div class="campos_f">
            <?php echo $direccion; ?>
          </div>

          <div class="campos_f">
            <?php echo $fecha_posible_inspeccion; ?>
          </div>
        </div>
        <br>
        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-user"></i> INFORMACIÓN SOLICITANTE </center>
        </div>

        <div class="contenedor_titulos">
          <div class=" titulo">Solicitante</div>
          <div class=" titulo">Número de <br>Identificación</div>
          <div class=" titulo"><b>Tomador</b></div>
          <div class=" titulo">Encargado de atender la inspección</div>
          <div class=" titulo"><b>Contacto del encargado</b></div>
          <div class=" titulo">Asegurado</div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php echo ($nombresolicita); ?>
          </div>
          <div class="campos_f">
            <?php echo $tipodocumentosolicitante . ' ' . $numeroidentificacio; ?>
          </div>
          <div class="campos_f">
            <?php echo $tomador ?>
          </div>
          <div class="campos_f">
            <?php echo utf8_decode($npersonaatiende); ?>
          </div>
          <div class="campos_f">
            <?php echo $cpersonaatiende; ?>
          </div>
          <div class="campos_f">
            <?php echo utf8_decode($asegurado); ?>
          </div>
        </div>
        </div>


        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-search"></i> INFORMACIÓN INSPECTOR - FIRMA INSPECTORA </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Firma Inspectora</div>
          <div class=" titulo"><b>Contacto Firma</b></div>
          <div class=" titulo">Compañía de <br> Seguros</div>
          <div class=" titulo">Oficina</div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php
            echo $firmainspectora;
            ?>
          </div>
          <div class="campos_f">
            <?php echo $contactofirma; ?>
          </div>
          <div class="campos_f">
            <?php echo $companiaseguros; ?>
          </div>
          <div class="campos_f">
            <?php echo $oficinaB; ?>
          </div>
        </div>
        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-check"></i> UBICACIÓN GEOESTACIONARIA</center>
          <?php
          $bloques    = new bloques;
          $consulta = $bloques->iniciarVariables();
          $filtro = $id_inspeccion;
          $consultainmuebles = $bloques->consultainmuebles($filtro);
          ?>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Longitud</div>
          <div class=" titulo"><b>Latitud</b></div>
          <div class=" titulo"><b>Estrato</b></div>
          <div class=" titulo"><b>Espacio Sociogeografico</b></div>
        </div>
        <div class="contenedor">
          <div class="campos_f">
            <?php echo $longitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $latitud; ?>
          </div>
          <div class="campos_f">
            <?php echo $estrato; ?>
          </div>
          <div class="campos_f">
            <?php echo $espaciogeografico; ?>
          </div>
        </div>

        <script>
          function printDiv(nombreDiv) {
            var contenido = document.getElementById(nombreDiv).innerHTML;
            var contenidoOriginal = document.body.innerHTML;

            document.body.innerHTML = contenido;

            window.print();

            document.body.innerHTML = contenidoOriginal;
          }

          function imprimirpantalla() {
            html2canvas(document.body, {
              onrendered(canvas) {
                var link = document.getElementById('download');;
                var image = canvas.toDataURL();
                link.href = image;
                link.download = 'screenshot.png';
              }
            });
          }

          $(document).ready(function() {
            // indicamos que se ejecuta la funcion a los 5 segundos de haberse
            // cargado la pagina
            setTimeout(clickbutton, 0000);

            function clickbutton() {
              // simulamos el click del mouse en el boton del formulario
              $("#action-button").click();
              //alert("Aqui llega"); //Debugger
            }
            $('#action-button').on('click', function() {
              // console.log('action');
            });
          });
        </script>

        <div>
          <div class="contenedor" id="contenedor">
            <iframe width="1770" height="500" src="https://maps.google.com/maps?q=<?php echo $latitud; ?>,<?php echo $longitud; ?>&output=embed"></iframe>
          </div>
        </div>


        <br>
        <div class="titulo_p">
          <center><i class="fa-solid fa-check"></i> INFORMACIÓN DE BIENES A INSPECCIONAR</center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Identificador</div>
          <div class=" titulo">Bien Principal</div>
          <div class=" titulo">Inmueble</div>
          <div class=" titulo">Tipo de Inmueble</div>
          <div class=" titulo">Dirección</div>
          <div class=" titulo">Acciones</div>
        </div>
        <?php

        while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)) {
        ?>
          <div class="contenedor">
            <form action="verinmuebles.php" id="form" method="POST">
              <input type="hidden" value="<?php echo $id = $extraerDatos['identificador'] ?>" name="identificador">
              <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
              <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
            </form>
            <div class="campos_f">
              <?php echo $identificadorI = $extraerDatos['identificador']; ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['bien_contenedor']; ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['descripcion']; ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['tipo_de_bien']; ?>
            </div>
            <div class="campos_f">
              <?php echo $extraerDatos['observaciones']; ?>
            </div>
            <div class="campos_f">
              <form action="detalleinspeccion.php" method="POST" target="_blank">
                <input type="" value="<?php echo $id_inspeccion ?>" name="id_encuesta">
                <input type="" value="<?php echo $id = $extraerDatos['identificador'] ?>" name="identificador">
                <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                <button class="btn_azul" name="inspeccionar">Consultar</button>
              </form>

              <form action="riesgosinmueble.php" method="GET" target="_blank">
                <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador">
                <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_encuesta">
                <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                <input type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                <button class="btn_verde">Calificación<br>Riesgos</button>
              </form>

              <?php
              /*
                          openWindow()
                           <form action="asignarinspectores.php" method="POST">
                              <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                              <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                              <button class="btn_verde" type="submit">Asignar Inspectores</button>
                          </form>
                          */
              ?>
            </div>
          </div>


        <?php
        }
        ?>
        <div class="titulo_p">
          <center><i class="fa-solid fa-image"></i> REGISTRO FOTOGRAFICO </center>
        </div>
        <div class="contenedor_titulos">
          <div class=" titulo">Fotografias</div>
          <a href="javascript:popUp('ventana.html')">Abrir popup</a>
        </div>
        <div class="contenedor">
          <?php
          $id_inspeccion;
          $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$id_inspeccion'");
          while ($extraerimagen = $consultaimagenes->fetch_array()) {
            $imagen = $extraerimagen['archivo'];
            $pie_de_pagina = $extraerimagen['pie_de_imagen'];
            if ($imagen != NULL) {
          ?>
              <div class="campos_f">
                <img src="<?php echo 'archivos/' . $imagen; ?>" width="250" height="250">
                <label><?php echo $pie_de_pagina ?></label>
              </div>
          <?php
            }
          }
          ?>
        </div>
        <div class="titulo_p">
          <center><i class="fa-solid fa-image"></i> MATRIZ DE RIESGOS </center>
        </div>

        <div class="contenedor_titulos">
          <div class="titulo">Matriz de riesgos</div>
        </div>

        <div class="contenedor"></div>
        <!--<div class="contenedor">
                           <iframe width="1250" height="1250"  src="matrizframe.php"  align="center"></iframe>
                    </div>-->
        <?php
        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';

        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Get data from database
        $result = $db->query("SELECT * v_matriz_riesgos_x_inspeccion WHERE  id_inspeccion='$id_inspeccion'");
        ?>
        <div class="contenedor_titulos">
          <div class="titulo">Grafica General de Riesgos</div>
        </div>

        <div class="contenedor">
          <div id="piechart"></div>
        </div>
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Language', 'Calificación'],
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "['" . utf8_encode($row['riesgo']) . "', " . $row['cr'] . "],"; //$row['descripcion_riesgo']
                }
              } else {
                echo 'SIN DATOS';
              }
              ?>
            ]);

            var options_val = {
              title: 'Niveles de riesgo',
              width: 1615,
              height: 500,
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));

            chart.draw(data, options_val);
          }
        </script>

        <div class="titulo_p">
          <center><i class="fa-solid fa-signal"></i> NIVEL DE RIESGO </center>

        </div>
        <?php
        $dbHost = 'localhost';
        $dbUsername = 'u571892443_risk_hunter';
        $dbPassword = '#6mL0I[Jd7ZW';
        $dbName = 'u571892443_risk_hunter';

        // Create connection and select db
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Get data from database
        $result = $db->query("SELECT * v_matriz_riesgos_x_inspeccion WHERE id_inspeccion='$id_inspeccion'");
        ?>
        <div class="contenedor_titulos">
          <div class="titulo">Grafica Niveles de Riesgo</div>
        </div>

        <div class="contenedor">
          <div id="piechartB"></div>
        </div>
        <script type="text/javascript">
          google.charts.load('current', {
            'packages': ['corechart']
          });
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Language', 'Nivel de Riesgo'],
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "['" . utf8_encode($row['riesgo']) . "', " . $row['nr'] . "],"; //$row['descripcion_riesgo']
                }
              } else {
                echo 'SIN DATOS';
              }
              ?>
            ]);

            var options_val = {
              title: 'Nivel de riesgos',
              width: 1615,
              height: 500,
              colorAxis: {
                colors: ['red']
              }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('piechartB'));

            chart.draw(data, options_val);
          }
        </script>


        <script type="text/javascript">
          function popUp(URL) {
            window.open(URL, 'Nombre de la ventana', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=1500,height=1500,left = 0,top = 0');
          }
        </script>


      <?php

      }
      ?>
      </div>

      <?php include 'footer.php'; ?>
      <script>
        function vermenu() {
          document.getElementById('m_ad').classList.toggle('ver');
        }
      </script>
    </body>
   
    </html>