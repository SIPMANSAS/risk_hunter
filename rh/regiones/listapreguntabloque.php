    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Preguntas</title>
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
                url: "funciones/obtienesearchfirmas2.php",
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
    
            include "conexion/Conexion2.php";
            include_once  "clases/Json.class.php";
            $db =  connect();
            $query = $db->query("select * from rg_paises");
            $countries = array();
            while ($r = $query->fetch_object()) {
              $countries[] = $r;
            }
        ?>
             <?php include 'header-rh.php'; ?>
        <div class="titulo_p">
            <center><i class="fa-solid fa-question"></i> PREGUNTAS BLOQUE</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href=""> </a></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href=""> </a></div></div>
        
        <?php
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Preguntas ..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';
        
        ?>
    
          <div class="contenedor_titulos">
        <div class=" titulo">ID</div>
        <div class=" titulo"><b>Usuario</b></div>
        <div class= "titulo"><b>Nombre Inspector</b></div>
        <div class=" titulo"><b>Fecha Registro</b></div>
        <div class=" titulo"><b>Acciones</b></div>
      </div>
    
          <?php
    
          include 'conexion/conexion.php';
    
          $ConsultaDatos = $mysqli->query("SELECT * FROM `v_detalle_encuestas` GROUP BY id_encuesta");
    
          while ($extraerDatos = $ConsultaDatos->fetch_array()) {
    
          ?>
            <div class="contenedor">
              <div class="campos_f">
                  <form action="vercompaniaseguros.php" id="form" method="POST">
                      <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatos['id_encuesta'] ?>" ></div>
                      <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['id_encuesta'] ?>">
                  </form>
              </div>
              <div class="campos_f"><?php echo $extraerDatos['usuario']; ?></div>
              <div class="campos_f"><?php echo $extraerDatos['nombre'].' '.$extraerDatos['apellidos']; ?></div>
              <div class="campos_f"><?php echo $extraerDatos['fecha_creacion']; ?></div>
              <div class="campos_f">
                  <form action="exportarencuesta.php" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_encuesta'];  ?>" name="idencuesta">
                      <button class="btn_azul" type="submit" name="exportar">Exportar Excel</button>
                  </form>
                  <form action="ejemplopdf.php" method="POST" target="_blank">
                      <input type="hidden" value="<?php echo $extraerDatos['id_encuesta'];  ?>" name="idencuesta">
                      <button class="btn_verde" type="submit" name="exportarPDF">Exportar PDF</button>
                  </form>
                  <?php
                  /*
                  <form action="exportarencuestapdf.php" method="POST" target="_blank">
                      <input type="hidden" value="<?php echo $extraerDatos['id_encuesta'];  ?>" name="idencuesta">
                      <button class="btn_verde" type="submit" name="exportarPDF">Exportar PDF</button>
                  </form>
                  <form action="pdfprueba.php" method="POST" target="_blank">
                      <input type="hidden" value="<?php echo $extraerDatos['id_encuesta'];  ?>" name="idencuesta">
                      <button class="btn_azul" type="submit" name="exportarPDF">Exportar PDF V2</button>
                  </form>
                  */
                  ?>
               </div>
               
            </div>   
          <?php
          }
          ?>
            </div>
            <div class="cont_fin"></div>
    <?php include '../footer.php'; ?>
    
    </body>
    
    </html>