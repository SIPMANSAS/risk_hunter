<!DOCTYPE html>
 <?php include 'sec_login.php'; ?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspector Independiente</title>
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
            url: "funciones/obtienesearchusuario.php",
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
                        $('#idfirma').val(id);
                        
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

        include "conexion/Conexion2.php";
        include_once  "clases/Json.class.php";
        include 'header-rh.php';
        
    ?>
    <div class="titulo_p">
        <center><i class="fa-solid fa-user"></i> INFORMACION INSPECTOR INDEPENDIENTE</center>
    </div>
    
    <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listainspectoresindependientes.php"> Regresar</a></div>
    </div>


      <div class="contenedor_titulos">
        <div class=" titulo"><b>Nombre Firma</b></div>
        <div class=" titulo"><b>Identificación</b></div>
        <div class=" titulo"><b>Dirección</b></div>
        <div class=" titulo"><b>Numero de Contacto</b></div>
        <div class=" titulo"><b>E-mail</b></div>
        <div class=" titulo"><b>Acciones</b></div>
      </div>

      <?php
      $nombreinspector = $_POST['nombreinspector'];
      $direccion = ($_POST['direccion']);
      $telefono = $_POST['telefono'];
      $correo_electronico = $_POST['correo_electronico'];
      $numeroidentificacion = $_POST['numeroidentificacion'];
      $id = $_POST['id'];
      $tipdocletra = $_POST['tipodocumento'];

      ?>
        <div class="contenedor">
          <div class="campos_f"><?php echo $nombreinspector ?></div>
          <div class="campos_f"><?php echo $tipdocletra.'-'.$numeroidentificacion; ?></div>
          <div class="campos_f"><?php echo utf8_encode($direccion) ?></div>
          <div class="campos_f"><?php echo $telefono ?></div>
          <div class="campos_f"><?php echo $correo_electronico ?></div>
             <div class="campos_f">
                  <form action="controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $id;  ?>" name="id">
                      <button class="btn_verde" type="submit" name="activarfirma">Activar</button>
                  </form>
               </div>
        </div>   
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