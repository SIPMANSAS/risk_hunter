    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
        include 'conexion/conexion.php';
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista Encabezados</title>
        <link rel="stylesheet" href="css/regiones.css">
          <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      
        <script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var search = $(this).val();	
            var dataString = 'search='+search;
            var parametros = {
          "search": search,
         }
         //url: "funcioness/obtienesearchfirmas.php",
    	$.ajax({
                type: "POST",
                url: "funcioness/obtienesearchencabezadosabana.php",
                data: parametros,
               success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#sugerencia').fadeIn(1000).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.sugerencia-element').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var id = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#search').val($('#'+id).attr('data'));
    			            
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
    if(isset($_POST["identificau"]) or (isset($_POST["idusuario"])))
    {
        /* entrada al metodo post para mostrar informacion de usuario y actualizar */
        
        if (isset($_POST["identificau"]))
             $identificador = $_POST["identificau"];
        elseif (isset($_POST["idusuario"]))
            $identificador = $_POST["idusuario"];
        
    }    
        ?>
   
        <div class="titulo_p">
            <center><i class="fa-solid fa-user"></i> SABANA COMPLETA DE INSPECCIONES</center>
        </div>
        
        <div class="link_int"><div class=""></div>
        <div class="titulo3"><i class="fa-solid fa-search"></i><a href="buscaparrillafiltros.php"> Busqueda Personalizada</a></div></div>
        <br>
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Inspección..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
          <div class="contenedor_titulos">
            <div title="Aqui va el titulo" class=" titulo"><b>Identificación</b></div>
            <div class=" titulo">Número de <br>Inspección</div>
            <div class=" titulo">Compañía de <br> Seguros</div>
            <div class=" titulo"><b>Fecha <br>Solicitud</b></div>
            <div class=" titulo"><b>Ciudad de <br>realización</b></div>
            <div class=" titulo"><b>Número <br>Contacto</b></div>
            <div class=" titulo"><b>Fecha<br> Inspección</b></div>
            <div class=" titulo"><b>Fecha <br>Realizacion</b></div>
            <div class=" titulo"><b>Fecha <br>Edición</b></div>
            <div class=" titulo"><b>Informe de <br>inspección</b></div>
            <div class=" titulo"><b>Estado</b></div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
          
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultasabana = $bloques->consultasabana();
    
            while ($extraerDatos =  $bloques->obtener_fila($consultasabana)){
                $tipodocumentosolicitante = $extraerDatos['des_td_solicitante'];
                $departamento_id = $extraerDatos['departamento'];
                $pais_id = $extraerDatos['pais'];
                $bloque_inspeccion = $extraerDatos['bloque_inspeccion'];
                $inspectorasignadoF = $extraerDatos['inspector_firma_inspectora'];
                $contactofirma = $extraerDatos['contacto_firma'];
                $inspectorasignado = $extraerDatos['nombre_inspector'];
                $oficinaB = $extraerDatos['nombre_oficina'];
                $numero_inspeccion = $extraerDatos['numero_inspeccion'];
                $fecha_solicitud = $extraerDatos['fecha_solicitud'];
                $companiaseguros = $extraerDatos['cia_seguros'];
                $ciudad = $extraerDatos['ciudad'];
                $fechainspeccion = $extraerDatos['fecha_inspeccion'];
                $direccion = $extraerDatos['direccion']; 
                $numeroidentificacio = $extraerDatos['nid_solicita'];
                $nombresolicita = $extraerDatos['nombre_solicita'];
                $tomador = $extraerDatos['tomador'];
                $asegurado = $extraerDatos['asegurado'];
                $npersonaatiende = $extraerDatos['nombre_persona_atiende'];
                $cpersonaatiende = $extraerDatos['contacto_persona_atiende'];
                $firmainspectora = $extraerDatos['firma_inspectora'];
                $nombreedificacion =$extraerDatos['nombre_edificacion'];
                $fecha_posible_inspeccion = $extraerDatos['fecha_posible_inspeccion'];
                $lista_biene = $extraerDatos['lista_bienes'];
                $nombreasigna = $extraerDatos['nombre_asigna'];
                $estado = $extraerDatos['estado'];
                $longitud = $extraerDatos['longitud'];
                $latitud = $extraerDatos['latitud'];
                $estrato = $extraerDatos['estrato'];
                $espacio_geografico = $extraerDatos['espacio_geografico'];
                $id = $extraerDatos['identificador'];
                $fecha_terminacion = $extraerDatos['fecha_terminacion'];
                $fecha_actualizacion = $extraerDatos['fecha_actualizacion'];
                $usuario_actualizacion = $extraerDatos['usuario_actualizacion'];
                $origen = $extraerDatos['origen'];
        
        ?>
            <div class="contenedor" id="areaImprimir">
                <div class="campos_f">
                  <form action="verregistrosabana.php" id="form" method="POST">
                    <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatos['identificador'] ?>" ></div>
                        <input type="hidden" name="id" id="ident" value="<?php echo $identificador=$extraerDatos['identificador'] ?>">
                        <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                        <input  type="hidden" value="<?php echo utf8_encode($departamento_id);  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $inspectorasignado;  ?>" name="inspectorfirma">
                        <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                        <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                        <input  type="hidden" value="<?php echo $oficinaB;  ?>" name="oficina">
                        <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitud">
                        <input  type="hidden" value="<?php echo $companiaseguros;  ?>" name="cia_seguros">
                        <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $fechainspeccion;  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $nombresolicita;  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $tomador;  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $asegurado;  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                        <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="posiblefechainspeccion">
                        <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                        <input  type="hidden" value="<?php echo $estado;  ?>" name="estado">
                        <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                        <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                        <input  type="hidden" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                        <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                        <input  type="hidden" value="<?php echo  $extraerDatos['id_alfanumerico'];  ?>" name="tipdocB">    
                        <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                        <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                        <input  type="hidden" value="<?php echo $usuario_actualizacion ?>" name="usuario_actualizacion">
                        <input  type="hidden" value="<?php echo $origen ?>" name="origen">
                        

                  </form>
                </div>
                <div class="campos_f">
                  <?php echo $numero_inspeccion; ?>
                </div>
                <div class="campos_f">
                  <?php echo $companiaseguros; ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_solicitud; ?>
                </div>
                <div class="campos_f">
                  <?php echo $ciudad; ?>
                </div>
                
                <div class="campos_f">
                  <?php echo $cpersonaatiende; ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_posible_inspeccion; ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_terminacion; ?>
                </div>
                <div class="campos_f">
                  <?php echo $fecha_actualizacion; ?>
                </div>
                <div class="campos_f">
                 <!--<form action="encuestaspdf.php" method="POST" target="_blank">-->
                  <form action="pruebaplantillaPDF.php" method="POST" target="_blank">
                     <input  type="hidden" value="<?php echo $numero_inspeccion ?>" name="inspeccion">
                     <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                     <input  type="hidden" value="<?php echo $companiaseguros ?>" name="cia_texto">
                     <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                     <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                     <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                     <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                     <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitudB">
                     <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                     <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                     <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                     <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                     <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                     <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                     <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                     <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                     <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                     <input  type="" value="<?php echo $longitud;  ?>" name="longitud">
                     <input  type="" value="<?php echo $latitud;  ?>" name="latitud">
                     <input  type="" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                     <input  type="" value="<?php echo $estrato?>" name="estrato">
                     <input  type="hidden" value="<?php echo $oficinaB;  ?>" name="oficina">
                     <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                     <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                    
                        <?php
                            
                            $consulta = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta=158 ORDER BY identificador ASC");
                            $consultaB = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta=158 ORDER BY identificador ASC");
                            $consultaC = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta=158 ORDER BY identificador ASC");
                            $consultaD = $mysqli->query("SELECT B.descripcion,P.codigo,P.texto_informe,D.id_inspeccion,D.bloque_inspeccion, (SELECT A.id_alfanumerico FROM enc_respuestas R,cg_valores_dominio A WHERE R.identificador = D.id_respuesta AND R.vdom_tipo_dato = A.identificador)tipo_dato,D.respuesta_texto FROM enc_detalles_inspeccion D , enc_preguntas P ,enc_bloque_preguntas B WHERE D.id_pregunta = P.identificador AND B.identificador = P.id_bloque_preguntas AND D.id_inspeccion=$id;");
                             $consultaE = $mysqli->query("SELECT B.descripcion,P.codigo,P.texto_informe,D.id_inspeccion,D.bloque_inspeccion, (SELECT A.id_alfanumerico FROM enc_respuestas R,cg_valores_dominio A WHERE R.identificador = D.id_respuesta AND R.vdom_tipo_dato = A.identificador)tipo_dato,D.respuesta_texto FROM enc_detalles_inspeccion D , enc_preguntas P ,enc_bloque_preguntas B WHERE D.id_pregunta = P.identificador AND B.identificador = P.id_bloque_preguntas AND D.id_inspeccion=$id;");
                             
                             
                            $consultaF = $mysqli->query("SELECT * FROM enc_detalles_inspeccion D,enc_inspeccion I,enc_preguntas P WHERE D.id_inspeccion=I.identificador AND D.id_pregunta = P.identificador AND D.id_inspeccion = $id"); 
                             
                            ?>
                            <input type="hidden" value="<?php while($extraerDatosE = $consulta->fetch_array()){ echo $observaciones = $extraerDatosE['observaciones'].'<br>'; ?><?php } ?>" name="bienes">
                            <input type="hidden" value="<?php while($extraerDatosB = $consultaB->fetch_array()){ echo $id = $extraerDatosB['identificador'].'<br>'; ?><?php } ?>" name="id_bienes">
                            <input type="hidden" value="<?php while($extraerDatosC = $consultaC->fetch_array()){ echo $desc = $extraerDatosC['descripcion'].'<br>'; ?><?php } ?>" name="descripcion">
                            <input type="hidden" value="<?php while($extraerDatosE = $consultaE->fetch_array()){ echo $rtexto = $extraerDatosE['respuesta_texto'].'<br>';}?>" name="respuesta_texto">
                            <?php/*<input type="hidden" value="<?php while($extraerDatosD = $consultaD->fetch_array()){ echo $descp = $extraerDatosD['texto_informe'].'<br>'; } ?>" name="descripcionpreguntas">*/?>
                            <input type="hidden" name="mapa" value="<?php echo "<iframe width='1770' height='500' src='https://maps.google.com/maps?q=<?php echo $latitud; $longitud; ?>&output=embed'></iframe>"?>">
                        
                     
                 </form>
                <form action="reporteprueba.php" method="POST" target="_blank">
                    <?php
                     $consultaF = $mysqli->query("SELECT * FROM enc_detalles_inspeccion D,enc_inspeccion I,enc_preguntas P WHERE D.id_inspeccion=I.identificador AND D.id_pregunta = P.identificador AND D.id_inspeccion = $id"); 
                    ?>
                    <input  type="hidden" value="<?php echo $numero_inspeccion ?>" name="inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                    <input  type="hidden" value="<?php echo $companiaseguros ?>" name="cia_texto">
                    <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                    <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                    <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitudB">
                    <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                    <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                    <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                    <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                    <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                    <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                    <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                    <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                    <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                    <input  type="hidden" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                    <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                    <input  type="hidden" value="<?php echo $bloque_inspeccion?>" name="bloque_inspeccion">
                    <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                    <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                    <input  type="hidden" value="2" name="Dato">
                    <!--<button class="btn_verde" type="submit" ><i class="fa fa-download"></i>   </button>-->
                </form>
                
                <form action="pruebahtmlpdf.php" method="POST" target="_blank">
                    <?php
                     $consultaF = $mysqli->query("SELECT * FROM enc_detalles_inspeccion D,enc_inspeccion I,enc_preguntas P WHERE D.id_inspeccion=I.identificador AND D.id_pregunta = P.identificador AND D.id_inspeccion = $id"); 
                     
                     $consultatextoinforme = $mysqli->query("SELECT p_informe_completo($id) AS p_informe");
                     $extraerDatosInforme = $consultatextoinforme->fetch_array(MYSQLI_ASSOC);
                     $texto_informe = $extraerDatosInforme['p_informe']; 
                    ?>
                    <input  type="hidden" value="<?php echo $numero_inspeccion ?>" name="inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                    <input  type="hidden" value="<?php echo $companiaseguros ?>" name="cia_texto">
                    <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                    <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                    <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitudB">
                    <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                    <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                    <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                    <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                    <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                    <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                    <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                    <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                    <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                    <input  type="hidden" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                    <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                    <input  type="hidden" value="<?php echo $bloque_inspeccion?>" name="bloque_inspeccion">
                    <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                    <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                    <textarea hidden="hidden" name="texto_informe"><?php echo $texto_informe?></textarea>
                    
                    <input  type="hidden" value="2" name="Dato">
                    <button style="display:none" class="btn_azul" type="submit" ><i class="fa fa-download"></i>   </button>
                </form>
                
                 <form action="reporteinspeccion.php" method="POST" target="_blank">
                    <?php
                     $consultaF = $mysqli->query("SELECT * FROM enc_detalles_inspeccion D,enc_inspeccion I,enc_preguntas P WHERE D.id_inspeccion=I.identificador AND D.id_pregunta = P.identificador AND D.id_inspeccion = $id"); 
                     
                     $consultatextoinforme = $mysqli->query("SELECT p_informe_completo($id) AS p_informe");
                     $extraerDatosInforme = $consultatextoinforme->fetch_array(MYSQLI_ASSOC);
                     $texto_informe = $extraerDatosInforme['p_informe']; 
                    ?>
                    <input  type="hidden" value="<?php echo $numero_inspeccion ?>" name="inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                    <input  type="hidden" value="<?php echo $companiaseguros ?>" name="cia_texto">
                    <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                    <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                    <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitudB">
                    <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                    <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                    <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                    <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                    <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                    <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                    <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                    <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                    <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                    <input  type="hidden" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                    <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                    <input  type="hidden" value="<?php echo $bloque_inspeccion?>" name="bloque_inspeccion">
                    <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                    <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                    <?php
                    if($origen == 'FI'){
                        $origen = '3';
                    }elseif($origen == 'CA'){
                        $origen = '1';
                    }else{
                        $origen = '2';
                    }
                    ?>
                    <input  type="hidden" value="<?php echo $origen ?>" name="origen">
                    
                    <textarea hidden="hidden" name="texto_informe"><?php echo $texto_informe?></textarea>
                    
                    <input  type="hidden" value="2" name="Dato">
                    <button class="btn_amarillo" type="submit" ><i class="fa fa-download"></i>   </button>
                </form>
                </div>
                
                <script>
                    function printDiv(nombreDiv) {
                         var contenido= document.getElementById(nombreDiv).innerHTML;
                         var contenidoOriginal= document.body.innerHTML;
                    
                         document.body.innerHTML = contenido;
                    
                         window.print();
                    
                         document.body.innerHTML = contenidoOriginal;
                }
                </script>
                <div class="campos_f">
                  <?php echo $estado; ?>
                </div>
                 <div class="campos_f">
                  <form action="verregistrosabana.php" id="form" method="POST">
                    <center><div class="campos_list_u"><button type="submit"  class="btn_verde" name="ident" id="identificau" value="ver" ><i class="fa fa-search"></i></div></center>
                        <input  type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificador'] ?>">
                        <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                        <input  type="hidden" value="<?php echo utf8_encode($departamento_id);  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $inspectorasignado;  ?>" name="inspectorfirma">
                        <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                        <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                        <input  type="hidden" value="<?php echo $oficinaB;  ?>" name="oficina">
                        <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitud">
                        <input  type="hidden" value="<?php echo $companiaseguros;  ?>" name="cia_seguros">
                        <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $fechainspeccion;  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $nombresolicita;  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $tomador;  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $asegurado;  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                        <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="posiblefechainspeccion">
                        <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                        <input  type="hidden" value="<?php echo $estado;  ?>" name="estado">
                        <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                        <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                        <input  type="hidden" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                        <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                        <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                        <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                      <input type="hidden" value="<?php echo  $extraerDatos['id_alfanumerico'];  ?>" name="tipdocB">
                  </form>
                  
                  <?php
                  //echo $id_usuario_ext;
                  //echo "SELECT f_permisos_usuario_objeto('$id_usuario_ext', '3', '104') AS f_permisos_usuario_objeto";
                  $rolxusuario;
                  $consltaroles = $mysqli->query("SELECT * FROM sg_roles_x_usuario WHERE id_usuario = '$id_usuario_ext'");
                  while($extraerDatos = $consltaroles->fetch_array()){
                        $rolesU = $extraerDatos['id_rol'];
                        if($rolesU == 4 || $rolesU == 7 || $rolesU == 10  ){
                            $consultafuncionbotonfacturacion = $mysqli->query("SELECT f_permisos_usuario_objeto('$id_usuario_ext', '3', '104') AS f_permisos_usuario_objeto");
                            $extraerfunciondatos = $consultafuncionbotonfacturacion->fetch_array(MYSQLI_ASSOC);
                            $resultadofuncion = $extraerfunciondatos['f_permisos_usuario_objeto'];
                            $identificadorinspeccion = $extraerDatos['identificador'];
                            if($resultadofuncion == 0){
                                $consultaboton = $mysqli->query("SELECT * FROM sg_objetos WHERE identificador = 104");
                                $extraerDatosconsultaboton = $consultaboton->fetch_array(MYSQLI_ASSOC);
                            ?>
                                <form action="facturacion.php" method="POST">
                                    <input type="hidden" name="id_inspeccion" value="<?php echo $identificadorinspeccion ?>">
                                    <?php echo $codigoboton = $extraerDatosconsultaboton['codigo'] ?>
                                </form>
                            <?php    
                            }else{
                      
                            }
                        }
                  }
                  ?>
                </div>
                <?php
                /*
                <div class="campos_f">
                     <form action="informe.php" id="form" method="POST">
                        <div>
                            <button type="submit"  class="btn_azul" name="ident" id="identificau">Informe</button>
                        </div>
                        <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificador'] ?>">
                        <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                        <input  type="hidden" value="<?php echo utf8_encode($departamento_id);  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $inspectorasignado;  ?>" name="inspectorfirma">
                        <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                        <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                        <input  type="hidden" value="<?php echo $oficinaB;  ?>" name="oficina">
                        <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitud">
                        <input  type="hidden" value="<?php echo $companiaseguros;  ?>" name="cia_seguros">
                        <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $fechainspeccion;  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $nombresolicita;  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $tomador;  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $asegurado;  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                        <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $fecha_posible_inspeccion;  ?>" name="posiblefechainspeccion">
                        <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                        <input  type="hidden" value="<?php echo $estado;  ?>" name="estado">
                        <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                        <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                        <input  type="hidden" value="<?php echo $espacio_geografico?>" name="espaciogeografico">
                        <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                      <input type="hidden" value="<?php echo  $extraerDatos['id_alfanumerico'];  ?>" name="tipdocB">
                  </form>
                </div>
                */
                ?>
            </div>
            <?php
            }
    
          ?>
            <div class="cont_fin"></div>
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>