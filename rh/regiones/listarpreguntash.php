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
        <title>Preguntas</title>
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
            <center><i class="fa-solid fa-question"></i> PREGUNTAS</center>
        </div>
        
        <div class="contenedor_titulos">
            <div class=" titulo">
                <b><?php echo  $preguntapadretext = ($_POST['nombrepadre']);?></b>
            </div>
        </div>
        
       
        
        <?php
        /*
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Inspector..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        */
        ?>
          <div class="contenedor_titulos">
            <div class=" titulo"><b>Nombre Pregunta</b></div>
            <div class= "titulo"><b>Respuesta</b></div>
            <div class=" titulo"><b>Valor Respuesta Cierre</b></div>
            <div class=" titulo"><b>Valor Respuesta Activa Riesgo</b></div>
            <div class=" titulo"><b>Estado</b></div>
          </div>
    
          <?php
           
            $id_pregunta_padre = $_POST['idpregunta'];
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultapreguntasP = $bloques->preguntashijas($id_pregunta_padre);
            
             while ($extraerDatos =  $bloques->obtener_fila($consultapreguntasP)){
          ?>
            <div class="contenedor">
                <div class="campos_f">
                  <?php echo utf8_encode($extraerDatos['nombre']);?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['respuesta']; //echo $extraerDatos['id_alfanumerico'].'-'. ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['RespuestaCierre']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['RespuestaActivaCierre']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['estado']; ?>
                </div>

            </div>
            <?php
            }
          ?>
            </div>
             
            <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
              <script>
                  function close_tab(){
                      window.close();
                  }
              </script></div>
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>