<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php

include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaPaises = $bloques->buscapaises();
$consultatiporespuesta = $bloques->tiporespuesta();
$consultatiporespuestatexto = $bloques->textorespuesta();

$countries = array();

$fecha= date("Y-m-d");

$nombrepadre = utf8_decode($_POST['nombrepadre']);
$tipo_informe = $_POST['tipo_informe'];
$texto_informe = $_POST['texto_informe'];
$filtro = $id_respu = $_POST['id_respu'];
$val_cierre = $_POST['val_cierre'];
echo $id_resp_riesgo = $_POST['id_resp_riesgo'];
$texto_ayuda = $_POST['ayuda'];
?>
<head>
  <title>Editar Preguntas</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> EDITAR PREGUNTAS </div>

    <div class="contenedor_titulos">
      <div class="titulo">Pregunta</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerpreguntas.php" method="POST">
        <input class="inp_med" type='hidden' name='id_pregunta_padre' value="<?php echo $_POST['id']?>"  required>
        <br>
        <input class="inp_med" type='hidden' name='id_bloque' value="<?php echo $_POST['idbloque']?>"  required>
        <br>
         <input class="inp_med" type='hidden' name='codigo' value="<?php echo $_POST['codigo']?>"  required>
         <br>
         <input class="inp_med" type='hidden' name='fecha_efectiva' value="<?php echo $fecha ?>"  required>
     <div class="inputs_r">
      <label>Nombre:</label>
      <input class="inp_med" type='text' name='nombrebloque' placeholder="Ingrese nombres"  value="<?php echo $nombrepadre ?>">
    </div>
    <div class="inputs_r">
            <label for="name1">Tipo de Respuesta</label>
            <?php 
                $datatipores = $bloques->buscatiporesB();

                echo '<select id="paises_id" class="" name="tipo_res" >';
       
                while ($c = $bloques->obtener_fila($datatipores)) {
    
                    if($tiporesid == $c['identificador'])
                    {
                        echo " <option value=\"". $c['identificador'] ." \" selected>". utf8_encode($c['descripcion']) ."</option>";    
                    }
                    else 
                    {
                        echo "<option value=\"". $c['identificador']."\" > ".$c['descripcion'] ."</option>";
                    }
                }
            ?>
        </select>
        </div>

        <div class="inputs_r">
            <label for="name1">Respuesta de Cierre</label>
            <?php
                
                $datacieere = $bloques->seldepB($val_cierre);
                
                echo ' <select id="departamento_id" name="resp_cierre" > ';
                
                while($d = $bloques->obtener_fila($datacieere)){
                    
                    if($respcierre == $d['identificador'])
                    {
                        echo " <option value=\"".$d['identificador']. "\" selected> ". utf8_decode($d['valor_alfa_numerico']) ."</option>";    
                    }
                    else 
                    {
                        echo "<option value=\"". $d['identificador'] . "\" > ". ($d['valor_alfa_numerico']) . "</option>";
                    }
                }
            ?>
            </select>
        </div>
        <div class="inputs_r">
            <label for="name1">Respuesta Activa Riesgo</label>
            <?php
                
                $dataactries = $bloques->seldepB($val_cierre);
                
                echo ' <select id="ciudad_id" name="resp_act_riesgo" > ';
                
                while($d = $bloques->obtener_fila($dataactries)){
                    
                    if($respcierre == $d['identificador'])
                    {
                        echo " <option value=\"".$d['identificador']. "\" selected> ". utf8_decode($d['valor_alfa_numerico']) ."</option>";    
                    }
                    else 
                    {
                        echo "<option value=\"". $d['identificador'] . "\" > ". ($d['valor_alfa_numerico']) . "</option>";
                    }
                }
            ?>
            </select>
        </div>
       
         <div class="inputs_r">
            <label>Tipo Texto Respuesta</label>
            <select class="form-control" name="tipo_respuesta" >
                <option value="">--SELECCIONAR TIPO TEXTO RESPUESTA--</option>
                <?php
                while ($t = $bloques->obtener_fila($consultatiporespuestatexto)){
                    $codigor = $t['identificador'];
                    $nombrer = $t['nombre'];
                ?>
                <option value="<?php echo $codigor;?>"><?php echo $nombrer; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        
        <div class="inputs_r">
            <label>Texto Respuesta</label>
            <textarea class="form_control" rows="8" cols="102" name="textoresp"><?php echo $texto_informe?></textarea>
        </div>
        
        <div class="inputs_r"><label>Estado:</label>
           <select type="text"  id="contact" name="estadopregunta" required>
               <option value="">Seleccionar...</option>
               <option value="1">ACTIVO</option>
               <option value="0">INACTIVO</option>
           </select>
       </div>
       <div class="inputs_r">
            <label>Texto Ayuda</label>
            <textarea class="form_control" rows="8" cols="102" name="textoayuda"><?php echo $texto_ayuda ?></textarea>
        </div>
        
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="editarpregunta" value="Actualizar">
    </div>
  </form>
  
  
  <script type="text/javascript">
    $(document).ready(function(){
            $("#paises_id").on('change', function () {
                $("#paises_id option:selected").each(function () {
                    elegido=$(this).val();
                    $.post("ajaxlistdep2.php", { elegido: elegido }, function(data){
                    $("#departamento_id").html(data);
                    $("#ciudad_id").html(data);
                });			
            });
        });
        $("#departamento_idb").on('change', function () {
            $("#departamento_idb option:selected").each(function () {
                var eldep=$(this).val();
                var elpais = $("#paises_id").val();
                var parametros = { 
                    "eldep": eldep,
                    "elpais": elpais
               };
                $.post("ajaxlistdep2.php", { elegido: elegido }, function(data){
                    $("#departamento_id").html(data);
                        });			
                });
            }); 
        });  
</script>

<script>
    document.getElementById('contact').onchange = function() {
      /* Referencia al option seleccionado */
      var mOption = this.options[this.selectedIndex];
      /* Referencia a los atributos data de la opción seleccionada */
      var mData = mOption.dataset;
      /* Referencia a los input */
      var elId = document.getElementById('idDoc');
      var elNombre = document.getElementById('nombre');
      /* Asignamos cada dato a su input*/
      elId.value = this.value;
      elNombre.value = mOption.text; /*Se usará el valor que se muestra*/
    };
    
    document.getElementById('inspector').onchange = function() {
      /* Referencia al option seleccionado */
      var mOption = this.options[this.selectedIndex];
      /* Referencia a los atributos data de la opción seleccionada */
      var mData = mOption.dataset;
      /* Referencia a los input */
      var elId = document.getElementById('idInsp');
      var elNombre = document.getElementById('nombre');
      /* Asignamos cada dato a su input*/
      elId.value = this.value;
      elNombre.value = mOption.text; /*Se usará el valor que se muestra*/
    };
    
     document.getElementById('cliente').onchange = function() {
      /* Referencia al option seleccionado */
      var mOption = this.options[this.selectedIndex];
      /* Referencia a los atributos data de la opción seleccionada */
      var mData = mOption.dataset;
      /* Referencia a los input */
      var elIdC = document.getElementById('idCli');
      var elNombreC = document.getElementById('nombre');
      /* Asignamos cada dato a su input*/
      elIdC.value = this.value;
      elNombreC.value = mOption.text; /*Se usará el valor que se muestra*/
    };
    
    
  </script>
  </div>
  <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
        <script>
            function click(){
                 alert(Entra); 
            }
        </script>
        <script>
            function close_tab(){
                window.close();
            }
        </script>
  <?php include 'footer.php';?>
</body>
</html>