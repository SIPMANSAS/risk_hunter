<?php
$identificador_pregunta = $_GET['id'];

include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
?>
<?php include 'sec_login.php'; ?>
<html lang="es">
    <head>
  <title>Registro de Columnas</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php //include 'header-rh.php';?>
    <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO DE COLUMNAS </div>
    <div class="contenedor_titulos">
      <div class="titulo">Bienes</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerpreguntas.php" method="POST">
       <div class="inputs_r">
        <input  class="ver" name="identificador_pregunta" value='<?php echo $identificador_pregunta ?>' >
        <label>Nombre Columna</label>
        <input type="texto" class="inp_med" name="nombreColumna"  placeholder="Ingrese valor de la columna" required>
      </div>
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="agregarcolumnas" value="Guardar">
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
  
              <script>
                  function close_tab(){
                      window.close();
                  }
              </script></div>
  </div>
  <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a></div>
  <?php include 'footer.php';?>
</body>
</html>