<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaPaises = $bloques->buscapaises();
$consultaFirmas = $bloques->consultafirmasactivas();

           

$countries = array();
$fecha = date('Y/m/d');
?>
<head>
  <title>Lista de bienes</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='https://davidstutz.github.io/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
        
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <?php include 'header-rh.php';?>
  <?php 
  $id_menu_p; 
  $idoficina;?>
  
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> BIENES</div>
  <div class="link_int">
    </div>
    <div class="contenedor_titulos">
      <div class="titulo"> Lista de bienes</div>
    </div>
  <div class="contenedor">
  <form class="registro" enctype="multipart/form-data">  
        
        <div class="inputs_r">

            <?php
             include 'conexion/conexion.php';
            $consultabienes = $mysqli->query("SELECT * FROM `cg_valores_dominio` WHERE id_dominio BETWEEN 4 AND 8 ORDER BY nombre ");
            while($extraerDatos=$consultabienes->fetch_array()){
                $identificador = $extraerDatos['identificador'];
                $nombre = $extraerDatos['nombre'];
            ?>
                <label for="name1"><?php echo utf8_encode($nombre) ?></label>
                <input class="inp_med" type="checkbox" name="bien[]" value="<?php echo $identificador ?>">
                <a href="adicionar.php" target="_blank">+Adicionar</a>
                
            <?php
            }
            ?>
        </div>
        <div class="inputs_r">
            <?php
                date_default_timezone_set('America/Bogota');
                $fecha1=date('Y-m-j');
                $validnadoFecha=substr($fecha1,0,4);
                $mesValidado=substr($fecha1,5,2);
                $diaValidado=substr($fecha1,8,2);
                $resultadoFecha=$validnadoFecha;
                if($diaValidado > 0 && $diaValidado < 10){
                    $enviarCero='0';
                }
                $fechaFinal=$resultadoFecha.'-'.$mesValidado.'-'.$enviarCero.''.$diaValidado;
            ?>
        </div>
        
        <div class="inputs_r">
            <input class="btn_azul" type='submit' name="registraencabezadocompania" value="Guardar">
        </div>
        
        
   
<script>
    var input = document.getElementById('input');
    var input2 = document.getElementById('input2');
    var input3 = document.getElementById('input3');
    var input4 = document.getElementById('input4');

function carg(elemento) {
  d = elemento.value;
  
  if(d == "1"){
    input.disabled = false;
    //input2.disabled = false;
    //input3.disabled = true;
    
  }else if(d == "2"){
    nit.disabled = false;
    input3.disabled = true;
    input2.disabled = false;
    input4.disabled = true;
    //input2.enabled = true;
  }
}
</script>
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
        function selectNit(e) {
    var nit =  e.target.selectedOptions[0].getAttribute("data-nit")
    document.getElementById("nit").value = nit;
    }
    </script>
    
    
    <script>
    var input = document.getElementById('input');
    var input = document.getElementById('input2');

function carg(elemento) {
  d = elemento.value;
  
  if(d == "2"){
    input.disabled = false;
    input2.disabled = false;
    input3.disabled = true;
    input4.disabled = true;
  }else{
    input.disabled = true;
    input2.disabled = true;
    input3.disabled = false;
    input4.disabled = true;
  }
}
</script>
    
    
    <script>
        document.getElementById('contact').onchange = function() {
        /* Referencia al option seleccionado */
            var mOption = this.options[this.selectedIndex];
            /* Referencia a los atributos data de la opción seleccionada */
            var mData = mOption.dataset;
            /* Referencia a los input */
            var elId = document.getElementById('id');
            var elNombre = document.getElementById('nombre');
            var eltelefono = document.getElementById('telefono');
        /* Asignamos cada dato a su input*/
            elId.value = this.value;
            elNombre.value = mOption.text; /*Se usará el valor que se muestra*/
        };
    </script>
                                
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>