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
  <title>Registro Encabezado Firma Inspectora</title>
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
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO ENCABEZADO FIRMA INSPECTORA</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listarencabezadofirmas.php">+Listar Encabezados</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo"> Información sobre la inspección</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerencabezado.php" method="POST" enctype="multipart/form-data">  
        <div class="inputs_r">
            <label>Tipo:</label>
            <?php
            $consultatipo = $bloques->consultadominioselect();
            ?>
            <select name="tipo" required>
                <option value="">Seleccionar....</option>
                <?php
                while($columnaT = $bloques->obtener_fila($consultatipo)){
                ?>
                <<option value="<?php echo $columnaT['identificador']; ?>"><?php echo $columnaT['id_alfanumerico'] . ' - ' . utf8_encode($columnaT['nombre']); ?> </option>
                 <?php } ?>
            </select>
        </div>
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
            $xsecuencia = $bloques->ultimoregistrofi();
            $ultimocodigo = $bloques->obtener_fila($xsecuencia);
            if(!isset($ultimocodigo['Ultimo'])){
                $ultimoreg=1;
            }else{
                $ultimoreg=$ultimocodigo['Ultimo'];
            }
            $date=date("Y");
            '<b>'.$numeroinspeccion = 'FI'.'-'.$date.'-'.$ultimoreg;
            ?>
            <input class="inp_med" type="text" name="codigoinspeccion" value="<?php echo $numeroinspeccion ?>" disabled>
            <input class="ver" type="text" name="numeroInspeccion" placeholder="Ingrese Numero Inspección" value="<?php echo $numeroinspeccion ?>" required>
             <input class="ver" type="text" name="numeroConsecutivo" placeholder="Ingrese Numero Inspección" value="<?php echo $ultimoreg+1 ?>" required>
        </div>
        <div class="inputs_r">
            <label>Firma Inspectora:</label>
            <?php
            
            $idusuario=$id_menu_p;
            $consulta = $bloques->iniciarVariables();
            $companiasegurosxusuario = $bloques->extraercompaniaseguros($idusuario);
            $companixusuario = $bloques->obtener_fila($companiasegurosxusuario);
            $nombrecompania = $companixusuario['nombres'];
            $idcliente = $companixusuario['id_cliente'];
            
            ?>
            <input class="inp_med" type="" value="<?php echo $nombrecompania?>" disabled>
             <input class="ver" type="" name="firmainspectora" value="<?php echo $idcliente?>">
        </div>
        <div class="inputs_r">
            <?php
           
            $consultatelefono = $bloques->consultatelefono($idcliente);
            $telefonoxusario = $bloques->obtener_fila($consultatelefono);
            $telefonoB = $telefonoxusario['telefono'];
            
            ?>
            <label> Número de contacto de la firma inspectora:</label>
            <input class="inp_med" type="text" name="" placeholder="Ingrese Contacto Persona que Atiende" value="<?php echo $telefonoB ?>" disabled>
            <input class="ver" type="text" name="contacto_firma_inspectora" placeholder="Ingrese Contacto Persona que Atiende" value="<?php echo $telefonoB ?>" required>
        </div>
        <div class="inputs_r">
            <?php
            include 'conexion/conexion.php';
            $consultaoficina = $mysqli->query("SELECT * FROM ter_oficinas WHERE id_tercero = '$idcliente'");
            $extraerDatosO = $consultaoficina->fetch_array(MYSQLI_ASSOC);
            $oficinaB = $extraerDatosO['nombre'];
            $idoficinaB = $extraerDatosO['identificador'];
            
            ?>
            <label>Oficina:</label>
             <input class="inp_med" type="" name="oficina" value="<?php echo $oficinaB?>">
             <input type="hidden" name="id_oficina" value="<?php echo $idoficinaB?>">
             
        </div>
        <div class="inputs_r">
            <label>Nombre de quien asigna:</label>
            <input type="hidden" name="quienasigna" value="<?php echo $id_menu_p?>">
            <input class="inp_med" name="nombreasigna" value="<?php echo $nombresolicitante?>" disabled>
        </div>
        <div class="inputs_r">
            <label>Número Contacto de quien asigna:</label>
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
                <select type="text" id="contact" name="tipoDoc" onkeyup="PasarValor();">
                  <option value="">Seleccionar....</option>
                    <?php while ($columna = $bloques->obtener_fila($consultatipodoc)) { ?>
                      <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['nombre']); ?> </option>
                <?php } ?>

                <!-- <option value="0">No aplica</option>-->
                </select>
        </div>
        <div class="inputs_r">
            <label>Número de Identificación Solicitante:</label>
            <input class="inp_med" type="text" name="numeroIdentificacion" placeholder="Ingrese Numero Identificacion" required>
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
             <label>Dirección de la inspección:</label>
            <input class="inp_med" type="text" name="direccion" placeholder="Ingrese Direccion" required>
        </div>
        <div class="inputs_r">
            <label>Nombre Edificación(Propiedad Horizontal):</label>
            <input class="inp_med" type="text" name="edificacion" placeholder="Ingrese Nombre Edificación" required>
        </div>
        <div class="inputs_r">
            <label>Nombre de la persona que Atendera la inspección:</label>
            <input class="inp_med" type="text" name="persona_atiende" placeholder="Ingrese Persona que Atiende" required>
        </div>
        <div class="inputs_r">
            <label> Número de contacto de quien atenderá la inspección:</label>
            <input class="inp_med" type="text" name="contacto_persona_atiende" placeholder="Ingrese Contacto Persona que Atiende" required>
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
        <!-- <div class="inputs_r">
            <label>Compañia de Seguros:</label>
            <input class="inp_med" type="" name="companiaseguros" value="">
        </div>
        <div class="inputs_r">
            <label>Tomador:</label>
            <input class="inp_med" type="text" name="tomador" placeholder="Ingrese Nombre Tomador" required>
        </div>
        <div class="inputs_r">
            <label>Asegurado:</label>
            <input class="inp_med" type="text" name="asegurado" placeholder="Ingrese Nombre Asegurado" required>
        </div>
        -->
        <div class="inputs_r">
            <label for="name1">Nombre del inspector asignado:</label>
            
             <select onchange="selectNit(event),carg(this);" class="inp_med" name="inspectorasignado" id="input3">
            <?php
                $consultausuarioxrolinspectores = $bloques->consultausuarioxrolinspectores();
            ?>
            <option value="">Seleccionar....</option>
            <?php
            while($columnai = $bloques->obtener_fila($consultausuarioxrolinspectores)){
                $telefono = $columnai['numero_telefono'];
            ?>
            <option data-nit="<?php echo $telefono ?>"  value="<?php echo $columnai['identificador'];?>"><?php echo $columnai['numidentificacion'].' - '.$columnai['nombre_corto'].' '.$columnai['apellidos'];?></option>
            <?php
            }
            ?>
            </select>
        </div>
        <div class="inputs_r">
            <label> Número de contacto del Inspector:</label>
            <input class="inp_med" onchange="carg(this);" id="nit" type="text" name="contacto_inspector" placeholder="Ingrese Contacto Inspector" required>
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
            <label>Fecha Inspección:</label>
            <input class="inp_med" type='date' name='fechaInspeccion' max="" min="<?php echo $fechaFinal;?>"  required>
        </div>
        <div class="inputs_r">
      <input class="btn_azul" type='submit' name="registraencabezadofirma" value="Guardar">
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
        function selectNit(e) {
    var nit =  e.target.selectedOptions[0].getAttribute("data-nit")
    document.getElementById("nit").value = nit;
    }
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