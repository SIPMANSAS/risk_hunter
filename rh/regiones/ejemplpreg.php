  <?php 
    include 'sec_login.php'; 
    include  "clases/bloques.class.php";
    include "conexion/conexion.php";
    ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Preguntas</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> PREGUNTAS</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listacompaniaseguros.php"></a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">PREGUNTAS</div>
    </div>
    <div class="contenedor">
        <form class="registro" method="POST" action="pruebapintapreguntas.php">
        <?php
        ///////////////////////////////// FUNCIONES /////////////////////////////////////////////////////////////////////////////////////////////
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $preguntas = $bloques->consultapreguntas();
            while ($extraerData =  $bloques->obtener_fila($preguntas)){
                echo 'FUNCION';
                echo $data=$extraerData['id_pregunta_padre'];
                if($data==0){
                ?>
                    <div class="inputs_r">
                        <label>
                            <?php echo utf8_encode($extraerData['nombre']); ?>
                        </label>
                        <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta" value="" id="C1"></i></input>
                    </div>
                <?php    
                }else{
                ?>
                <div class="inputs_r">
                        <label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo utf8_encode($extraerData['nombre']); ?>
                        </label>
                        <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta" value="" id="C1"></i></input>
                    </div>
                <?php    
                }
            }
            ////////////////////////////////////////////////////SIN FUNCIONES ////////////////////////////////////////////////////////////////////
            $consulta = $mysqli->query("SELECT * FROM enc_preguntas WHERE identificador > 0");
            while($extraerData = $consulta->fetch_array()){
                if($extraerData['id_pregunta_padre']==0){
                    ?>
                    <div class="inputs_r">
                        <label>
                            <?php echo utf8_encode($extraerData['nombre']); ?>
                        </label>
                        <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta" value="" id="C1"></i></input>
                    </div>
                    <?php
                }else{
                ?>
                <div class="inputs_r">
                        <label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo utf8_encode($extraerData['nombre']); ?>
                        </label>
                        <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta" value="" id="C1"></i></input>
                    </div>
                <?php
                }
            }
            ?>
        </form>
    </div>
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>