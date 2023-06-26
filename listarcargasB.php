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
        <title>Listado de Cargas</title>
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
            <center><i class="fa-solid fa-user"></i> LISTADO DE CARGAS</center>
        </div>
        
        <div class="link_int"></div>
        
        <div class="titulo2"><i class="fa-solid fa-upload"></i><a href="cargueB.php"> Cargar</a></div></div>
            
        <div class="titulo1">
            <form action="listarcargasB.php" method="POST">
                <center>
                    <button class="btn_azul" type="submit" name="procesar" >Procesar Impacto Riesgo</button>
                </center>
            </form>
            
        </div>
            
          <div class="contenedor_titulos">
            <div class=" titulo"><b>Campo 1</b></div>
            <div class=" titulo"><b>Campo 2</b></div>
            <div class=" titulo"><b>Campo 3 </b></div>
            <div class=" titulo"><b>Campo <br> 4</b></div>
            <div class=" titulo"><b>Campo <br> 5</b></div>
            <div class=" titulo"><b>Campo <br> 6</b></div>
            <div class=" titulo"><b>Campo <br> 7</b></div>
            <div class=" titulo"><b>Campo <br> 8</b></div>
            <div class=" titulo"><b>Campo <br> 9</b></div>
            <div class=" titulo"><b>Campo <br> 10</b></div>
            <div class=" titulo"><b>Campo <br> 11</b></div>
            <div class=" titulo"><b>Campo <br> 12</b></div>
            <div class=" titulo"><b>Campo <br> 13</b></div>
            <div class=" titulo"><b>Campo <br> 14</b></div>
            <div class=" titulo"><b>Campo <br> 15</b></div>
            <div class=" titulo"><b>Campo <br> 16</b></div>
            <div class=" titulo"><b>Campo <br> 17</b></div>
            <div class=" titulo"><b>Campo <br> 18</b></div>
            <div class=" titulo"><b>Campo <br> 19</b></div>
            <div class=" titulo"><b>Campo <br> 20</b></div>
            <div class=" titulo"><b>Campo <br> 21</b></div>
            <div class=" titulo"><b>Campo <br> 22</b></div>
            <div class=" titulo"><b>Campo <br> 23</b></div>
            <div class=" titulo"><b>Campo <br> 24</b></div>
            <div class=" titulo"><b>Campo <br> 25</b></div>
            <div class=" titulo"><b>Campo <br> 26</b></div>
            <div class=" titulo"><b>Campo <br> 27</b></div>

          </div>
    
    
          <?php
           
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultacargamasiva = $bloques->consultardatoscargamasiva();
            while ($extraerDatos =  $bloques->obtener_fila($consultacargamasiva)){
          ?>
            <div class="contenedor">
                
                <div class="campos_f">
                     <?php echo $extraerDatos['campo1']; ?>
                </div>
                <div class="campos_f">
                     <?php echo $extraerDatos['campo2']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['campo3']; ?>
                </div>
                <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo5'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo6'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo7'];
                  ?>
                </div>
                
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo8'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo9'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo10'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo11'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo12'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo13'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo14'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo15'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo16'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo17'];
                  ?>
                </div>
                 <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo18'];
                  ?>
                </div>
                <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo19'];
                  ?>
                </div>
                <div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo20'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo21'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo22'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo23'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo24'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo25'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo26'];
                  ?>
                </div><div class="campos_f">
                  <?php 
                    echo $extraerDatos['campo27'];
                  ?>
                </div>
              </div>
            </div> 
              
            <?php

            }
             
          ?>
           <?php
            
            if(isset($_POST['procesar'])){
                
                $ejecutarFunction = $mysqli->query("SELECT prc_carga_masiva_columnas(1) AS Resultado");
                $extraerDatosFunction = $ejecutarFunction->fetch_array(MYSQLI_ASSOC);
                $resultadoEjecutaFuncion = $extraerDatosFunction['Resultado'];
                
                if($resultadoEjecutaFuncion == 1){
                     echo '<script>alert("EXITOSO")</script>';
                }else{
                    echo '<script>alert("ERROR")</script>';
                }
                
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