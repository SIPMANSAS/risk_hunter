<?php include 'sec_login.php';
      include 'clases/gabriel.class.php';
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caracteristicas Desactivadas</title>
  <link rel="stylesheet" href="../css/regiones.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
  <?php include 'header-rh.php'; ?>
    <div class="titulo_p"><i class="fa-solid fa-xmark"></i>&nbsp; Caracteristicas desactivadas </div>
    <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listacaracteristicas.php"> Listar Caracteristicas Activas</a></div>
    <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="creacaracteristica.php"> Agregar  Caracteristica</a></div></div>    
    <div class="contenedor_titulos" id="contenidos">
      <div class="titulo">Nombre</div>
      <div class="titulo"></div>
    </div>
    <?php
      
      $Jsoncaracterin     = new gabriel;
      $consulta = $Jsoncaracterin->iniciarVariables();
      $xcompproyectos = $Jsoncaracterin->listacaracteristicainactiva();
     
     while ($caracteristicas = $Jsoncaracterin->obtener_fila($xcompproyectos)) {
      ?>
        <div class="contenedor" id="contenidos">
          <div class="campos_f"><?php echo $caracteristicas['nombre']; ?></div>
          <div class="campos_f">
            <form action="controller/controllercaracteristica.php" method="POST">
              <input class="campos" type="hidden" value="<?php echo $caracteristicas['identificador'];  ?>" name="idcaracteristica">
              <button class="btn_azul" type="submit" name="activarcaracteristica">Activar</button>
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