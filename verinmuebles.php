<?php 

$identificadorB = $_POST['identificador'];

?>


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
        <title>Lista de Inmuebles</title>
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
                url: "funcioness/obtienesearchinmuebles.php",
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
            <center><i class="fa-solid fa-user"></i> LISTA DE BIENES A INSPECCIONAR</center>
        </div>
        <?php
        /*
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-download"></i><a Onclick="window.location='exportacion/exportarencabezadocompaniaseguros.php'"> Exportar Listado Inspecciones Compa単ias de Seguros</a></div>
        */
        ?>
        <div class="link_int"><div></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="crearbienes.php"> Adicionar bien a inspeccionar</a></div></div>
        
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
            <div class=" titulo">Bien Principal</div>
            <div class=" titulo">Inmueble</div>
            <div class=" titulo">Tipo</div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
            $filtro=$identificadorB ;
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultainmuebles = $bloques->consultainmueblesB($filtro);
            while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)){
          ?>
              
            <div class="contenedor">
                <form action="verinmuebles.php" id="form" method="POST">
                    <input type="hidden" value="<?php echo $extraerDatos['identificador'] ?>" name="identificador">
                    <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                </form>
                <div class="campos_f">
                  <?php echo $extraerDatos['id_bien_principal']; ?>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['tipo_bien']; ?>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['descripcion']; ?>
                </div>
                 
                <div class="campos_f">
                  <form action="" method="POST">
                    <input type="hidden" value="<?php echo $identificadorB?>" name="id_encuesta">
                    <input type="hidden" value="<?php echo $extraerDatos['identificador'] ?>" name="identificador">
                    <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                    <button class="btn_azul" type="submit" name="inspeccionar">Inspeccionar</button>
                  </form>
                  <?php
                ?>
                <div class="campos_f">
                  <form action="verinmuebles.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatos['identificador'] ?>" name="identificador">
                    <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                  </form>
                <?php
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