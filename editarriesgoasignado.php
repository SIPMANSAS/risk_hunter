<?php

include  "clases/bloques.class.php";

'NR'.$nombre_riesgo = $_POST['nombre_riesgo'];
'ID'.$id_riesgo = $_POST['id_riesgo'];
'ES'.$estado_riesgo = $_POST['estado_riesgo'];
'TXT'.$texto_riesgo = $_POST['texto_riesgo'];
'PREG_ID'.$id_pregunta = $_POST['id_pregunta'];

$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaestado = $bloques->consultaestadoriesgos();
?>
<head>
  <title>Editar Riesgos de Riesgos</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<div class="titulo_p"><i class="fa-solid fa-file-pen"></i> EDITAR RIESGO </div>
<div class="contenedor_titulos">
            <div class=" titulo">Riesgo</div>
            <div class=" titulo">Estado</div>
            <div class=" titulo">Texto</div>
            <div class=" titulo">Acciones</div>
        </div>
        
        <div>
            <form class="contenedor" action="controller/controllerpreguntas.php" method="POST">
                <div class="campos_f">
                    <input type="hidden" name="id_pregunta" value="<?php echo $id_pregunta; ?>">
                    <input type="hidden" name="id_riesgo" value="<?php echo $id_riesgo;?>">
                    <?php echo $nombre_riesgo; ?>
                </div>
                <?php
                
                $fitlroestado = $estado_riesgo;
                $dataestado = $bloques->buscaestado($fitlroestado);
                $traeestado =  $bloques->obtener_fila($dataestado);
                
                $estadoT = $traeestado['nombre'];
                $idestado = $traeestado['identificador'];
                
                $selectestado = $bloques->tipoestadoselect($fitlroestado);
         
                ?>
                
                <div class="campos_f">
                    <select type="text" class="inp_med"  style="width:300px;" name="estado"  autocomplete="off" required>
                        <option value="">Seleccionar Estado</option>
                        <?php 
                            while ($columnaC = $bloques->obtener_fila($selectestado)){
                        ?>
                                <option value="<?php echo $columnaC['identificador']; ?>"><?php echo ($columnaC['nombre']); ?> </option>
                        <?php 
                            }
                            $selectEstado = "selected"
                        ?>
                        <option value="<?php echo $idestado; ?> " <?php echo $selectEstado ?>><?php echo utf8_encode($estadoT);?></option>
                    </select>
                </div>
                <div class="campos_f"><textarea rows="3" cols="40" name="texo_riesgo"><?php echo $texto_riesgo;?></textarea></div>

                <div class="campos_f" ><button type="submit" class="btn_azul" name="actualizarriesgo">Actualizar</button></div>
            </form>
        </div>
</div>