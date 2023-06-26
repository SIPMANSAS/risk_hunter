<!DOCTYPE html>
<?php include '../sec_login.php'; ?>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compañias de Seguros</title>
  <link rel="stylesheet" href="../css/regiones.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
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
            url: "../funciones/obtienesearfirmas.php",
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
                        $('#identifu').val("d");
                        
			document.getElementById('form').submit();
	                  return false;
                });
            }
        });
    });
}); 
</script>
  
</head>


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


<body>
 <?php include 'header-rh.php'; ?>
    <div class="titulo_p">
        <center>COMPAÑIAS DE SEGUROS DESACTIVADAS</center>
    </div>
    <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listacompaniaseguros.php"> Listar Compañias de Seguros Activas</a></div>
    <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="crearcompaniaseguros.php"> Crear Compañia de Seguros</a></div></div>
    <?php
    /*
    echo '<div class="buscar">';
    echo '<div class="contenedor-1">
        <span class="icon"><i class="fa fa-search"></i></span>
        <input type="search" id="search" placeholder="Buscar Usuario..." autocomplete="off" />
    </div>
    
    <div id="sugerencia"></div>
    </div>';
    
    */
    
    ?>
      <div class="contenedor_titulos" id="contenidos">
        <div class=" titulo_list_u"><b>Nombre Compañia Seguros</b></div>
        <div class=" titulo_list_u"><b>NIT/CC</b></div>
        <div class=" titulo_list_u"><b>Dirección</b></div>
        <div class=" titulo_list_u"><b>Numero de Contacto</b></div>
        <div class=" titulo_list_u"><b>E-mail</b></div>
        <div class=" titulo_list_u"><b>Ubicación Principal</b></div>
        <div class=" titulo_list_u"><b>Acciones</b></div>
      </div>

      <?php

      $mysqli = new mysqli('localhost','risk_hunter','Kaliman01*','sipman_risk_hunter');

      $ConsultaDatos = $mysqli->query("SELECT * FROM ter_terceros F JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo WHERE F.estado=0 AND F.tipoCliente=0 AND vdom_tipo_tercero='772' GROUP BY identificacion ASC");

      while ($extraerDatosFirmas = $ConsultaDatos->fetch_array()) {

      ?>
        <div class="contenedor" id="contenidos">
          <div class="campos_f"><?php echo $extraerDatosFirmas['nombres']; ?></div>
          <div class="campos_f"><?php echo $extraerDatosFirmas['numero_identificacion']; ?></div>
          <div class="campos_f"><?php echo $extraerDatosFirmas['direccion']; ?></div>
          <div class="campos_f"><?php echo $extraerDatosFirmas['telefono']; ?></div>
          <div class="campos_f"><?php echo $extraerDatosFirmas['correo_electronico']; ?></div>
          
          
          <?php
          $ciudad = $extraerDatosFirmas['ciudad'];
          $dep=$extraerDatosFirmas['departamento'];
          $pais=$extraerDatosFirmas['codigo_pais'];
          $consultaPais = $mysqli->query("SELECT * FROM rg_paises WHERE codigo = '$pais'");
          $paisEx = $consultaPais->fetch_array(MYSQLI_ASSOC);
          $pais = $paisEx['nombre'];
          
          
          $consultaDep = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$dep'");
          $depEx = $consultaDep->fetch_array(MYSQLI_ASSOC);
          
          $consultaCiu = $mysqli->query("SELECT * FROM rg_ciudades WHERE codigo='$ciudad'");
          $ciuEx = $consultaCiu->fetch_array(MYSQLI_ASSOC);
    
          
          
          ?>
            <div class="campos_f">
              <?php echo utf8_encode($pais = $paisEx['nombre'].'-'.$depEx['nombre'].'-'.$ciuEx['nombre']); ?>
            </div>
            <div class="campos_f">
              <form action="../firmas/controller/controllerFirmas.php" method="POST">
                  <input type="hidden" value="<?php echo $extraerDatosFirmas['identificacion'];  ?>" name="id">
                  <button class="btn_azul" type="submit" name="activarCompaniaSeguros">Activar</button>
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