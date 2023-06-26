<!DOCTYPE html>
 <?php 
    include 'sec_login.php'; 
    include  "clases/bloques.class.php";
    include "conexion/conexion.php";
    ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ajaxx</title>
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/totproyectos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <script>
    a = 0;
    function addInput(){
        <?php
            $i = 1;
            $consulta = $mysqli->query("SELECT * FROM v_pinta_formulario WHERE id_pregunta=3");
            while($extraerData = $consulta->fetch_array()){
                $label=$extraerData['Label'];
                $cont = 1;
        ?>
                a++;
                var div = document.createElement('div');
                div.setAttribute('class', 'inputs_r');
                div.innerHTML = '<div class="'+a+'"><label><?php echo '<br>'.$label++.'.'.' Siguiente Pregunta'?></label><input class="inp_med" name="valor_'+a+'" id="imp" type="text"/></div>';
                document.getElementById('inputs').appendChild(div);document.getElementById('inputs').appendChild(div);
                texto = document.getElementsByName('valor_');
        <?php
       
            }
                ?>
    }
    </script>
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
        <form class="registro" method="POST">
            <div class="inputs_r">
                <label>
                    <?php
                    echo $extraerDataMas = $extraerData['Label'];
                    ?>
                </label>
                <input class="inp_med" type="text" name="numeroIdentificacion" placeholder="Ingrese Numero Identificacion" required>
                <input type="button" name="add" id="add_inputs()" onClick="addInput()" value="+" />
                <?php
                if(isset($_POST['add'])){
                echo $numeroIdentificacion = $_POST['numeroIdentificacion'];
                }
                ?>
            </div>
            <div id="inputs">
            </div>
        </form>
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>