<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php

include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();

$id_inspeccion = $_GET['id_inspeccion'];
$countries = array();
?>
<head>
  <title>Registro de Bienes</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO DE BIENES </div>
  <div class="link_int">
      <div class="titulo2">  
      <form action="parrillainmuebles.php" method="POST">
          <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_inspeccion">
          <button type="submit">+Listar Bienes</button>
      </form>
    </div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Bienes</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controlleBienes.php" method="POST">
    <div class="inputs_r">
         <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccion">
        <label>Bien Contenedor:</label>
        <?php
        $consultatipoI = $bloques->consultabienestipo($id_inspeccion);
        $consultatipobien = $bloques-> selecttipobien();
        ?>
        <select type="text" id="tipobien" name="tipoBien" onkeyup="PasaValor();" required>
            <option value="">Seleccionar....</option>
            <?php while ($columna = $bloques->obtener_fila($consultatipoI)) { ?>
              <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['descripcion']); ?> </option>
        <?php } ?>
        </select>
    </div>
    
     <div class="inputs_r">
        <label>Tipo de Bien:</label>
         <select type="text" id="tipobien" name="biencontenedor" onkeyup="PasaValor();" required>
            <option value="">Seleccionar....</option>
            <?php while ($columnaB = $bloques->obtener_fila($consultatipobien)) { ?>
              <option value="<?php echo $columnaB['identificador']; ?>"><?php echo ($columnaB['nombre']); ?> </option>
        <?php } ?>
        </select>
    </div>
    <div class="inputs_r">
    <label>Descripción</label>
     <textarea class="inp_med" style="min-width:50%;min-height:90%;" name="descripcion" placeholder="Ingrese Descripción" required></textarea>
     </div>
     <div class="inputs_r">
    <label>Observaciones</label>
     <textarea class="inp_med" style="min-width:50%;min-height:90%;" name="observaciones" placeholder="Ingrese Observaciones"></textarea>
     </div>
     
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registrarBienes" value="Guardar">
    </div>
  </form>
  <script type="text/javascript">
    $(document).ready(function(){
            $("#paises_id").on('change', function () {
                $("#paises_id option:selected").each(function () {
                    elegido=$(this).val();
                    $.post("ajaxlistdep.php", { elegido: elegido }, function(data){
                    $("#departamento_id").html(data);           
                });			
            });
        });
        $("#departamento_id").on('change', function () {
            $("#departamento_id option:selected").each(function () {
                var eldep=$(this).val();
                var elpais = $("#paises_id").val();
                var parametros = { 
                    "eldep": eldep,
                    "elpais": elpais
               };
                $.post("ajaxlistciudad.php", { eldep: eldep , elpais: elpais }, function(data){
                    $("#ciudad_id").html(data);
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
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>