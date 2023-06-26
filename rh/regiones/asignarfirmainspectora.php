  <?php 
    include 'sec_login.php'; 
    include  "clases/bloques.class.php";
    ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Registro Compañia de Seguros</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> ASIGNACION DE FIRMAS INSPECTORAS</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listacompaniaseguros.php">+Listar Compañias de Seguros</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo"></div>
    </div>
  <div class="contenedor">
  <form class="registro" action="../regiones/controller/controllerasignarfirma.php" method="POST">
      <?php
      
      $id = $_POST['id'];
      $nombre = $_POST['nombrefirma'];
      $hoy = date("Y-m-d");  
      ?>
      <label>
          <center>
          <?php
            echo '<br>';
            echo '<b>COMPAÑIA DE SEGUROS <b>'.$nombre;
          ?>
          <input class="ver" name="companiaseguros" value="<?php echo $id?>">
          </center>
      </label>
      <br>
      <center>
          <table border='0'>
              <thead>
                  <th>IDENTIFICADOR</th>
                  <th>FIRMA INSPECTORA</th>
                  <th>FECHA INICIO</th>
                  <th>FECHA VIGENCIA</th>
                  <th>SELECCIONAR</th>
              </thead>
              <tbody>
                      <?php
                        $bloques    = new bloques;
                        $consulta = $bloques->iniciarVariables();
                        $consultacompanias = $bloques->consultafirmas($id);
             
                        while ($extraerDatocompañias = $bloques->obtener_fila($consultacompanias)){
                        ?>
                        <tr>
                            <td>
                                 <center>
                                     <?php echo $extraerDatocompañias['numero_identificacion']?>
                                 </center>
                                 <input class="ver" name="identificador[]" value="<?php echo $extraerDatocompañias['identificacion'] ?>">
                            </td>
                            <td>
                                <?php echo $extraerDatocompañias['nombres']?>
                            </td>
                            <td><input type="date" name="fechaInicial[]" ></td>
                            <td><input type='date' name="fechaFinal[]" min="<?php echo $hoy ?>"></td>
                            <td>
                                <center>
                                    <input type="checkbox" name="firmainspectora[]" value="<?php echo $extraerDatocompañias['identificacion'] ?>">
                                </center>
                            </td>
                        </tr>
                        <?php
                        }
                      ?>
              </tbody>
      </table>
      </center>
     
    <div class="inputs_r">
      <br>
      <input class="btn_azul" type="submit" name="asignarfirmasinspectoras" value="Asignar" >
    </div>
  </form>
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>