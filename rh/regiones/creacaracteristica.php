<?php 
include 'sec_login.php'; 
include 'clases/gabriel.class.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro Caracteristica</title>
  <link rel='stylesheet' href='../pages/css/estilosSebastian.css'>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
</head>
<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-chart-simple"></i></i>&nbsp; REGISTRAR CARACTERISTICAS</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listacaracteristicas.php">+Listar Caracteristicas</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Caracteristica</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllercaracteristica.php" method="POST">
      <div class="inputs_r">
      <label>Nombre:</label>
      <input class="inp_med" type='text' name='nombreCaracteristica' placeholder="Ingrese nombre"  required>
    </div>
    <div class="inputs_r">
    <label>Tipo de Bien:</label>      
         <?php
         $filtro="1";
                $Jsoncaracter     = new gabriel;
                $consulta = $Jsoncaracter->iniciarVariables();
                $xcompproyectos = $Jsoncaracter->listavalorcaracteristica($filtro);             
             ?>        
        <select type="text"  name="bienes">
          <option value="">Seleccionar....</option>
            <?php while($columna=$Jsoncaracter->obtener_fila($xcompproyectos)) { ?>
              <option value="<?php echo $columna['identificador']; ?>"><?php echo $columna['nombre']; ?> </option>

        <?php } ?>

      </select>
    </div>

    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registrarCaracteristica" value="Guardar">
    </div>
  </form>
 
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>