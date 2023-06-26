<!DOCTYPE html>
 <?php 
    include 'sec_login.php'; 
    include "conexion/Conexion2.php";
    include_once  "clases/Json.class.php";
    include 'header-rh.php';
    include "conexion/conexion.php";
 ?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firmas Inspectoras</title>
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
    <div class="titulo_p">
        <center><i class="fa-solid fa-user"></i> INFORMACION COMPAÑIA DE SEGUROS</center>
    </div>
    
    <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listacompaniaseguros.php"> Regresar</a></div>
    </div>


      <div class="contenedor_titulos">
        <div class=" titulo"><b>Nombre Compañia de Seguros</b></div>
        <div class=" titulo"><b>Identificación</b></div>
        <div class=" titulo"><b>Dirección</b></div>
        <div class=" titulo"><b>Número de Contacto</b></div>
        <div class=" titulo"><b>E-mail</b></div>

      </div>

      <?php
      
      $id = $_POST['id'];
      $nombrecompania = $_POST['nombrefirma'];
      $numeroidentificacion = $_POST['numeroidentificacion'];
      $direccion = $_POST['direccion'];
      $telefono = $_POST['telefono'];
      $correo_electronico = $_POST['correo_electronico'];
      $pais = $_POST['pais'];
      $dep = $_POST['departamento'];
      $ciudad = $_POST['ciudad'];
      $tipdocletra = $_POST['tipdocletra'];
      echo $idusuario = $_POST['idusuario'];

      ?>
        <div class="contenedor">
          <div class="campos_f"><?php echo $nombrecompania; ?></div>
          <div class="campos_f"><?php echo $tipdocletra.'-'.$numeroidentificacion; ?></div>
          <div class="campos_f"><?php echo $direccion; ?></div>
          <div class="campos_f"><?php echo $telefono; ?></div>
          <div class="campos_f"><?php echo $correo_electronico; ?></div>
          
          
          <?php
          echo '  <input type="hidden" id="idusuario" name="idusuario" >';

          ?>
               </div>
        </div>   
      <div class="cont_fin"></div>
        <br>
        <div class="titulo_p">
            <center><i class="fa-solid fa-user"></i> FIRMAS INSPECTORAS ASIGNADAS</center>
        </div>
        <div class="contenedor_titulos">
            <div class=" titulo"><b>Número Identificación</b></div>
            <div class=" titulo"><b>Firma Inspectora</b></div>
            <div class=" titulo"><b>Teléfono</b></div>
            <div class=" titulo"><b>Correo Electrónico</b></div>
            <div class=" titulo"><b>Acciones</b></div>
        </div>
        
        <?php
            $id;
            /*
            $id;
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultafirmas = $bloques->firmasasignadas();
            //while ($extraerDatos =  $bloques->obtener_fila($consultafirmas)){
            while($extraerDatso=$bloques->obtener_fila($consultafirmas)){
            
            */
            $firmasasignadas=$mysqli->query("SELECT * FROM `ter_cruce_terceros` INNER JOIN ter_terceros ON ter_cruce_terceros.id_tercero_secundario = ter_terceros.identificacion WHERE ter_cruce_terceros.id_tercero_principal = '$idusuario' AND ter_cruce_terceros.estado=1 GROUP BY ter_cruce_terceros.id_tercero_secundario  ");  
            while($extraerDatso=$firmasasignadas->fetch_array()){
            ?>
            <div class="contenedor">
                <div class="campos_f"><?php echo $extraerDatso['numero_identificacion']; ?></div>
                <div class="campos_f"><?php echo $extraerDatso['nombres']; ?></div>
                <div class="campos_f"><?php echo $extraerDatso['telefono']; ?></div>
                <div class="campos_f"><?php echo $extraerDatso['correo_electronico']; ?></div>
                <div class=" campos_f">
                    <form action="controller/controllerFirmas.php" method="POST">
                        <input type="hidden" value="<?php echo $extraerDatso['id_tercero_secundario'];  ?>" name="tercero">
                        <input type="hidden" value="<?php echo $id = $_POST['id']; ?>" name="id">
                        <button class="btn_rojo" type="submit" name="desasignarfirma">Desasignar</button>
                    </form>
                </div>  
            </div>
            <?php
            }      
        ?>
        <div class="cont_fin"></div>
        </div>
<?php include 'footer.php'; ?>
<script>
    function vermenu(){
        document.getElementById('m_ad').classList.toggle('ver');
    }
</script>
</body>

</html>