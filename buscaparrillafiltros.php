<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php

include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaPaises = $bloques->buscapaises();

$countries = array();
?>
<head>
  <title>Busqueda Personalizada Inspecciones</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-search"></i>&nbsp;&nbsp;Busqueda Personalizada Inspecciones</div>
  <div class="link_int">
      <div class="titulo2"><a href="listasabana.php"><i class="fa-solid fa-list"></i> Regresar</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Parametros de busqueda</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="exportacion/exportarsabanafiltro.php" method="POST">
    <div class="inputs_r">
        <label>Fecha Inicial:</label>
        <input type="date" name="fechaInicial" required>
    </div>
    <div class="inputs_r">
        <label>Fecha Final:</label>
        <input type="date" name="fechaFinal" required>
    </div>
    
     <div class="inputs_r">
            <label>Compañia de Seguros:</label>
            <?php
            $id_usuario = $id_menu_p;
            $consultacompanias = $bloques->consultaciasxusuario($id_usuario);
            ?>
            <select name="companiaseguros" required>
                <option value="">Seleccionar....</option>
                <option value="%">Todas</option>
                <?php
                while($columnaT = $bloques->obtener_fila($consultacompanias)){
                ?>
                <option value="<?php echo $columnaT['id_cliente']; ?>"><?php echo $columnaT['numero_identificacion'] . ' - ' . utf8_encode($columnaT['nombres']); ?> </option>
                 <?php } ?>
            </select>
        </div>
        <div class="inputs_r">
            <label>Firma Inspectora:</label>
            <?php
            $consultafirmas = $bloques->consultafirmasxusuario($id_usuario);
            ?>
            <select name="firmainspectora" required>
                <option value="">Seleccionar....</option>
                <option value="%">Todas</option>
                <?php
                while($columnaF = $bloques->obtener_fila($consultafirmas)){
                ?>
                <<option value="<?php echo $columnaF['id_cliente']; ?>"><?php echo $columnaF['numero_identificacion'] . ' - ' . utf8_encode($columnaF['nombres']); ?> </option>
                 <?php } ?>
            </select>
        </div>
        <div class="inputs_r">
            <label>Inspector:</label>
            <?php
            $consultainspector = $bloques->consultainspectoresindependientes();
            ?>
            <select name="inspector" required>
                <option value="">Seleccionar....</option>
                 <option value="%">Todos</option>
                <?php
                while($columnaT = $bloques->obtener_fila($consultainspector)){
                ?>
                <<option value="<?php echo $columnaT['identificador']; ?>"><?php echo $columnaT['nombre'] . ' ' . utf8_encode($columnaT['apellidos']); ?> </option>
                 <?php } ?>
            </select>
        </div>
     <div class="inputs_r">
        <label>Número de Inspección</label>
      <input class="inp_med" type="text" name="numeroInspeccion" placeholder="Ingrese Numero Inspección" required>
     </div>
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="buscar" value="Buscar">
    </div>
  </form>
  
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