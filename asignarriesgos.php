<!DOCTYPE html>
<html lang="es">
<?php
include 'sec_login.php'; 
include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();

$id_pregunta = $_GET['id_pregunta'];
$fecha = date("Y-m-d");
$consultanivelP = $bloques->consultalistariesgos();
$consultaestado = $bloques->consultaestadoriesgos();

$consultapregunata = $bloques->consultapregunta($id_pregunta);
$extraeNpregunta = $bloques->obtener_fila($consultapregunata);
$preguntaNombre = $extraeNpregunta['nombre'];

?>
<head>
  <title>Asignación de Riesgos</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
    <?php include 'header-rh.php';?>
    <div class="titulo_p"><i class="fa-solid fa-question"></i>&nbsp; <?php echo $preguntaNombre ?> </div>
        <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> RIESGOS ASIGNADOS </div>
        <div class="contenedor_titulos">
            <div class=" titulo">Riesgo</div>
            <div class=" titulo">Estado</div>
            <div class=" titulo">Texto</div>
            <div class=" titulo">Acciones</div>
        </div>
        <?php 
            $consultariesgosasignados = $bloques->consultariesgoasignado($id_pregunta);
    
            while ($extraerDatos =  $bloques->obtener_fila($consultariesgosasignados)){
        ?>
        <div class="contenedor">
            <div class="campos_f"><?php echo $extraerDatos['Riesgo']; ?></div>
            <div class="campos_f"><?php echo $extraerDatos['nombre']; ?></div>
            <div class="campos_f"><?php echo $extraerDatos['texto_informe']; ?></div>
            <div class="campos_f">
                <form method="POST" action="editarriesgoasignado.php" onsubmit="target_popup(this)">
                    <input type="hidden" name="nombre_riesgo" value="<?php echo $extraerDatos['Riesgo'];?>">
                    <input type="hidden" name="id_riesgo" value="<?php echo $extraerDatos['identificador'];?>">
                    <input type="hidden" name="estado_riesgo" value="<?php echo $extraerDatos['estado'];?>">
                    <input type="hidden" name="texto_riesgo" value="<?php echo $extraerDatos['texto_informe'];?>">
                    <input type="hidden" name="id_pregunta" value="<?php echo $id_pregunta ?>">
                    <button type="submit" class="btn_azul" name="editar">Editar</button>
                </form>
            </div>
        </div>
        <?php
            }
        ?>
         
    <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> ASIGNACIÓN DE RIESGOS </div>
    <div class="link_int">
    </div>
    <br>
    <button id="addRow" type="button" class="btn_azul">+ Agregar Campos</button>
    
    
     <div class="contenedor_titulos">
            <div class=" titulo">Riesgo</div>
            <div class=" titulo">Estado</div>
            <div class=" titulo">Texto</div>
            <div class=" titulo">Acciones</div>
            </div>
            
            <form action="controller/controllerpreguntas.php" method="POST">
                <div class="contenedor">
                    <div>
                       
                        <div id="inputFormRow">
                            <br>
                            <div>
                                <?php
                                for($i=1;$i<=$cantidad;$i++){
                                 $input = "?><input type='text' name='fabricante[]' class='form-control m-input' placeholder='Ingrese <?php echo $nombre?>' autocomplete='off' required><?php " ?>
                                <?php
                                }
                                ?>
                                <div id="newRow"></div>
                            </div>
                        </div>
                        <br>
                        <center>
                            <button type="submit" class="btn_verde" name="guardarriesgos">Guardar</button>
                        </center>
                    </div>
                </div>
                
            </form>
    <div class="cont_fin">
        
    </div>
    <a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
        <script>
            function target_popup(form) {
                window.open('', 'formpopup', 'width=1200,height=600,resizeable,scrollbars');
                form.target = 'formpopup';
            }
        </script>
        <script>
            function close_tab(){
                window.close();
            }
        </script>
    <script type="text/javascript">
        // agregar registro
        $("#addRow").click(function () {
        var html = '';
        html += '<div class="" id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += ' <input type="hidden" value="<?php echo $fecha?>" name="fecha[]">';
        html += ' <input type="hidden" value="<?php echo $id_pregunta?>" name="id_pregunta[]">';
        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select type="text"  style="width:300px;" name="riesgo[]" class="form-control m-input"  autocomplete="off" required><option value="">Seleccionar Riesgo</option><?php while ($columnaB = $bloques->obtener_fila($consultanivelP)) {?>
           <option value="<?php echo $columnaB['identificador']; ?>"><?php echo ($columnaB['nombre']); ?> </option><?php }?></select>';
        
        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select type="text"  style="width:300px;" name="estado[]" class="form-control m-input"  autocomplete="off" required><option value="">Seleccionar Estado</option><?php while ($columnaC = $bloques->obtener_fila($consultaestado)) {?>
           <option value="<?php echo $columnaC['identificador']; ?>"><?php echo ($columnaC['nombre']); ?> </option><?php }?></select>';
        
        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea rows="4" cols="45" type="text" name="texto[]" class="form-control m-input"   autocomplete="off" required></textarea>';
        
        html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="removeRow" type="button" class="btn_rojo">Borrar</button>';
        html += '<div class="campos_f">';

        html += '</div>';
       
        html += '</div>';
        
        $('#newRow').append(html);
        });
        
        // borrar registro
        $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
        });
    </script>
  <?php include 'footer.php';?>
</body>
</html>