<?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
    
        include  "clases/bloques.class.php";
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Parametrización</title>
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
    	$.ajax({
                type: "POST",
               url: "funcioness/obtienesearchfirmas2.php",
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
            <center><i class="fa-solid fa-user"></i>Parametrización</center>
        </div>
        
        
    
    
    <div class="link_int">
        <div class="titulo2"><i class="fa-solid fa-list"></i><a href="parametrizacion.php"> Listar Parametrizaciones Activas</a></div>
    
        </div>
        
        <?php
        /*
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Parametrización..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        */
        ?>
        <div class="contenedor_titulos">
            <div class=" titulo">ID</div>
            <div class=" titulo"><b>Asunto</b></div>
            <div class= "titulo"><b>Texto</b></div>
            <div class=" titulo"><b>Remitente</b></div>
            <div class=" titulo"><b>CC</b></div>
            <div class=" titulo"><b>Acciones</b></div>
        </div>
    
          <?php
    
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultacompanias = $bloques->consultalistaparametrizacioninactiva();
    
            while ($extraerDatos =  $bloques->obtener_fila($consultacompanias)){
    
          ?>
            <div class="contenedor">
              <div class="campos_f">
                  <form action="" id="form" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="id_parametrizacion">
                      <input  type="hidden" value="<?php echo $extraerDatos['asunto'];  ?>" name="asunto">
                      <input  type="hidden" value="<?php echo $extraerDatos['texto'];?>" name="texto"?>
                      <input  type="hidden" value="<?php echo $extraerDatos['textof'];  ?>" name="texto_of">
                      <input  type="hidden" value="<?php echo $extraerDatos['remitente'];  ?>" name="remitente">
                      <input  type="hidden" value="<?php echo $extraerDatos['cc'];  ?>" name="cc">
                      <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatos['identificador'] ?>" ></div>
                  </form>
              </div>
              <div class="campos_f"><?php echo $extraerDatos['asunto']; ?></div>
              <div class="campos_f"><?php echo $extraerDatos['texto']; ?></div>
              <div class="campos_f"><?php echo $extraerDatos['remitente']; ?></div>
              <div class="campos_f"><?php echo $extraerDatos['cc']; ?></div>
              
              
                <div class="campos_f">

                    <form action="controller/controllerparametrizacion.php" method="POST">
                        <input  type="hidden" value="<?php echo $extraerDatos['identificador'];  ?>" name="id_parametrizacion">
                        <input  type="hidden" value="<?php echo $extraerDatos['asunto'];  ?>" name="asunto">
                        <input  type="hidden" value="<?php echo $extraerDatos['texto'];?>" name="texto"?>
                        <input  type="hidden" value="<?php echo $extraerDatos['textof'];  ?>" name="texto_of">
                        <input  type="hidden" value="<?php echo $extraerDatos['remitente'];  ?>" name="remitente">
                        <input  type="hidden" value="<?php echo $extraerDatos['cc'];  ?>" name="cc">
                        <button class="btn_verde" type="submit" name="activarparametrizacion">Activar</button>
                    </form>
               </div>
            </div>   
          <?php
          }
          ?>
            </div>
            <div class="cont_fin"></div>
    <?php include 'footer.php'; ?>
    
    </body>
    
    </html>