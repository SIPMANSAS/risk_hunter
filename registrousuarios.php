<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include 'conexion/Conexion2.php';
include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaPaises = $bloques->buscapaises();

$countries = array();
?>
<head>
  <title>Registro Unico de Usuarios</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- CDN for chosen plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <!-- CDN for CSS of chosen plugin -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO USUARIOS </div>
  <div class="link_int">
      <div class="titulo2">  <a href="listausuariosrh.php">+Listar Usuarios</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Usuarios</div>
    </div>
  <div class="contenedor">
  <!--<form class="registro" action="controller/controllerFirmas.php" method="POST">-->
  <form class="registro" action="controller/controllerusuarios.php" method="POST">

    
    <div class="inputs_r">
      <label>Nombres:</label>
      <input class="inp_med" type='text' name='nombreusuario' placeholder="Ingrese nombres"  required>
    </div>
    <div class="inputs_r">
      <label>Apellidos:</label>
      <input class="inp_med" type='text' name='apellidosusuario' placeholder="Ingrese apellidos"  required>
    </div>
    <div class="inputs_r">
     <label>Tipo de Identificación:</label>
      <?php
      $consultatipodoc = $bloques->buscartipodocumento();
      ?>
        <select type="text" id="contact" name="identificacion" onkeyup="PasarValor();" required>
          <option value="">Seleccionar....</option>
            <?php while ($columna = $bloques->obtener_fila($consultatipodoc)) { ?>
              <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['id_alfanumerico'] . ' -' . $columna['nombre']); ?> </option>
        <?php } ?>

        <!-- <option value="0">No aplica</option>-->

      </select>
    </div>
    <input class="ver" id="idDoc" name="tipoDoc" type="">

     <div class="inputs_r">
        <label>Número de Identificación</label>
      <input class="inp_med" type="number" name="numeroIdentificacion" placeholder="Ingrese Numero Identificacion" required>
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
            <select id="paises_id" class="inp_med" name="paises_id" required>
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
          <select id="departamento_id" class="form-control" name="departamento_id" required>
            <option value="">-- SELECCIONE DEPARTAMENTO--</option>
          </select>
        </div>
        <div class="inputs_r">
          <label for="name1">Ciudad de Ubicación principal</label>
          <select id="ciudad_id" class="form-control" name="ciudad_id" required>
            <option value="">-- SELECCIONE CIUDAD --</option>
          </select>
        </div>
        <div class="inputs_r">
            <label>Dirección</label>
            <input class="inp_med" type="text" name="direccion" placeholder="Ingrese Direccion" required>
        </div>
        <div class="inputs_r">
            <label>Rol de Usuario</label>
            <select name="roles[]" id="cars" multiple>
                <?php
                include 'conexion/conexion.php';
                $consultaroles = $mysqli->query("SELECT * FROM sg_roles");
                while($extraerroles = $consultaroles->fetch_array()){
                ?>
                <option value="<?php echo $extraerroles['identificador']?>"><?php echo $extraerroles['nombre_corto']?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="inputs_r">
            <label>Clientes</label>
            <select name="cliente[]" id="cars" multiple>
                <?php
                include 'conexion/conexion.php';
                $consultaroles = $mysqli->query("SELECT * FROM ter_terceros");
                while($extraerroles = $consultaroles->fetch_array()){
                ?>
                <option value="<?php echo $extraerroles['identificacion']?>"><?php echo $extraerroles['nombres']?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="inputs_r">
            <label>Oficina</label>
            <select name="oficina">
                <option value="0">Seleccione Oficina</option>
                <?php
                $consultaoficinas = $mysqli->query("SELECT * FROM ter_oficinas");
                while($extraerDatos = $consultaoficinas->fetch_array()){
                ?>
                <option value="<?php $extraerDatos['identificador']?>"><?php echo $extraerDatos['nombre']?></option>
                <?php
                }
                ?>
            </select> 
            <!--<input class="inp_med" type="text" name="oficina" placeholder="Ingrese Oficina" required>--->
        </div>
        <?php
        /*
        <div class="inputs_r">
            <label>Inspector Asignado</label>
            <?php
            $consultainspectorindependiente = $bloques->consultainspectorindependiente();
            ?>
            <select type="text" id="contact" name="inspector" onkeyup="PasarValor();">
                <option value="">Seleccionar....</option>
                <?php while ($columna = $bloques->obtener_fila($consultainspectorindependiente)) { ?>
                    <option value="<?php echo $columna['identificador']; ?>"><?php echo $columna['nombre'] . ' ' . $columna['apellidos']; ?> </option>
                <?php } ?>

        <!-- <option value="0">No aplica</option>-->

      </select>
        </div>
        */
        ?>
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registarusuarios" value="Guardar">
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