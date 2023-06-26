<?php
//include 'conexion/conexion.php';
include  "clases/bloques.class.php";

$id=$_REQUEST['id'];

$bloques = new bloques;
$consultaA = $bloques->iniciarVariables();
$consultaAA = $bloques->consultacantidadB($id);


?>
    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>

    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle Inspección</title>
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
            <center><i class="fa-solid fa-search"></i> DETALLE INSPECCIÓN</center>
        </div>
        
        <div class="link_int"><div class=""></div>
        </div>
        <br>
        <br>
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">

        </div>
        </div>';
        ?>
        <div class="contenedor_titulos">
        <?php

        $consultaCantidadB = $bloques->consultacantidadB($id);
        $cantidadExtrae = $bloques->obtener_fila($consultaCantidadB);
        $cantidadB = $cantidadExtrae['Cantidad'];
       

        $j == 0;
        $consultaprevia = $bloques->consultaprevia($id);
        while($extraerDatos = $bloques->obtener_fila($consultaprevia)){
            $j = $j+1;
            if($j <> $cantidadB){
        ?>
            <div class=" titulo"><?php echo ($extraerDatos['nombre'])?></div>
          <?php
            }else{
                $valornumerico = $extraerDatos['nombre'];
            }
        }
        while($j <= 6){
            if($j == 6){
            ?>
            <div class=" titulo"><?php echo utf8_decode($valornumerico)?></div>
            <?php
            }else{
                
            ?>    
                <div class= "titulo"><?php echo '-' ?></div>
            <?php
            }
            $j = $j+1;
        }
    
        ?>
           </div>
        <?php
            $consultaC = $bloques->consultaenclistabienes($id);
            while($extraerData = $bloques->obtener_fila($consultaC)){
                $identificador = $extraerData['identificador'];
                $texto1 = $extraerData['texto1'];
                $texto2 = $extraerData['texto2'];
                $texto3 = $extraerData['texto3'];
                $texto4 = $extraerData['texto4'];
                $texto5 = $extraerData['texto5'];
                $valornumerico = $extraerData['valor_numerico'];
                
                if($texto1 == ' ' || $texto1 == NULL){
                    $texto1 = '-';
                }
                if($texto2 == ' ' || $texto2 == NULL){
                    $texto2 = '-';
                }
                if($texto3 == ' ' || $texto3 == NULL){
                    $texto3 = '-';
                }
                if($texto4 == ' ' || $texto4 == NULL){
                    $texto4 = '-';
                }
                if($texto5 == ' ' || $texto5 == NULL){
                    $texto5 = '-';
                }
                if($valornumerico == ' ' || $valornumerico == NULL){
                    $valornumerico = '-';
                }

            ?>
            
            <div class="contenedor">
                <div class="campos_f">
                 <?php echo ($texto1); ?>
                </div>
                 <div class="campos_f">
                 <?php echo $texto2; ?>
                </div>
                 <div class="campos_f">
                 <?php echo $texto3; ?>
                </div>
                 <div class="campos_f">
                 <?php echo $texto4; ?>
                </div>
                <div class="campos_f">
                 <?php echo $texto5; ?>
                </div>
                 <div class="campos_f" style="text-align:right">
                 <?php echo number_format($valornumerico); ?>
                </div>
                
            </div>
            <?php
            }
    
          ?>
          <?php
            $consultasumaB = $bloques->realizasuma($id);
            $sumaExtrae = $bloques->obtener_fila($consultasumaB);
            $resultadoSumaB = $sumaExtrae['total'];

            ?>
            <div class="contenedor">
                <div class="campos_f">
                 
                </div>
                 <div class="campos_f">
                
                </div>
                 <div class="campos_f">
                 
                </div>
                 <div class="campos_f">
                 
                </div>
                <div class="campos_f">
                 <?php echo '<b>TOTAL</b>'; ?>
                </div>
                 <div class="campos_f" style="text-align:right">
                 <?php echo number_format($resultadoSumaB); ?>
                </div>
                
            </div>
            </div>
            <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
            <script>
                function close_tab(){
                    window.close();
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