    <?php 
    
        include 'sec_login.php';
        include  "clases/bloques.class.php";
        include 'conexion/conexion.php';
        
       
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matriz de Riesgos</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
          <link rel="shortcut icon" href="favicon.ico">
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
            <center><i class="fa-solid fa-check"></i> MATRIZ DE RIESGOS</center>
        </div>
        
    
        <div class="link_int">
        </div>
        
          <div class="contenedor_titulos">
            <div class=" titulo">Inmueble</div>
            <div class=" titulo">Pregunta</div>
            <div class=" titulo">Riesgo</div>
            <div class=" titulo">Respuesta Activa Riesgo</div>
            <div class=" titulo">Respuesta Inspector</div>
          </div>
    
          <?php
           
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            echo $identificador_bien = $_POST['identificador_bien'];
            echo $id_encuesta = $_POST['id_encuesta'];
            $consultainmuebles = $bloques->consultaDataMatriz($identificador_bien,$id_encuesta);

            while ($extraerDatos =  $bloques->obtener_fila($consultainmuebles)){
                $nombreInmueble = $extraerDatos['inmueble'];

            ?>
                
            <div class="contenedor">
                <form action="verinmuebles.php" id="form" method="POST">
                    <input type="hidden" value="<?php echo $id=$extraerDatos['identificador'] ?>" name="identificador">
                    <input type="hidden" value="<?php echo $extraerDatos['descripcion'] ?>" name="descripcion">
                    <input  type="hidden" value="<?php echo $extraerDatos['tipo_bien'];  ?>" name="tipobien">
                </form>

                <div class="campos_f">
                  <?php echo $extraerDatos['inmueble']; ?>
                </div>
                <div class="campos_f">
                  <?php echo utf8_encode($extraerDatos['pregunta']); ?>
                </div>
                <div class="campos_f">
                  <?php echo utf8_encode($extraerDatos['riesgo']); ?>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['respuesta_activa_riesgo']; ?>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['respuesta_inspector']; ?>
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