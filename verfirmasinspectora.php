<!DOCTYPE html>
 <?php 
    include 'sec_login.php';
    include "conexion/Conexion2.php";
    include "conexion/conexion.php";
    include  "clases/bloques.class.php";
    
 ?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firmas Inspectoras</title>
    <link rel="stylesheet" href="../css/regiones.css">
    <link rel="stylesheet" href="../css/totproyectos.css">
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
      if(isset($_POST['ident'])){
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
          $tipdocB = $_POST['tipdocB'];
          $tipoCliente = $_POST['tipoCliente'];
          $tipodocumento = $_POST['tipodocumento'];

          
          $id = $_POST['id'];

      ?>
        <div class="contenedor">
          <div class="campos_f"><?php echo $nombrecompania; ?></div>
          <div class="campos_f"><?php echo $tipdocB.'-'.$numeroidentificacion; ?></div>
          <div class="campos_f"><?php echo $direccion; ?></div>
          <div class="campos_f"><?php echo $telefono; ?></div>
          <div class="campos_f"><?php echo $correo_electronico; ?></div>
          
             <div class="campos_f">
                  <form action="editarfirmas.php" method="POST">
                       <input  type="hidden" value="<?php echo $id;  ?>" name="idFirma">
                        <input  type="hidden" value="<?php echo $nombrecompania;  ?>" name="nombrefirma">
                        <input  type="hidden" value="<?php echo $tipdocletra;?>" name="tipdocletra"?>
                        <input  type="hidden" value="<?php echo $tipodocumento;  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $telefono;  ?>" name="telefono">
                        <input  type="hidden" value="<?php echo $correo_electronico;  ?>" name="correo_electronico">
                        <input  type="hidden" value="<?php echo $numeroidentificacion;  ?>" name="numeroidentificacion">
                        <input  type="hidden" value="<?php echo $pais;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $dep;  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $tipoCliente;  ?>" name="tipoCliente">
                      <input  type="hidden" value="<?php echo $id;  ?>" name="idFirma">
                      <button class="btn_azul" type="submit" name="editar">Editar</button>
                  </form>
                  <form action="controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatosFirmas['identificacion'];  ?>" name="id">
                      <button class="btn_rojo" type="submit" name="desactivarFirma">Desactivar</button>
                  </form>
               </div>
        </div>   
         <?php
      }else{
            $id = $_POST['id'];
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultacompanias = $bloques->consultabuscadorfirmas($id);
            $extraerDatos = $bloques->obtener_fila($consultacompanias);
            

            $nombres = $extraerDatos['nombres'];
            $identifiacion = $extraerDatos['numero_identificacion'];
            $direccion = $extraerDatos['direccion'];
            $telefono = $extraerDatos['telefono'];
            $correoelectronico = $extraerDatos['correo_electronico'];
            $tipoidentificacion = $extraerDatos['vdom_tipo_identificacion'];
            $pais = $extraerDatos['pais'];
            $departamento = $extraerDatos['departamento'];
            $ciudad = $extraerDatos['ciudad'];
            $tipdocB = $_POST['tipdocB'];
            $tipoCliente = $extraerDatos['tipoCliente'];
            
            $consultatipdoc = $bloques->consultatipodoc($tipoidentificacion);
            $extraerconsulta = $bloques->obtener_fila($consultatipdoc);
            
            $tipoDocumentoL = $extraerconsulta['id_alfanumerico'];
          

          ?>
            <div class="contenedor">
                <div class="campos_f"><?php echo $nombres; ?></div>
                <div class="campos_f"><?php echo $tipoDocumentoL.'-'.$identifiacion; ?></div>
                <div class="campos_f"><?php echo $direccion; ?></div>
                <div class="campos_f"><?php echo $telefono; ?></div>
                <div class="campos_f"><?php echo $correoelectronico; ?></div>
                <div class="campos_f">
                  <form action="editarfirmas.php" method="POST">
                       <input  type="hidden" value="<?php echo $id;  ?>" name="idFirma">
                        <input  type="hidden" value="<?php echo $nombres;  ?>" name="nombrefirma">
                        <input  type="hidden" value="<?php echo $tipoidentificacion;  ?>" name="tipodocumento">
                        <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                        <input  type="hidden" value="<?php echo $telefono;  ?>" name="telefono">
                        <input  type="hidden" value="<?php echo $correoelectronico;  ?>" name="correo_electronico">
                        <input  type="hidden" value="<?php echo $identifiacion;  ?>" name="numeroidentificacion">
                        <input  type="hidden" value="<?php echo $pais;  ?>" name="pais">
                        <input  type="hidden" value="<?php echo $departamento;  ?>" name="departamento">
                        <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                        <input  type="hidden" value="<?php echo $tipoCliente ?>" name="tipoCliente">
                      <button class="btn_azul" type="submit" name="editar">Editar</button>
                  </form>
                  <form action="controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $id;  ?>" name="id">
                      <button class="btn_rojo" type="submit" name="desactivarFirma">Desactivar</button>
                  </form>
               </div>
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