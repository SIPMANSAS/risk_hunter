    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inspectores Independientes</title>
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
                url: "funcioness/obtienesearchinspectoresindependientes.php",
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
            <center><i class="fa-solid fa-user"></i> INSPECTORES INDEPENDIENTES ACTIVOS</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listainspectoresdesactivados.php"> Listar Inspectores Desactivados</a></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="registroinspectoresindependientes.php"> Crear Inspector Independiente</a></div></div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Inspector..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
          <div class="contenedor_titulos">
            <div class=" titulo">ID</div>
            <div class=" titulo"><b>Nombre Inspector</b></div>
            <div class= "titulo"><b>Identificación</b></div>
            <div class=" titulo"><b>Numero de Contacto</b></div>
            <div class=" titulo"><b>E-mail</b></div>
            <div class=" titulo"><b>Dirección</b></div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
          
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultainspectoresindpendientes = $bloques->consultainspectoresindependientes();
            while ($extraerDatos =  $bloques->obtener_fila($consultainspectoresindpendientes)){
          ?>
            <div class="contenedor">
                <div class="campos_f">
                  <form action="verinspectorindependiente.php" id="form" method="POST">
                      <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatos['identificador'] ?>" ></div>
                      <input  type="hidden" value="<?php echo $extraerDatos['nombre'];  ?>" name="nombreinspector">
                      <input  type="hidden" value="<?php echo $extraerDatos['apellidos'];  ?>" name="apellidoInspector">
                      <input  type="hidden" value="<?php echo $extraerDatos['vdom_tipo_identificacion'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                      <input  type="hidden" value="<?php echo $extraerDatos['numero_telefono'];  ?>" name="telefono">
                      <input  type="hidden" value="<?php echo $extraerDatos['email'];  ?>" name="correo_electronico">
                      <input  type="hidden" value="<?php echo $extraerDatos['numidentificacion'];  ?>" name="numeroidentificacion">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_ciudad'];  ?>" name="ciudad">
                      <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificador'] ?>">
                  </form>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['nombre'].' '.$extraerDatos['apellidos']; ?>
                </div>
                <div class="campos_f">
                    <?php /*$extraerDatos['vdom_tipo_identificacion'].'-'.*/echo $extraerDatos['numidentificacion']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['numero_telefono']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['email']; ?>
                </div>
              <div class="campos_f">
                  <?php 
                    /*echo $extraerDatos['pais'].'-'.$extraerDatos['departamento'].'-'.$extraerDatos['ciudad'];*/ 
                    echo utf8_encode($extraerDatos['direccion']);
                  ?>
              </div>
                <div class="campos_f">
                  <form action="editarinspector.php" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['nombre'];  ?>" name="nombreinspector">
                      <input  type="hidden" value="<?php echo $extraerDatos['apellidos'];  ?>" name="apellidoInspector">
                      <input  type="hidden" value="<?php echo $extraerDatos['vdom_tipo_identificacion'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo utf8_encode($extraerDatos['direccion']);;  ?>" name="direccion">
                      <input  type="hidden" value="<?php echo $extraerDatos['numero_telefono'];  ?>" name="telefono">
                      <input  type="hidden" value="<?php echo $extraerDatos['email'];  ?>" name="correo_electronico">
                      <input  type="hidden" value="<?php echo $extraerDatos['numidentificacion'];  ?>" name="numeroidentificacion">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_ciudad'];  ?>" name="ciudad">
                      <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificador'] ?>">
                      <button class="btn_azul" type="submit" name="editarInspector">Editar</button>
                  </form>
                  <form action="controller/controllerFirmas.php" method="POST">
                     <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificador'] ?>">
                      <button class="btn_rojo" type="submit" name="desactivarinspectorindependiente">Desactivar</button>
                  </form>
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