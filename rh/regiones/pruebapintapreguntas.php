  <?php 
    include 'sec_login.php'; 
    include  "clases/bloques.class.php";
    include "conexion/conexion.php";
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
      <div class="titulo2">  <a href="listacompaniaseguros.php"></a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">PREGUNTAS</div>
    </div>
    <div class="contenedor">
        <form class="registro" method="POST" action="pruebapintapreguntas.php">
            <br>
            <?php
            ////Inicio con funciones
            $funcionpregunta = $mysqli->query("SELECT f_pintar_primera_pregunta(2)");
            $extraerDatos = $funcionpregunta->fetch_array(MYSQLI_ASSOC);
            $muestra = $extraerDatos['f_pintar_primera_pregunta(2)'];
            
           ?>    
                <div class="inputs_r">
                    <?php
                    $consulta = $mysqli->query("SELECT * FROM v_pinta_formulario WHERE id_pregunta = f_pintar_primera_pregunta(2)");
                    $extraerData=$consulta->fetch_array(MYSQLI_ASSOC);
                    ?>
                </div>
                <div class="inputs_r">
                    <label>
                        <?php
                            echo utf8_encode($extraerData['Label'].':');
                            echo '<br>';
                    ?>
                    </label>
                    <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta" value=""></i></input>
                </div>
                <div class="inputs_r">
                    <input class="ver" class="btn_azul" type='submit' name="registraencabezado" value="Guardar">
                </div>
        <?php
        
        if(isset($_POST['registraencabezado'])){
            $respuesta = $_POST['respuesta'];
            while('1'=='1'){
                'en el while';
                $consulta2 = $mysqli->query("SELECT * FROM v_pinta_formulario WHERE id_pregunta = f_pintar_siguiente_pregunta(2,$respuesta)");
                $extraerDato =$consulta2->fetch_array(MYSQLI_ASSOC);
                ?>
                <div class="inputs_r">
                    <label>
                        <?php echo $muestra = utf8_encode($extraerDato['Label']); ?>
                    </label>
                    <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta"></i></input>
                </div>    
                <?php
                $respuesta;
                if($respuesta = -1){
                    exit;
                }else{
                ?>
                    <div class="inputs_r">
                         <label>
                            <?php
                                echo $muestra;
                            ?>
                         </label>
                          <input type="<?php echo $extraerData['TipoDato']?>" name="respuesta"></i></input>
                    </div>
                     <div class="inputs_r">
                         <input class="ver" class="btn_azul" type='submit' name="registraencabezado" value="Guardar">
                    </div>
                    <br>
                <?php
                }
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