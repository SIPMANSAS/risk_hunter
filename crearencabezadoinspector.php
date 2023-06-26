<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php
include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();
$consultaPaises = $bloques->buscapaises();

$countries = array();
$fecha = date('Y/m/d');
?>
<head>
  <title>Registro Encabezado Inspector</title>
 <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php include 'header-rh.php';?>
  <?php $id_menu_p?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO ENCABEZADO INSPECTOR</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listarencabezadoinspector.php">+Listar Encabezados</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo"> Información sobre la inspección</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerencabezado.php" method="POST" enctype="multipart/form-data">  
  <?php
  /*
        <div class="inputs_r">
            <label>Tipo:</label>
            <?php
            $consultatipo = $bloques->consultadominioselect();
            ?>
            <select name="tipo">
                <option value="">Seleccionar....</option>
                <?php
                while($columnaT = $bloques->obtener_fila($consultatipo)){
                ?>
                <<option value="<?php echo $columnaT['identificador']; ?>"><?php echo $columnaT['id_alfanumerico'] . ' - ' . utf8_encode($columnaT['nombre']); ?> </option>
                 <?php } ?>
            </select>
        </div>
        */
        ?>
        <div class="inputs_r">
            <?php  $email ?>
            <input class="ver" type='text' name='email' value="<?php echo $email?>" required>
            <input class="ver" type='text' name='usuario' value="<?php echo $id_menu_p?>" required>
            <label>Fecha Solicitud de Inspección:</label>
            <input class="inp_med"  value="<?php echo $fecha ?>" min="<?php echo $fecha ?>" disabled>
            <input class="ver" name='fechaSolicitud' value="<?php echo $fecha ?>" min="<?php echo $fecha ?>" readonly>
        </div>
        <div class="inputs_r">
            <label>Número de Inspección:</label>
            <?php
            $xsecuencia = $bloques->ultimoregistro();
            $ultimocodigo = $bloques->obtener_fila($xsecuencia);
            if(!isset($ultimocodigo['Ultimo'])){
                $ultimoreg=1;
            }else{
                $ultimoreg=$ultimocodigo['Ultimo'];
            }
            $date=date("Y");
            '<b>'.$numeroinspeccion = 'FI'.'-'.$date.'-'.$ultimoreg;
            ?>
            <input class="inp_med" type="text" value="<?php echo $numeroinspeccion ?>" disabled>
            <input class="ver" type="text" name="numeroInspeccion" placeholder="Ingrese Numero Inspección" value="<?php echo $ultimoreg ?>" required>
        </div>
        <div class="inputs_r">
            <label>Compañia de Seguros:</label>
            <input class="inp_med" type="" name="companiaseguros" value="">
        </div>
        <div class="inputs_r">
            <label>Oficina:</label>
             <input class="inp_med" type="" name="oficina" value="">
        </div>
        <div class="inputs_r">
            <label>Personal que asigna:</label>
            <input type="hidden" name="quienasigna" value="<?php echo $id_menu_p?>">
            <input class="inp_med" name="nombreasigna" value="<?php echo $usuario_login?>" disabled>
        </div>
        <div class="inputs_r">
            <label>Número Contacto Asignador:</label>
            <input type="hidden" name="numeroasigna" value="<?php echo $numerocontacto?>">
            <input class="inp_med" type='text' value="<?php echo $numerocontacto ?>" placeholder="Ingrese numero contacto asignador"  disabled>
        </div>
        <div class="inputs_r">
            <label for="name1">Pais de Ubicación principal:</label>
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
          <label for="name1">Departamento de Ubicación principal:</label>
          <select id="departamento_id" class="form-control" name="departamento_id" required>
            <option value="">-- SELECCIONE DEPARTAMENTO--</option>
          </select>
        </div>
        <div class="inputs_r">
          <label for="name1">Ciudad de Ubicación principal:</label>
          <select id="ciudad_id" class="form-control" name="ciudad_id" required>
            <option value="">-- SELECCIONE CIUDAD --</option>
          </select>
        </div>
        <div class="inputs_r">
            <label>Dirección del Bien a inspecciónar:</label>
            <input class="inp_med" type="text" name="direccion" placeholder="Ingrese Direccion" required>
        </div>
        <div class="inputs_r">
            <label>Nombre Edificación:</label>
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
            <label>Firma Inspectora:</label>
            <?php
                $consultafirmas = $bloques->consultafirmasactivasselect();
            ?>
            <select type="text" id="contact" name="firmainspectora" onkeyup="PasarValor();">
                <option value="">Seleccionar....</option>
                <?php while ($columna = $bloques->obtener_fila($consultafirmas)) { ?>
                    <option value="<?php echo $columna['identificacion']; ?>"><?php echo $columna['numero_identificacion'] . ' -' . $columna['nombres']; ?> </option>
                <?php } ?>
                <!-- <option value="0">No aplica</option>-->
            </select>
        </div>
        <div class="inputs_r">
            <label> Número de contacto de la firma inspectora:</label>
            <input class="inp_med" type="text" name="contacto_firma_inspectora" placeholder="Ingrese Contacto Persona que Atiende" required>
        </div>
        <div class="inputs_r">
            <label>Lista de Bienes A Inspeccionar:</label>
            <?php
            /*
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
            */
            ?>
            <input class="inp_med" type="file" name="archivo" placeholder="Ingrese Lista de Bienes" required>
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
            <label>Posible Fecha Inspección:</label>
            <input class="inp_med" type='date' name='fechaInspeccion' max="" min="<?php echo $fechaFinal;?>"  required>
        </div>
        <div class="inputs_r">
            <label>Nombre del inspector asignado:</label>
            
            <select type="text" id="contact" name="inspectorasignado" onkeyup="PasarValor();">
            <?php
                $consultausuarioxrolinspectores = $bloques->consultausuarioxrolinspectores();
            ?>
            <option value="">Seleccionar....</option>
            <?php
            while($columnai = $bloques->obtener_fila($consultausuarioxrolinspectores)){
            ?>
            <option value="<?php echo $columnai['id_usuario'];?>"><?php echo $columnai['id_usuario'].' - '.$columnai['nombre_corto'].' '.$columnai['apellidos'];?></option>
            <?php
            }
            ?>
            </select>
        </div>
        <div class="inputs_r">
            <label> Número de contacto del Inspector:</label>
            <input class="inp_med" type="text" name="contacto_firma_inspectora" placeholder="Ingrese Contacto Inspector" required>
        </div>
        <div class="inputs_r">
       <label>Fecha Inspección:</label>
            <input class="inp_med" type='date' name='fechaInspeccion' max="" min="<?php echo $fechaFinal;?>"  required>
        </div>
        <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registraencabezadoinspcetor" value="Guardar">
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
      var elId = document.getElementById('idCom');
      var elNombre = document.getElementById('nombre');
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