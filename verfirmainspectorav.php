<!DOCTYPE html>
 <?php 
    include 'sec_login.php';
    include "conexion/Conexion2.php";
    include "conexion/conexion.php";
 ?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firmas Inspectoras</title>
    <link rel="stylesheet" href="../css/regiones.css">
    <link rel="stylesheet" href="../css/totproyectos.css">
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

        include_once  "clases/Json.class.php";
        include 'header-rh.php';
        
    ?>
    <div class="titulo_p">
        <center><i class="fa-solid fa-user"></i> INFORMACION FIRMA INSPECTORA</center>
    </div>
    
    <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listafirmasinspectoras.php"> Regresar</a></div>
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
      
      $id = $_POST['id'];

      ?>
        <div class="contenedor">
          <div class="campos_f"><?php echo $nombrecompania; ?></div>
          <div class="campos_f"><?php echo $numeroidentificacion; ?></div>
          <div class="campos_f"><?php echo $direccion; ?></div>
          <div class="campos_f"><?php echo $telefono; ?></div>
          <div class="campos_f"><?php echo $correo_electronico; ?></div>
          
             <div class="campos_f">
                  <form action="editarfirmas.php" method="POST">
                       <input  type="hidden" value="<?php echo $id;  ?>" name="idFirma">
                        <input  type="hidden" value="<?php echo $nombrecompania;  ?>" name="nombrefirma">
                        <input  type="hidden" value="<?php echo $extraerDatos['id_alfanumerico'];?>" name="tipdocletra"?>
                        <input  type="hidden" value="<?php echo $extraerDatos['vdom_tipo_identificacion'];  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $telefono;  ?>" name="telefono">
                        <input  type="hidden" value="<?php echo $correo_electronico;  ?>" name="correo_electronico">
                        <input  type="hidden" value="<?php echo $numeroidentificacion;  ?>" name="numeroidentificacion">
                        <input  type="hidden" value="<?php echo $pais;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $dep;  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                      <input  type="hidden" value="<?php echo $id;  ?>" name="idFirma">
                      <button class="btn_azul" type="submit" name="editar">Editar</button>
                  </form>
                  <form action="controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatosFirmas['identificacion'];  ?>" name="id">
                      <button class="btn_rojo" type="submit" name="desactivarFirma">Desactivar</button>
                  </form>
               </div>
        </div>   
        
        <div class="titulo_p">
        <center><i class="fa-solid fa-user"></i> INSPECTORES ASIGNADOS</center>
        </div>
        
        </div>
        <div class="contenedor_titulos">
            <div class=" titulo"><b>Numero Identificación </b></div>
            <div class=" titulo"><b>Nombre Inspector</b></div>
            <div class=" titulo"><b>Número de Contacto</b></div>
            <div class=" titulo"><b>Correo Electronico</b></div>
           <!-- <div class=" titulo"><b>Acciónes</b></div>-->
        </div>
        <?php
            $consultainspectoresasignados = $mysqli->query("SELECT * FROM `sg_usuarios_x_cliente` JOIN sg_usuarios ON sg_usuarios_x_cliente.id_usuario = sg_usuarios.identificador AND sg_usuarios_x_cliente.id_cliente=$id");
            while($extraerDatso=$consultainspectoresasignados->fetch_array()){
        ?>
         <div class="contenedor">
            <div class="campos_f"><?php echo $extraerDatso['numidentificacion']; ?></div>
            <div class="campos_f"><?php echo $extraerDatso['nombre'].' '.$extraerDatso['apellidos']; ?></div>
            <div class="campos_f"><?php echo $extraerDatso['numero_telefono']; ?></div>
            <div class="campos_f"><?php echo $extraerDatso['email']; ?></div>
            <?php
            /*
            <div class="campos_f">
                <form action="controller/controllerFirmas.php" method="POST">
                    <input type="hidden" value="<?php echo $extraerDatso['id_usuario'];  ?>" name="id">
                    <input  type="hidden" value="<?php echo $id;  ?>" name="idFirma">
                    <button class="btn_rojo" type="submit" name="desasignarinspector">Desasignar</button>
                </form>
            </div>
            */
            ?>
         </div>
        <?php
         }
        ?>
        <div class="cont_fin"></div>
<?php include 'footer.php'; ?>
<script>
    function vermenu(){
        document.getElementById('m_ad').classList.toggle('ver');
    }
</script>
</body>

</html>