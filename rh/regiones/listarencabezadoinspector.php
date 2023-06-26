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
                url: "funcioness/obtienesearchencabezadofirmas.php",
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
            <center><i class="fa-solid fa-user"></i> ENCABEZADOS INSPECTOR</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class=""></i><a href=""></a></div>
        <div class="titulo3"><a href=""></a></div></div>
        
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
            <div class=" titulo">Número de Inspección</div>
            <div class=" titulo">Compañia de Seguros</div>
            <div class=" titulo">Firma Inspectora</div>
            <div class=" titulo"><b>Fecha Solicitud</b></div>
            <div class=" titulo">Ciudad de Inspección</div>
            <div class=" titulo">Fecha de Inspección</div>
            <div class=" titulo"><b>Editar Inspección</b></div>
            <div class=" titulo">Estado</div>

          </div>
    
          <?php
          
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultaencabezado = $bloques->consultaencabezadoinspector();
            while ($extraerDatos =  $bloques->obtener_fila($consultaencabezado)){
          ?>
            <div class="contenedor">
                 <form action="verencabezadoinspector.php" id="form" method="POST">
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
                        <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contacto_persona_atiende">
                        <input  type="hidden" value="<?php echo $extraerDatos['fecha_posible_inspeccion'];  ?>" name="fecha_posible_inspeccion">
                      </form>
                <div class="campos_f">
                  <?php echo $extraerDatos['numero_inspeccion']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['cia_seguros']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['firma_inspectora']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['fecha_solicitud']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['ciudad']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['fecha_inspeccion']; ?>
                </div>
                <div class="campos_f">
                  <form action="editarencabezadoinspector.php"  method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                      <input  type="hidden" value="<?php echo $extraerDatos['numero_inspeccion'];  ?>" name="numero_inspeccion">
                       <input  type="hidden" value="<?php echo $extraerDatos['cia_seguros'];  ?>" name="cia_seguros">
                      <input  type="hidden" value="<?php echo $extraerDatos['fecha_solicitud'];  ?>" name="fechasolicitud">
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
                      <input  type="hidden" value="<?php echo $extraerDatos['contacto_persona_atiende'];  ?>" name="contacto_persona_atiende">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_inspector'];  ?>" name="id_inspector">
                      <input  type="hidden" value="<?php echo $extraerDatos['nombre_inspector'];  ?>" name="inspector">
                      <input  type="hidden" value="<?php echo $extraerDatos['numero_telefono'];  ?>" name="telefono">
                      <input  type="hidden" value="<?php echo $extraerDatos['nombre_asigna'];  ?>" name="nombreasigna">
                      <input  type="hidden" value="<?php echo $extraerDatos['telefono_asigna'];  ?>" name="telefonoasigna">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_asigna'];  ?>" name="idasigna">
                      <input  type="hidden" value="<?php echo $extraerDatos['fecha_posible_inspeccion'];  ?>" name="fecha_posible_inspeccion">
                      <button class="btn_azul" type="submit" name="editarEncabezado">Editar </button>
                  </form>
                  <?php
                  /*
                  <form action="controller/controllerencabezado.php" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                      <button class="btn_rojo" type="submit" name="desactivarEncabezado">Desactivar</button>
                  </form>
                  
                  ?>
                  <form action="" method="POST">
                       <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="identificador">
                       <button class="btn_verde" type="submit" name="">Descargar</button>
                  </form>
                      
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
                <div class="campos_f">
                    <?php echo $extraerDatos['estado']; ?>
                </div>

              </div>
            </div> 
              
            <?php

            }
             
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