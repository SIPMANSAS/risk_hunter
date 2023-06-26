<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php

include 'conexion/conexion.php';
?>
<head>
  <title>Parametrización</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
</head>

<body>
    <?php include 'header-rh.php';?>
    <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> PARAMETRIZACIÓN </div>
    <div class="link_int">
        <div class="titulo2">
            <i class="fa-solid fa-list"></i>
            <a href="listarpreguntasrh.php"> Regresar</a>
        </div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Parametrización</div>
    </div>
  <div class="contenedor">
      
  <!--<form class="registro" action="controller/controllerFirmas.php" method="POST">-->
  <form class="registro" action="administracionparametrizacion.php" method="POST">
    
     <div class="inputs_r">
      <label>Texto Parametrización:</label>
      <textarea class="inp_med" type='text' name='textoparametrizacion' placeholder="Ingrese Texto"  required></textarea>
    </div>
    
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="parametrizacion" value="Guardar">
    </div>
  </form>
  <?php
  if(isset($_POST['parametrizacion'])){
    $textoparametrizacion = $_POST['textoparametrizacion'];

   
    $insertadatos = $mysqli->query();
    echo '<script language="javascript">alert("Se ha registrado la firma ' . strtoupper($firmaInspectora) . ' correctamente.");
        window.location.href="registrofirmasinspectoras.php"</script>';
  }
  ?>
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