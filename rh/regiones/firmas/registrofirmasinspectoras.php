<?php include '../sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include "../conexion/Conexion2.php";
include  "../clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaPaises = $bloques->buscapaises();

$countries = array();
?>
<head>
  <title>Registro Firmas Inspectoras</title>
  <link rel='stylesheet' href='../pages/css/estilosSebastian.css'>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/regiones.css">
</head>

<body>
  <?php include '../header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO FIRMAS INSPECTORAS </div>
  <div class="link_int">
      <div class="titulo2">  <a href="../firmas/listafirmasinspectoras.php">+Listar Firmas Inspectoras</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Firma inspectora</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="../firmas/controller/controllerFirmas.php" method="POST">
      <div class="inputs_r">
      <label>Nombre:</label>
      <input class="inp_med" type='text' name='nombreFirma' placeholder="Ingrese nombres"  required>
    </div>
    <div class="inputs_r">
     <label>Tipo de Identificación:</label>
      <?php
      $consultatipodoc = $bloques->buscartipodocumento();
      ?>
        <select type="text" id="contact" name="contacto" onkeyup="PasarValor();">
          <option value="">Seleccionar....</option>
            <?php while ($columna = $bloques->obtener_fila($consultatipodoc)) { ?>
              <option value="<?php echo $columna['identificador']; ?>"><?php echo $columna['id_alfanumerico'] . ' -' . $columna['nombre']; ?> </option>
        <?php } ?>

        <!-- <option value="0">No aplica</option>-->

      </select>
    </div>
    <input class="ver" id="idDoc" name="tipoDoc" type="">

     <div class="inputs_r">
        <label>Número de Identificación</label>
      <input class="inp_med" type="text" name="numeroIdentificacion" placeholder="Ingrese Numero Identificacion" required>
     </div>
     <div class="inputs_r">
       <label>Dirección</label>
      <input class="inp_med" type="text" name="direccion" placeholder="Ingrese Direccion" required>
     </div>
     <div class="inputs_r">
       <label>Numero de Teléfono de Contacto</label>
      <input class="inp_med" type="number" name="telefono" placeholder="Ingrese Telefono" required>
     </div>
     <div class="inputs_r">
        <label>Correo Electrónico de contacto</label>
      <input class="inp_med" type='email' value='' name="correoElectronico" placeholder="Ingrese correo electronico" required>
      </div>
     <div class="inputs_r">
            <label for="name1">Pais de Ubicación principal</label>
            <select id="paises_id" class="inp_med" name="paises_id">
                <option value="">-- SELECCIONE PAIS --</option>
                <?php
                while ($r = $bloques->obtener_fila($consultaPaises)) {
                    $codigo = $r['codigo'];
                    $nombre = $r['nombre'];
                ?>
                    <option value="<?php echo $codigo; ?>"><?php echo $nombre; ?></option>
                <?php 
                }
                 ?>
         </select>
        </div>
        <div class="inputs_r">
          <label for="name1">Departamento de Ubicación principal</label>
          <select id="departamento_id" class="form-control" name="departamento_id">
            <option value="">-- SELECCIONE DEPARTAMENTO--</option>
          </select>
        </div>
        <div class="inputs_r">
          <label for="name1">Ciudad de Ubicación principal</label>
          <select id="ciudad_id" class="form-control" name="ciudad_id">
            <option value="">-- SELECCIONE CIUDAD --</option>
          </select>
        </div>
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registrarFirmas" value="Guardar">
    </div>
  </form>
  <script type="text/javascript">
    $(document).ready(function(){
            $("#paises_id").on('change', function () {
                $("#paises_id option:selected").each(function () {
                    elegido=$(this).val();
                    $.post("../ajaxlistdep.php", { elegido: elegido }, function(data){
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
                $.post("../ajaxlistciudad.php", { eldep: eldep , elpais: elpais }, function(data){
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