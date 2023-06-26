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
        <title>Firmas Inspectoras</title>
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
                url: "funcioness/obtienesearchfirmas.php",
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
            <center><i class="fa-solid fa-user"></i> FIRMAS INSPECTORAS ACTIVAS</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listarfirmasdesactivadas.php"> Listar Firmas Inspectoras Bloqueadas</a></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="registrofirmasinspectoras.php"> Crear Firma Inspectora</a></div></div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Firma Inspectora..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
          <div class="contenedor_titulos">
            <div class=" titulo">ID</div>
            <div class=" titulo"><b>Nombre Firma</b></div>
            <div class= "titulo"><b>NIT / CC</b></div>
            <div class=" titulo"><b>Número de Contacto</b></div>
            <div class=" titulo"><b>E-mail</b></div>
            <div class=" titulo"><b>Dirección</b></div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
          
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultafirmas = $bloques->consultafirmasactivas();
            while ($extraerDatos =  $bloques->obtener_fila($consultafirmas)){
          ?>
            <div class="contenedor">
                <div class="campos_f">
                  <form action="verfirmasinspectora.php" id="form" method="POST">
                      <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatos['identificacion'] ?>" ></div>
                      <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_alfanumerico'];?>" name="tipdocletra"?>
                      <input  type="hidden" value="<?php echo $extraerDatos['vdom_tipo_identificacion'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                      <input  type="hidden" value="<?php echo $extraerDatos['telefono'];  ?>" name="telefono">
                      <input  type="hidden" value="<?php echo $extraerDatos['correo_electronico'];  ?>" name="correo_electronico">
                      <input  type="hidden" value="<?php echo $extraerDatos['numero_identificacion'];  ?>" name="numeroidentificacion">
                      <input  type="hidden" value="<?php echo $extraerDatos['pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $extraerDatos['departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $extraerDatos['ciudad'];  ?>" name="ciudad">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_tercero'];  ?>" name="id_tercero">
                      <input  type="hidden" value="<?php echo $extraerDatos['tipoCliente'];  ?>" name="tipoCliente">
                      <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificacion'] ?>">
                  </form>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['nombres']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['id_alfanumerico'].'-'.$extraerDatos['numero_identificacion']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['telefono']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['correo_electronico']; ?>
                </div>
              <div class="campos_f">
                  <?php 
                    /*echo $extraerDatos['pais'].'-'.$extraerDatos['departamento'].'-'.$extraerDatos['ciudad'];*/ 
                    echo $extraerDatos['direccion'];
                  ?>
              </div>
                <div class="campos_f">
                  <form action="editarfirmas.php" method="POST">
                        <input  type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="idFirma">
                        <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                        <input  type="hidden" value="<?php echo $extraerDatos['vdom_tipo_identificacion'];  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $extraerDatos['telefono'];  ?>" name="telefono">
                        <input  type="hidden" value="<?php echo $extraerDatos['correo_electronico'];  ?>" name="correo_electronico">
                        <input  type="hidden" value="<?php echo $extraerDatos['numero_identificacion'];  ?>" name="numeroidentificacion">
                        <input  type="hidden" value="<?php echo $extraerDatos['pais'];  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $extraerDatos['departamento'];  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $extraerDatos['ciudad'];  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_tercero'];  ?>" name="id_tercero">
                        <input  type="hidden" value="<?php echo $extraerDatos['tipoCliente'];  ?>" name="tipoCliente">
                      <button class="btn_azul" type="submit" name="editarFirma">Editar</button>
                  </form>
                  <form action="controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                      <button class="btn_rojo" type="submit" name="desactivarFirma">Bloquear</button>
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