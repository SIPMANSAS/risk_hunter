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
  <title>Registro Roles</title>
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
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO DE ROLES </div>
  <div class="link_int">
      <div class="titulo2">  <a href="listaroles.php">+Listar Roles</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Roles</div>
    </div>
  <div class="contenedor">
  <!--<form class="registro" action="controller/controllerFirmas.php" method="POST">-->
  <form class="registro" action="controller/controllerroles.php" method="POST">

    
    <div class="inputs_r">
     <label>Nombre Rol:</label>
      <input class="inp_med" type="text" name="nombre_rol" placeholder="Ingrese nombre del rol">
    </div>
    <input class="ver" id="idDoc" name="tipoDoc" type="">

        <?php/*<div class="inputs_r">
            <label>Roles</label>
            <select name="roles[]" id="cars" multiple>
                <?php
                include 'conexion/conexion.php';
                $consultaroles = $mysqli->query("select identificador, nombre_corto, descripcion, tipo_estado, estado from sg_roles");
                while($extraerroles = $consultaroles->fetch_array()){
                ?>
                <option value="<?php echo $extraerroles['identificador']?>"><?php echo $extraerroles['nombre_corto']?></option>
                <?php
                }
                ?>
            </select>
        </div>*/
        ?>
        <div class="inputs_r">
            <label>Permisos</label>
            <select name="permisos[]" id="cars" multiple>
                <?php
                include 'conexion/conexion.php';
                $consultarolespermisos = $mysqli->query("select sc.identificador id_clase, sc.nombre nom_clase, so.identificador id_objeto, so.nombre nom_objeto from sg_clases sc , sg_objetos so 
                    where sc.identificador = so.id_clase and sc.estado = 1 and so.estado = 1 ");
                while($extraerrolespermisos = $consultarolespermisos->fetch_array()){
                ?>
                <option value="<?php echo $extraerrolespermisos['id_objeto']?>"><?php echo $extraerrolespermisos['nom_objeto']?></option>
                <?php
                }
                ?>
            </select>
        </div>
        
    <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registraroles" value="Guardar">
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