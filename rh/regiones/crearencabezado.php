<!DOCTYPE html>
<html lang="es">
<?php
include 'sec_login.php';
require_once 'conexion/conexion.php';
include  "clases/bloques.class.php";
include 'header-rh.php';
?>
<head>
  <title>Registro Encabezados</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
</head>

<body>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO ENCABEZADOS</div>
  <div class="link_int">
      <div class="titulo2">  <a href="">+Listar Encabezados</a></div>
    </div>
     <div class="contenedor_titulos">
      <div class="titulo">Encabezado</div>
    </div>
    <div class="contenedor">
        <form class="registro" action="controller/controllerencabezado.php" method="POST">
            <div class="inputs_r">
                <?php
                $bloques    = new bloques;
                $consultabloques = $bloques->iniciarVariables();
                $consulta = $bloques->pintaformulario();
                $contador = 0;
                $j = 4;
                while ($extraerData =  $bloques->obtener_fila($consulta)){
                    $j++;
                    echo UTF8_encode($extraerData['Label'].':');
                    $idpregunta     = $extraerData['id_pregunta'];
                    $consultaDato   = utf8_encode($extraerData['lista_valores']); 
                    $tipoDato       = utf8_encode($extraerData['TipoDato']);
                    /* Se debe revisar el tipo de dato y valida fuera del if */
                    $j;
                    ?>
                    <input name="campoTexto<?php echo $j ?>" type="<?php echo $extraerData['TipoDato']?>" value="<?php  $value ?>"></i></input>
                    <?php
                    if($consultaDato == NULL){
                        $dato = '';
                        ?>
                        <input type="hidden" name="idpregunta" value="<?php echo $idpregunta ?>">
                        <?php
                    }else{
                        ////CONSULTA DATO
                        $ejecutaconsulta = $mysqli->query("$consultaDato");
                        $extraerDataB    = $ejecutaconsulta->fetch_array(MYSQLI_ASSOC);
                        $dato            = $extraerDataB['codigo'];
                        $tipoDato;
                        $extraerDataB['lista_valores'];
                        if($tipoDato == 'text'){
                            $dato = utf8_encode($extraerDataB['codigo']);
                        }elseif($tipoDato == 'date'){ 
                        ?>
                        <input type="date" name="tipofecha<?php echo $j ?>" value="<?php echo $dato ?>">
                        <?php
                        }elseif($tipoDato == 'select'){
                            $consultaselect=$extraerData['lista_valores'];
                            $ejecutaconsultaselect = $mysqli->query($consultaselect);
                            ?>
                            <select name="select">
                                <?php
                                while($extraerconsultaselect=$ejecutaconsultaselect->fetch_array()){
                                ?>
                                    <option value="<?php echo $select = $extraerconsultaselect['codigo'] ?>">
                                        <?php echo utf8_encode($extraerconsultaselect['descripcion'] )?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                        }elseif($tipoDato == 'check'){
                            $consultaselect=$extraerData['lista_valores'];
                            $ejecutaconsultaselect = $mysqli->query($consultaselect);
                            while($extraerDatos = $ejecutaconsultaselect->fetch_array()){
                        ?>
                            <label><?php echo utf8_encode($extraerDatos['descripcion'])?></label>
                            <input type="checkbox" name="tipocheck" value="">
                        <br>
                        <?php
                            }
                        }
                    }
                ?>
            </div>
            <div class="inputs_r">
                <?php
                    }
                    echo $j;
                ?>
                <input class="btn_azul" type='submit' name="registraencabezado" value="Guardar">
            </div>
        </form>
    </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>