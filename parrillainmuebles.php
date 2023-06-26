    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
        
        include  "clases/bloques.class.php";
        include "conexion/conexion.php";
        $bloques    = new bloques;
        $consulta = $bloques->iniciarVariables();
        
        $id_inspeccionB = $_GET['id_inspeccion'];
        $id_inspeccion = $_POST['id_inspeccion'];
        $nombre_edificacion = $_POST['nombre_edificacion'];
        $direccion = $_POST['direccion'];
        $numero_inspeccion = $_POST['numero_inspeccion'];
        
        
        
        $consultaexistencia = $bloques->consultaexistenciaB($id_inspeccion);
        $extraerdatos =  $bloques->obtener_fila($consultaexistencia);
        $cantidad=$extraerdatos['Cantidad'];
        
        //////////////////REVISAR COMO PASAR ESTO A FUNCIONES YA ESTA LA FUNCION EN BLOQUES.CLASS /////////////////////////////////////////
        if($cantidad == 0){
            $constante = '763';
            $insertapadre = $mysqli->query("INSERT INTO enc_inmuebles(descripcion,tipo_bien,observaciones,id_encuesta)VALUES('$nombre_edificacion','$constante','$direccion','$id_inspeccion') ");
            //$insertapadreB = $bloques->insertapadre($nombre_edificacion,$constante,$direccion,$id_inspeccion);
        }else{
            
        }
        ////////////////////////END REVISAR//////////////////////////////////////////////////
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
          <link rel="shortcut icon" href="favicon.ico">
      
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
        
        <?php
        
        $version_usuario;
        
        $pais = $_POST['pais'];
        $departamento = $_POST['departamento'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        $nombreedificacion = $_POST['nombreedificacion'];
        $nombrepersonaatiende = $_POST['nombrepersonaatiende'];
        $contactopersonaatiende = $_POST['contactopersonaatiende'];
        $fecha_posible_inspeccion = $_POST['fecha_posible_inspeccion'];
        $fecha_inspeccion = $_POST['fecha_inspeccion'];
        $firmainspectora = $_POST['firmainspectora'];
        $id_inspector = $_POST['id_inspector'];
        $id_oficina_cia_seguros = $_POST['id_oficina_cia_seguros'];
        $numero_inspeccion = $_POST['numeroInspeccion'];
        $cia_seguros = $_POST['cia_seguros'];
        $inspector = $_POST['inspector'];
        $telefono = $_POST['telefono'];
        $nombreasigna = $_POST['nombreasigna'];
        $telefonoasigna = $_POST['telefonoasigna'];
        $idasigna = $_POST['idasigna'];
        $fecha_inspeccion = $_POST['fecha_inspeccion'];
        $identificador = $_POST['id_inspeccion'];
        
        ?>
   
        <div class="titulo_p">
            <center><i class="fa-solid fa-check"></i> LISTA DE BIENES A INSPECCIONAR</center>
        </div>

        <div class="link_int">
           <div>
               <div class="titulo2">
                    <form action="capturarubicacion.php" method="POST" target="_blank">
                        <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccion">
                        <button type="submit">+ Capturar Ubicacion </button>
                    </form>
                </div>
                <br>
                <div class="titulo2">
                    <form action="registrofotografico.php" method="" target="_blank">
                        <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccion">
                        <input type="hidden" value="<?php echo $numero_inspeccion ?>" name="numero_inspeccion">
                        <button type="submit">+ Registro Fotografico </button>
                    </form>
                </div>
            </div>
            <div class="titulo3">
                <form action="crearbienes.php" method="">
                    <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccion">
                    <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccionB">
                    <button type="submit">+ Agregar bien</button>
                </form>
            </div>
        </div>
        
          <div class="contenedor_titulos">
              <div class=" titulo">Identificador</div>
            <div class=" titulo">Bien Principal</div>
            <div class=" titulo">Inmueble</div>
            <div class=" titulo">Tipo de Bien</div>
            <div class=" titulo">Observaciones</div>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
           
            $consultabloque = $mysqli->query("SELECT * FROM enc_detalles_inspeccion WHERE id_inspeccion='$id_inspeccion'");
            $extraerdatos = $consultabloque->fetch_array(MYSQLI_ASSOC);
            $id_bloque = $extraerdatos['bloque_inspeccion'];
                
            $filtro = $id_inspeccion;
            $consultainmuebles = $bloques->consultainmuebles($filtro);
            
           
            
            while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)){
                $id=$extraerDatos['identificador'];
                
                $consultapregunta = $mysqli->query("SELECT f_primer_pregunta_bloque($id_inspeccion,$id) primer_pregunta");
                $extraerprimerpregunta = $consultapregunta->fetch_array(MYSQLI_ASSOC);
                $primerpregunta =  $extraerprimerpregunta['primer_pregunta'];
            
          ?>
                
            <div class="contenedor">
                <form action="verinmuebles.php" id="form" method="POST">
                    <input type="hidden" value="<?php echo  $id=$extraerDatos['identificador'] ?>" name="identificador">
                    <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                </form>
                <div class="campos_f">
                  <?php echo $identificadorI=$extraerDatos['identificador']; ?>
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
                  <form action="PruebaTextDevp.php" method="POST" target="_blank">
                    <input type="hidden" value="<?php echo $identificadorI?>" name="id_bloque">
                    <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                    <input type="hidden" value="<?php echo $primerpregunta ?>" name="id_pregunta">
                    
                    <!---<button class="btn_azul" name="inspeccionar" onclick="close_window();return false;">Inspeccionar</button>-->
                    <button class="btn_azul" name=inspeccionar value=Cerrar onclick="window.close()">Inspeccionar</button>
                  </form>
                 
                  <form action="inspeccionencuesta.php" method="POST" target="_blank">
                    <input type="hidden" value="<?php echo $id?>" name="id_bloque">
                    <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                    <input type="hidden" value="<?php echo $primerpregunta ?>" name="id_pregunta">
                    <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                    
                    <button class="btn_verde" name="inspeccionar">Inspeccionar NO DINAMICA</button>
                  </form>
                  <?php
                  /////////////////////// COMENTADO PORQUE ES LA FUNCION QUE SE VENDE POR FAVOR NO BORRAR IMPORTANTE!!!!!!! NO ELIMINAR POR CUESTIONES DE FUNCIONES FUTURAS /////////////////
                  /*
                  <form action="riesgosinmueble.php" method="GET" target="_blank" >
                    <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador">
                    <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                     <button class="btn_verde">Calificación<br>Riesgos</button>
                  </form>
                    <form action="generarmatriz.php" method="POST" target="_blank" >
                    <input type="hidden" value="<?php echo $identificadorI ?>" name="identificador_bien">
                    <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_encuesta">
                     <button class="btn_azul">Generar Matriz</button>
                  </form>
                    */
                    ?>

                  
                  
                  <!--
                   <form action="asignarinspectores.php" onclick="openWindow()" method="POST">
                      <input type="hidden" value="<?php //echo $extraerDatos['identificacion'];  ?>" name="id">
                      <input  type="hidden" value="<?php //echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                      <button class="btn_verde" type="submit">Asignar Inspectores</button>
                  </form>-->
                  
                  
               </div>
              </div>
            </div> 
              
            <?php

            }
            
          ?>
            </div>
              <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
              <script>
                function click(){
                  alert(Entra); 
                }
                </script>
                <script>
                    function close_tab(){
                        window.close();
                    }
                </script>
                <script>
                    function openWindow(<?php $identificadorI ?>) {
        	            window.open("riesgosinmueble.php?id=<?php echo $identificadorI ?>", "", "width=800,height=600");
                    }
                </script>
        </div>
            
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
   
    </body>
    
    </html>