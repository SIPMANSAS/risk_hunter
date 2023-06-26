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
        <title>Historial de Cargas</title>
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
            <center><i class="fa-solid fa-user"></i> ARCHIVOS CARGADOS</center>
        </div>
        
        <div class="link_int">
        <div class="titulo2"><i class="fa-solid fa-upload"></i><a href="pruebacarga.php"> Cargar</a></div></div>
        <div class="titulo1">
            <form action="listarcargas.php" method="POST">
                <center>
                    <button class="btn_azul" type="submit" name="procesar" >Procesar</button>
                </center>
            </form>
        </div>
        <?php
        /*
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Firma Inspectora..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        */
        ?>
                 
          <?php
            if(isset($_POST['procesar'])){
                echo '<script>alert("ENTRA")</script>';
                include 'conexion/conexion.php';
                $acentos = $mysqli->query("SET NAMES utf8");
                $consulta = $mysqli->query("SELECT prc_cargue_archivos_planos(1) AS Resultado");
                $extraerDatos = $consulta->fetch_array(MYSQLI_ASSOC);
                $resultadoconsulta = $extraerDatos['Resultado'];
                
                if($resultadoconsulta == 1){
                    echo '<script>alert("EXITOSO")</script>';
                }else{
                    echo '<script>alert("ERROR")</script>';
                }
            }
            ?>
            
            <div class="contenedor_titulos">
                <div class=" titulo"><b>Cadena</b></div>
            </div>
           
                <?php
                    $bloques    = new bloques;
                    $consulta = $bloques->iniciarVariables();
                    $consultafiles = $bloques->consultaarchivoscantidad();
                    $extraerDatosA = $bloques->obtener_fila($consultafiles);
                    $cantidad = $extraerDatosA['Cantidad'];
                    $consultarchivos = $bloques->consultaarchivos();
                    if($cantidad == 0){
                    ?>
                        <div class="contenedor">
                            <div class="campos_f"><?php  echo 'SIN DATOS'; ?></div>
                        </div>
                    <?php
                    }else{
                        while ($extraerDatos =  $bloques->obtener_fila($consultarchivos)){
                        ?>
                        <div class="contenedor">
                            <div class="campos_f2"><?php echo utf8_encode('<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. utf8_decode($cadena = $extraerDatos['cadena']).'</center>'); ?></div>
                        </div>
                        <?php
                        }
                        ?>
                        
                        <div class="cont_fin">
                            
                        </div>
                    </div> 
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