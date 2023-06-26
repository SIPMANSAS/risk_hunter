<?php 
include 'sec_login.php'; 
include 'clases/gabriel.class.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Carga Por Columnas</title>
        <link rel='stylesheet' href='../pages/css/estilosSebastian.css'>
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/regiones.css">
          <link rel="shortcut icon" href="favicon.ico">
    </head>
    <body>
        <?php include 'header-rh.php';?>
        <div class="titulo_p"><i class="fa-solid fa-chart-simple"></i></i>&nbsp;CARGA POR COLUMNAS</div>
        <div class="link_int">
        <div class="titulo2">  <a href="listarcargasB.php">+Listar Cargas</a></div>
        </div>
        <div class="contenedor_titulos">
            <div class="titulo">Carga</div>
        </div>
        <div class="contenedor">
            <div class="inputs_r">
                <form class="registro" action="importacion/importar-cargueB/index.php" method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <label>Cargar Archivo: </label>
                    <input class="inputs_r" id="file-input" type="file" name="file"  required>
                    <button type="submit"  name="import" class="btn_azul"><a class="" href="#"><font color="white">Importar</font></a></button>
                </form>  
            </div>
        </div>
        <div class="cont_fin"></div>
      <?php include 'footer.php';?>
    </body>
</html>