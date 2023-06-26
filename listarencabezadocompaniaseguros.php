    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
        //include  "clases/otrobloques.class.php";
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista Encabezados</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
          <link rel="shortcut icon" href="favicon.ico">
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
                url: "funcioness/obtienesearchencabezadocompanias.php",
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
            <center><i class="fa-solid fa-user"></i> ENCABEZADOS COMPAÑIA DE SEGUROS</center>
        </div>
        <?php
        /*
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-download"></i><a Onclick="window.location='exportacion/exportarencabezadocompaniaseguros.php'"> Exportar Listado Inspecciones Compañias de Seguros</a></div>
        */
        ?>
        <div class="link_int"><div></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="crearencabezadocompaniaaseguradora.php"> Crear Encabezado</a></div></div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Encabezado..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
          <div class="contenedor_titulos">
            <div class=" titulo"><b>Número de <br>Inspección</b></div>
            <div class=" titulo">Nombre de<br> quien asigna</div>
            <div class= "titulo">Fecha Solicitud</div>
            <div class=" titulo"><b>Firma Inspectora / <br>Técnico CA</b></div>
            <div class=" titulo"><b>Ciudad donde se <br>realizará</b></div>
            <div class=" titulo"><b>lista de bienes <br>a inspeccionar</b></div>
            <div class=" titulo"><b>Fecha de <br>inspección</b></div>
            <!--<div class=" titulo"><b>Informe de <br>inspección</b></div>-->
            <div class= "titulo"><b>Estado</b></div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
            
            include 'conexion/conexion.php';
            $id_menu_p;
            
            $consultacias = $mysqli->query("SELECT * FROM sg_usuarios_x_cliente WHERE id_usuario='$id_menu_p'");
            while($extraerDatosClientes = $consultacias->fetch_array()){
                $cias_asignadas =  $extraerDatosClientes['id_cliente'];
                ///echo '<br>';
                $consultacantidad = $mysqli->query("SELECT COUNT(*) AS CANTIDAD FROM v_parrilla_cias_seguros WHERE id_cia_seguros = '$cias_asignadas'");
                $extraeerCantidad = $consultacantidad->fetch_array(MYSQLI_ASSOC);
                $cantidad = $extraeerCantidad['CANTIDAD'];
                
                $consultaenccias=$mysqli->query("SELECT * FROM v_parrilla_cias_seguros WHERE id_cia_seguros = '$cias_asignadas' OR id_firma_inspectora='$cias_asignadas'");
                ///echo "SELECT * FROM v_parrilla_cias_seguros WHERE id_cia_seguros = '$cias_asignadas'";
                while($extraerDatos=$consultaenccias->fetch_array()){
                    $ninspeccion=$extraerDatos['numero_inspeccion'];
                    //echo '<br>';
                ?>
                <div class="contenedor">
                      <form action="verencabezadocompanias.php" id="form" method="POST">
                        <input type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'] ?>" name="inspeccion">
                        <input type="hidden" value="<?php echo $extraerDatos['lista_bienes'] ?>" name="ruta">
                        <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                        <input  type="hidden" value="<?php echo $extraerDatos['fecha_solicitud'];  ?>" name="fechasolicitud">
                        <input  type="hidden" value="<?php echo $extraerDatos['descripcion'];?>" name="descripcion"?>
                        <input  type="hidden" value="<?php echo $extraerDatos['id_cia_seguros'];  ?>" name="id_cia_seguros">
                        <input  type="hidden" value="<?php echo $extraerDatos['nombre_solicita'];  ?>" name="solicitante">
                        <input  type="hidden" value="<?php echo $extraerDatos['tid_solicita'];  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $extraerDatos['nid_solicita'];  ?>" name="identificacion">
                        <input  type="hidden" value="<?php echo $extraerDatos['tomador'];  ?>" name="tomador">
                        <input  type="hidden" value="<?php echo $extraerDatos['asegurado'];  ?>" name="asegurado">
                        <input  type="hidden" value="<?php echo $extraerDatos['nombre_edificacion'];  ?>" name="nombreedificacion">
                        <input  type="hidden" value="<?php echo $extraerDatos['nombre_persona_atiende'];  ?>" name="nombrepersonaatiende">
                        <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contactopersonaatiende">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_firma_inspectora'];  ?>" name="firmainspectora">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_pais'];  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_departamento'];  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_ciudad'];  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $extraerDatos['fecha_inspeccion'];  ?>" name="fecha_inspeccion">
                        <input  type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'];  ?>" name="numero_inspeccion">
                        <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_oficina'];  ?>" name="id_oficina_cia_seguros">
                        <input  type="hidden" value="<?php echo $extraerDatos['nombre_oficina'];  ?>" name="oficina_nombre">
                        <input  type="hidden" value="<?php echo $extraerDatos['nombre_persona_atiende'];  ?>" name="nombre_persona_atiende">
                        <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contacto_persona_atiende">
                        <input  type="hidden" value="<?php echo $extraerDatos['fecha_posible_inspeccion'];  ?>" name="fecha_posible_inspeccion">
                      </form>
                <div class="campos_f">
                    <?php 
                    echo $identificador = $extraerDatos['numero_inspeccion'];
                    ?>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['nombre_asigna']; ?>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['fecha_solicitud']; ?>
                </div>
                 <div class="campos_f">
                     <?php echo $extraerDatos['inspector_firma_inspectora']; ?>
                 </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['ciudad']; ?>
                </div>
                <div class="campos_f">
                    <?php
                    echo $ruta = $extraerDatos['lista_bienes'];
                    header("Content-type: application/force-download");  
                    ?>
                  <a class="btn_verde"  href="<?php echo ('risk_hunter/'.$ruta)?>" download="<?php echo ($ruta)?>" target="_blank" onClick="javascript:document["ver-form"].submit();"><i class="fa fa-download"></i></a>
                </div>
                      
                <div class="campos_f">
                    <?php echo $extraerDatos['fecha_inspeccion']; ?>
                </div>
                <?php
                /*
               <div class="campos_f">
                 <form action="encuestaspdf.php" method="POST" target="_blank">
                     <input type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'] ?>" name="inspeccion">
                     <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                     <button class="btn_verde" type="submit" ><i class="fa fa-download"></i>   </button>
                 </form>
                </div>
                */
                ?>
                <div class="campos_f">
                    <?php echo $extraerDatos['estado']; ?>
                </div>
                <?php
                $codigoestado = $extraerDatos['codigo_estado'];
                if($codigoestado == 1){
                ?>
                <div class="campos_f">
                  <form action="editarencabezadocompanias.php" method="POST">
                     <input type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'] ?>" name="inspeccion">
                    <input type="hidden" value="<?php echo $extraerDatos['lista_bienes'] ?>" name="ruta">
                    <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                    <input  type="hidden" value="<?php echo $extraerDatos['fecha_solicitud'];  ?>" name="fechasolicitud">
                    <input  type="hidden" value="<?php echo $extraerDatos['descripcion'];?>" name="descripcion"?>
                    <input  type="hidden" value="<?php echo $extraerDatos['id_cia_seguros'];  ?>" name="id_cia_seguros">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_solicita'];  ?>" name="solicitante">
                    <input  type="hidden" value="<?php echo $extraerDatos['tid_solicita'];  ?>" name="tipodocumento">
                    <input  type="hidden" value="<?php echo $extraerDatos['nid_solicita'];  ?>" name="identificacion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tomador'];  ?>" name="tomador">
                    <input  type="hidden" value="<?php echo $extraerDatos['asegurado'];  ?>" name="asegurado">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_edificacion'];  ?>" name="nombreedificacion">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_persona_atiende'];  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contactopersonaatiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_firma_inspectora'];  ?>" name="firmainspectora">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_pais'];  ?>" name="pais">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_departamento'];  ?>" name="departamento">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_ciudad'];  ?>" name="ciudad">
                    <input  type="hidden" value="<?php echo $extraerDatos['fecha_inspeccion'];  ?>" name="fecha_inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'];  ?>" name="numero_inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_oficina_cia_seguros'];  ?>" name="id_oficina_cia_seguros">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_persona_atiende'];  ?>" name="nombre_persona_atiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_oficina'];  ?>" name="oficina_nombre">
                    <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contacto_persona_atiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['fecha_posible_inspeccion'];  ?>" name="fecha_posible_inspeccion">
                    <input type="hidden" value="<?php echo  $extraerDatos['contacto_firma']; ?> " name="contacto_firma">
                    <input type="hidden" value="<?php echo  $extraerDatos['firma_inspectora']; ?> " name="firma_inspectora">
                    <button class="btn_azul" type="submit" name="editarEncabezado">Editar</button>
                  </form>
                  <?php
                }else{
                ?>
                <div class="campos_f">
                  <form action="verencabezadocompanias.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'] ?>" name="inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                    <input  type="hidden" value="<?php echo $extraerDatos['fecha_solicitud'];  ?>" name="fechasolicitud">
                    <input  type="hidden" value="<?php echo $extraerDatos['descripcion'];?>" name="descripcion"?>
                    <input  type="hidden" value="<?php echo $extraerDatos['id_cia_seguros'];  ?>" name="id_cia_seguros">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_solicita'];  ?>" name="solicitante">
                    <input  type="hidden" value="<?php echo $extraerDatos['tid_solicita'];  ?>" name="tipodocumento">
                    <input  type="hidden" value="<?php echo $extraerDatos['nid_solicita'];  ?>" name="identificacion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tomador'];  ?>" name="tomador">
                    <input  type="hidden" value="<?php echo $extraerDatos['asegurado'];  ?>" name="asegurado">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_edificacion'];  ?>" name="nombreedificacion">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_persona_atiende'];  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contactopersonaatiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_firma_inspectora'];  ?>" name="firmainspectora">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_pais'];  ?>" name="pais">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_departamento'];  ?>" name="departamento">
                    <input  type="hidden" value="<?php echo $extraerDatos['id_ciudad'];  ?>" name="ciudad">
                    <input  type="hidden" value="<?php echo $extraerDatos['fecha_inspeccion'];  ?>" name="fecha_inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'];  ?>" name="numero_inspeccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_oficina'];  ?>" name="oficina_nombre">
                    <input  type="hidden" value="<?php echo $extraerDatos['nombre_persona_atiende'];  ?>" name="nombre_persona_atiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contacto_persona_atiende">
                    <input  type="hidden" value="<?php echo $extraerDatos['fecha_posible_inspeccion'];  ?>" name="fecha_posible_inspeccion">
                    <button class="btn_verde" type="submit" name="">Ver</button>
                  </form>
                <?php
                }
                  /*
                  <form action="controller/controllerencabezado.php" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                      <button class="btn_rojo" type="submit" name="desactivarEncabezado">Desactivar</button>
                  </form>
                  */
                  ?>
                
                  </form>
                  <?php
                  /*
                   <form action="asignarinspectores.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                      <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                      <button class="btn_verde" type="submit">Asignar Inspectores</button>
                  </form>
                  */
                  ?>
               </div>
              </div>
            </div> 
                <?php
                }
            
            }
            /*
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultaencabezado = $bloques->consultaenccompanias();
            while ($extraerDatos =  $bloques->obtener_fila($consultaencabezado)){
            */
          ?>
              
            
              
            <?php

            //}
             
          ?>
            </div>
            <div class="cont_fin"></div>
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>