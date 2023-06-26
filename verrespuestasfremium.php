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
        <title>Detalle de la inspección</title>
          <link rel="shortcut icon" href="favicon.ico">
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
            <center><i class="fa-solid fa-search"></i> DETALLE DE LA INSPECCIÓN</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listarinspeccionesfree.php"> Regresar</a></div>
        </div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">

        </div>
        </div>';
        
        ?>
          <div class="contenedor_titulos">
            <div class=" titulo">Pregunta</div>
            <div class=" titulo">Respuesta</div>
            <!--<div class=" titulo"><b>Archivos</b></div>-->
          </div>
    
          <?php
            
            
            $id_encuesta = $_POST['id'];
            '<br>';
            $identificador = $_POST['identificador'];
            

            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultasabana = $bloques->consultadetalleinspeccionB($id_encuesta);//$id_menu_p
    
            while ($extraerDatos =  $bloques->obtener_fila($consultasabana)){
                $bloque_pregunta = $extraerDatos['bloque_pregunta'];
                $pregunta = $extraerDatos['nombre'];
                $respuesta = $extraerDatos['textoR'];
                $archivos = $extraerDatos['archivos'];
                $respuestaB = $extraerDatos['respuesta_texto'];

        
        ?>
            <div class="contenedor">
                <div class="campos_f">
                  <?php echo ($pregunta); ?>
                </div>
                 <div class="campos_f">
                  <?php echo $respuestaB; ?>
                </div>
                <?php
                /*
                <div class="campos_f">
                    <form method="GET" target="_blank" >
                        <button class="btn_verde">Descargar</button>
                    </form>
                   
                    <a  class="btn_azul" href="javascript:popUp('detalleinspeccionB.php?id=<?php echo $id_encuesta ?>')">Ver Lista Bienes</a>
                    <script type="text/javascript">
                    function popUp(URL) {
                        window.open(URL, 'detalleinspeccion.php?id=<?php echo $id_encuesta ?>', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=1500,height=500,left = 100,top = 50');
                    }
                    </script>
                
                </div>
                 */
                 ?>
            </div>
                
            <?php
            }
    
          ?>
            </div>
    

    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>