<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include  "clases/bloques.class.php";

$identificador = $_POST['id_parametrizacion'];
$asunto = $_POST['asunto'];
$texto = $_POST['texto'];
$texto_of = $_POST['texto_of'];
$remitente = $_POST['remitente'];
$cc = $_POST['cc'];

?>
<head>
  <title>Registro Parametrización</title>
 <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
    <?php include 'header-rh.php';?>
    <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO PARAMETRIZACIÓN</div>
    <div class="link_int">
      <div class="titulo2">  <a href="parametrizacion.php">+Listar Parametrizaciones</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Parametrización</div>
    </div>
    <div class="contenedor">
        <form class="registro" action="controller/controllerparametrizacion.php" method="POST">
            <input  type='' name='identificador' value="<?php echo $identificador?>">
            <div class="inputs_r">
                <label>Asunto:</label>
                <input class="inp_med" type='text' name='asunto' placeholder="Ingrese asunto"  value="<?php echo $asunto?>" required>
            </div>
            <div class="inputs_r">
                <label>Texto:</label>
                <input class="inp_med" type='text' name='texto' placeholder="Ingrese texto" value="<?php echo $texto?>"  required>
            </div>
            
             <div class="inputs_r">
                <label>Texto of:</label>
                <input class="inp_med" type='text' name='textoof' placeholder="Ingrese texto" value="<?php echo $texto_of?>" required>
            </div>
            
            <div class="inputs_r">
                <label>Remitente</label>
                <input class="inp_med" type="text" name="remitente" placeholder="Ingrese Remitente"  value="<?php echo $remitente?>"required>
            </div>
            <div class="inputs_r">
                <label>CC</label>
                <input class="inp_med" type="text" name="cc" placeholder="Ingrese cc" value="<?php echo $cc?>" required>
            </div>
         
            <div class="inputs_r">
              <input class="btn_azul" type='submit' name="actualizarparametrizacion" value="Actualizar">
            </div>
        </form>
    </div>
    <div class="cont_fin"></div>
    <?php include 'footer.php';?>
</body>
</html>