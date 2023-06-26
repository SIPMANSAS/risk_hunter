<?php 
	include '../sec_login.php'; 
	include 'clases/gabriel.class.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Editar Caracteristica</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/regiones.css">
  <?php 
  $id=$_POST['idcaracteristica'];
  ?>
</head>
<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-chart-simple"></i></i>&nbsp; Editar Caracteristica</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listacaracteristicas.php">+Listar Caracteristicas</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Caracteristica</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllercaracteristica.php" method="POST">
  <?php 
  $id = $_POST['idcaracteristica'];
  $nomb = $_POST['nombre'];
  $cod_dom = $_POST['cod'];   
  ?>  
  <div class="inputs_r">
    <label>Nombre:</label>
    <input class="inp_med" type='text' name='nombre' placeholder="<?php echo $nomb ; ?>" value="<?php echo $nomb ; ?>" require >
    <input class="inp_med" type='hidden' name='idcar' value="<?php echo $id; ?>"   >
  </div>
  <div class="inputs_r">
  <label>Tipo de bien asignado:</label>
    <?php
	$filtrob=$cod_dom;
	$Jsoncaracter     = new gabriel;
	$consulta = $Jsoncaracter->iniciarVariables();
	$xcompproyectos = $Jsoncaracter->listabienes($filtrob);
	$trae = $Jsoncaracter->obtener_fila($xcompproyectos);
    ?>      
    <input class="inp_med" type='text' placeholder="<?php echo $trae['nombre']; ?>"   disabled>
  </div>
  <div class="inputs_r">
    <label>Modificar tipo de bien:</label>    
    <select type="text"  name="bienes" require>
      <option disabled selected >Seleccione...</option>
        <?php 
        $filtro="1";
        $Jsoncaracter     = new gabriel;
        $consulta = $Jsoncaracter->iniciarVariables();
        $xcompproyectos = $Jsoncaracter->listavalorcaracteristica($filtro);
        while($columna=$Jsoncaracter->obtener_fila($xcompproyectos)) { ?>
          <option value="<?php echo $columna['identificador']; ?>"><?php echo $columna['nombre']; ?> </option>
        <?php } ?>
    </select>
  </div>

  <div class="inputs_r">
  <input class="btn_azul" type='submit' name="editarcaracteristica" value="Guardar">
  </div>
  </form>
 
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>