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
  <title>Registro Encabezado Compañia Aseguradora</title>
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
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php include 'header-rh.php';?>
  <?php 
  $id_menu_p; 
  $idoficina;?>
  
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO ENCABEZADO COMPAÑIA ASEGURADORA</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listarencabezadocompaniaseguros.php">+Listar Encabezados</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo"> Información sobre la inspección</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerencabezado.php" method="POST" enctype="multipart/form-data">  
        
        <div class="inputs_r">
            <?php  $email ?>
            <input class="" type="hidden" name="nusuario" value="<?php echo $nombresolicitante?>">
            <input class="" type='hidden' name='email' value="<?php echo $email?>" >
            <input class="ver" type='text' name='usuario' value="<?php echo $id_menu_p?>" required>
            <label>Fecha Solicitud de Inspección:</label>
            <input class="inp_med"  value="<?php echo $fecha ?>" min="<?php echo $fecha ?>" disabled>
            <input class="ver" name='fechaSolicitud' value="<?php echo $fecha ?>" min="<?php echo $fecha ?>" readonly>
            <input class="ver" name='' value="CA" >
            <?php
            $consulta = $bloques->iniciarVariables();
            $xsecuencia = $bloques->ultimoregistro();
            $ultimocodigo = $bloques->obtener_fila($xsecuencia);
            if(!isset($ultimocodigo['Ultimo'])){
                $ultimoreg=1;
            }else{
                $ultimoreg=$ultimocodigo['Ultimo'];
            }
            $date=date("Y");
            '<b>'.$numeroinspeccion = 'CA'.'-'.$date.'-'.$ultimoreg;
            ?>
            <input class="ver" name='ultimo' value="<?php echo $ultimoreg ?>" >
        </div>
        <div class="inputs_r">
            <label>Número de Inspección:</label>
            
            <input class="inp_med" type="text" value="<?php echo $numeroinspeccion ?>" disabled>
            <input class="ver" type="text" name="numeroInspeccion" placeholder="Ingrese Numero Inspección" value="<?php echo $numeroinspeccion ?>" required>
        </div>
        <div class="inputs_r">
            <label>Compañia de Seguros:</label>
            <?php
            $idusuario=$id_menu_p;
            $consultacompanias = $bloques->extraercompaniaseguros($idusuario);
            $companiaxseguro = $bloques->obtener_fila($consultacompanias);
            $companiaxid = $companiaxseguro['id_cliente'];
            $nombresxcompania = $companiaxseguro['nombres'];
            
            $consultaFirmasI = $bloques->buscafirmasI($companiaxid); 
           
            ?>
            <input class="inp_med" type="" name="" value="<?php echo $nombresxcompania?>" disabled>
            <input class="ver" type="" name="companiasegurosn" value="<?php echo $companiaxusuario?>">
            <input class="ver" type="" name="companiaseguros" value="<?php echo $companiaxid?>">
        </div>
        <div class="inputs_r">
            <label>Oficina:</label>
            <?php
            
            $consultaoficinaB = $bloques->consultaoficinaB($idusuario);
            $extraerOficinaB= $bloques->obtener_fila($consultaoficinaB);
            $oficinaidB = $extraerOficinaB['identificador'];
            $nombreoficinaB = $extraerOficinaB['nombre'];

            ?>
            <input class="inp_med"  value="<?php echo $nombreoficinaB?>" disabled>
            <input class="ver" name="oficina" value="<?php echo $oficinaidB?>">
        </div>
        <div class="inputs_r">
            <label>Personal que asigna:</label>
            <input type="hidden" name="quienasigna" value="<?php echo $id_menu_p?>">
            <input class="inp_med" name="nombreasigna" value="<?php echo $nombresolicitante?>" disabled>
        </div>
        <div class="inputs_r">
            <label>Número Contacto Asignador:</label>
            <input type="hidden" name="numeroasigna" value="<?php echo $numerocontacto?>">
            <input class="inp_med" type='text' value="<?php echo $numerocontacto ?>" placeholder="Ingrese numero contacto asignador"  disabled>
        </div>
        <div class="inputs_r">
            <label>Nombre Solicitante:</label>
            <input class="inp_med" type="text" name="nombreSolicitante" placeholder="Ingrese Solicitante" required>
        </div>
        <div class="inputs_r">
            <label>Tipo de Identificación Solicitante:</label>
              <?php
              $consultatipodoc = $bloques->buscartipodocumento();
              ?>
                <select type="text" name="tipoDoc" onkeyup="PasarValor();">
                  <option value="">Seleccionar....</option>
                    <?php while ($columna = $bloques->obtener_fila($consultatipodoc)) { ?>
                      <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['nombre']); ?> </option>
                <?php } ?>

                <!-- <option value="0">No aplica</option>-->
                </select>
        </div>
        <div class="inputs_r">
            <label>Número de Identificación Solicitante:</label>
            <input class="inp_med" type="number" name="numeroIdentificacion" placeholder="Ingrese Numero Identificacion"  required>
        </div>
        <div class="inputs_r">
            <label>Tomador:</label>
            <input class="inp_med" type="text" name="tomador" placeholder="Ingrese Nombre Tomador" required>
        </div>
        <div class="inputs_r">
            <label>Asegurado:</label>
            <input class="inp_med" type="text" name="asegurado" placeholder="Ingrese Nombre Asegurado" required>
        </div>
        <div class="inputs_r">
            <label for="name1">Pais de Ubicación principal (*)</label>
            <select id="paises_id" class="inp_med" name="pais" required>
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
          <label for="name1">Departamento de Ubicación principal (*)</label>
          <select id="departamento_id" class="form-control" name="departamento_id" required>
            <option value="">-- SELECCIONE DEPARTAMENTO--</option>
          </select>
        </div>
        <div class="inputs_r">
          <label for="name1">Ciudad de Ubicación principal (*)</label>
          <select id="ciudad_id" class="form-control" name="ciudad_id" required>
            <option value="">-- SELECCIONE CIUDAD --</option>
          </select>
        </div>
        <div class="inputs_r">
            <label>Dirección del Bien a inspecciónar:</label>
            <input class="inp_med" type="text" name="direccion" placeholder="Ingrese Direccion" required>
        </div>
        <div class="inputs_r">
            <label>Nombre Edificación(Propiedad Horizontal):</label>
            <input class="inp_med" type="text" name="edificacion" placeholder="Ingrese Nombre Edificación" required>
        </div>
        <div class="inputs_r">
            <label>Nombre de la persona Quien Atiende la inspección:</label>
            <input class="inp_med" type="text" name="persona_atiende" placeholder="Ingrese Persona que Atiende" required>
        </div>
        <div class="inputs_r">
            <label> Número de contacto de quien atenderá la inspección:</label>
            <input class="inp_med" type="text" name="contacto_persona_atiende" placeholder="Ingrese Contacto Persona que Atiende" required>
        </div>
        <div class="inputs_r">
            <label>Tipo: </label>
            <select name='id_categoria' id='id_categoria' onchange="carg(this);">
                <option value="0" selected>Seleccionar</option>
                <option value="1">Firma Inspectora</option>
                <option value="2">Tecnico</option>
            </select>
        </div>
        <div class="inputs_r">
            <label for="name1">Firma Inspectora</label>
            <select onchange="selectNit(event),carg(this);" class="inp_med" name="firma" id="input3">
                <option value="">-- SELECCIONE FIRMA --</option>
                <?php
                while ($r = $bloques->obtener_fila($consultaFirmasI)) {
                    $codigoF = $r['identificacion'];
                    $nombreF = $r['nombres'];
                    $telefono = $r['telefono'];
                ?>
                <option data-nit="<?php echo $telefono ?>" value="<?php echo $codigoF; ?>"><?php echo $nombreF; ?></option>
                <?php 
                }
                ?>
        </select>
        </div>
        <div class="inputs_r">
            <label for="name1">Telefono Firma Inspectora Firma</label>
            <input class="inp_med" onchange="carg(this);" id="nit" type="text"  name="telefonofirma" readonly>
        </div>
        <div class="inputs_r">
            <label>Técnico</label>
              <?php
              
              $consultatecnico = $bloques->buscauserxtecnicosC($idusuario);
              ?>
                <select type="text" name="tecnico" onkeyup="PasarValor();" id="input2" onchange="carg(this);">
                  <option value="">Seleccionar....</option>
                    <?php //while ($columnaT = mysqli_fetch_array($consultatecnicosselect)) { 
                    while($columnaT = $bloques->obtener_fila($consultatecnico)){
                    ?>
                      <option value="<?php echo $columnaT['id_usuario']; ?>"><?php echo ($columnaT['id_usuario'].'-'.$columnaT['nombre_corto'].' '.$columnaT['apellidos']); ?> </option>
                <?php } ?>

                <!-- <option value="0">No aplica</option>-->
                </select>
        </div>

        <div class="inputs_r">
            <label>Lista de Bienes A Inspeccionar:</label>
            
            <select type="text" id="contact" name="biene" onkeyup="PasarValor();">
            <?php
                $consultabiene = $bloques->consultabienes();
            ?>
            <option value="">Seleccionar....</option>
            <?php
            while($columnab = $bloques->obtener_fila($consultabiene)){
            ?>
            <option value="<?php echo $columnab['identificador'];?>"><?php echo $columnab['nombre'];?></option>
            <?php
            }
            ?>
            </select>
            <input class="inp_med" type="file" name="archivo" placeholder="Ingrese Lista de Bienes">
        </div>

        <?php
        /*
        <div class="inputs_r">
            <label>Seleccionar Bienes A Inspeccionar:</label>
            <?php
            $consultabienesB = $bloques->consultabieneslista();
            while($extraerDatosB = $bloques->obtener_fila($consultabienesB)){
                $identificador = $extraerDatosB['identificador'];
                $nombre = $extraerDatosB['nombre'];
            ?>
                <label for="name1"><?php echo ($nombre) ?></label>
                <input class="inp_med" type="checkbox" name="bien[]" value="<?php echo $identificador ?>">
                
            <?php
            }
            ?>
        </div>
        */
        ?>
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
            <label>Posible Fecha Inspección:</label>
            <input class="inp_med" type='date' name='fechaInspeccion' max="" min="<?php echo $fechaFinal;?>"  required>
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