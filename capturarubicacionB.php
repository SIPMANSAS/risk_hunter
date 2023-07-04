<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <?php
    /*
    <script>
        if (window.confirm("Por último, para Generar el Informe, compártenos el Estrato y el Espacio geográfico del inmueble que estás inspeccionando.")) {
        }else{
            window.close();
        }
    </script>
<?php
*/
include 'conexion/conexion.php';
include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();

$id_inspeccion = $_REQUEST['id_inspeccion'];
$id_usuario = $_GET['id_usuario'];
$countries = array();


$fecha_actualizacion = date('Y-m-d H:i:s');
$actualizaestadoinspeccionfecha = $mysqli->query("UPDATE enc_inspeccion SET fecha_terminacion ='$fecha_actualizacion' WHERE identificador='$id_inspeccion'");
?>
<head>
  <title>Registro Información Particular</title>
  <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico">
  <link rel="stylesheet" href="css/regiones.css">
</head>

<body>
  <?php include 'header-rh.php';?>
      <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> REGISTRO INFORMACIÓN PARTICULAR </div>
  <div class="link_int">
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Ubicación Geoestacionaria</div>
    </div>
  <div class="contenedor">
    <form class="registro" action="controller/controlleBienes.php" method="POST">
        <div class="inputs_r">
            <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccion">
            <label>Longitud:</label>
            <input type="text" class="inp_med" id="longitud" name="longitudB" >
        </div>
        <div class="inputs_r">
            <label>Latitud:</label>
            <input type="text" class="inp_med" id="latitud" name="latitudB" >
        </div>
        <div class="inputs_r">
            <label>Estrato:</label>
            <?php
            $consultaestratos = $bloques->consultaestratos();
            ?>
            <select type="text" id="estrato" name="estratoB" onkeyup="PasaValor();" required>
                <option value="">Seleccionar....</option>
                <?php while ($columna = $bloques->obtener_fila($consultaestratos)) { ?>
                  <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['descripcion'].' - '.$columna['nombre']); ?> </option>
            <?php } ?>
            </select>
        </div>
    
       <div class="inputs_r">
            <label>Espacio Geografico:</label>
            <?php
            $consultaespaciogeografico = $bloques->consultaespaciogeografico();
            ?>
            <select type="text" id="espacioGeografico" name="espacioGeografico" onkeyup="PasaValor();" required>
                <option value="">Seleccionar....</option>
                <?php while ($columna = $bloques->obtener_fila($consultaespaciogeografico)) { ?>
                  <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['nombre']); ?> </option>
            <?php } ?>
            </select>
        </div>

                    <?php
                     $id_inspeccion = $id_inspeccion-1 ;
                     $consultaF = $mysqli->query("SELECT * FROM enc_detalles_inspeccion D,enc_inspeccion I,enc_preguntas P WHERE D.id_inspeccion=I.identificador AND D.id_pregunta = P.identificador AND D.id_inspeccion = $id_inspeccion"); 
                     $extarerDatosInspeccion = $consultaF->fetch_array(MYSQLI_ASSOC);
                     $numero_inspeccion = $extarerDatosInspeccion['numero_inspeccion'];
                     $companiaseguros = $extarerDatosInspeccion['id_cia_seguros'];
                     $firmainspectora = $extarerDatosInspeccion['id_firma_inspectora'];
                     $numeroidentificacio = $extarerDatosInspeccion['nid_solicita'];
                     $tipodocumentosolicitante = $extarerDatosInspeccion['tid_solicita'];
                     $npersonaatiende = $extarerDatosInspeccion['nombre_persona_atiende'];
                     $fecha_solicitud = $extarerDatosInspeccion['fecha_solicitud'];
                     $contactofirma = $extarerDatosInspeccion['contacto_firma'];
                     $pais_id = $extarerDatosInspeccion['id_pais'];
                     $ciudad = $extarerDatosInspeccion['id_departamento'];
                     $direccion = $extarerDatosInspeccion['id_ciudad'];
                     $nombreedificacion = $extarerDatosInspeccion['nombre_edificacion'];
                     $npersonaatiende = $extarerDatosInspeccion['nombre_persona_atiende'];
                     $cpersonaatiende = $extarerDatosInspeccion['contacto_persona_atiende'];
                     $inspectorasignadoF = $extarerDatosInspeccion['longitud'];
                     $longitud = $extarerDatosInspeccion['longitud'];
                     $latitud = $extarerDatosInspeccion['latitud'];
                     $espacio_geografico = $extarerDatosInspeccion['espacio_geografico'];
                     $estrato = $extarerDatosInspeccion['estrato'];
                     $bloque_inspeccion = $extarerDatosInspeccion['id_inspector'];
                     $fecha_terminacion = $extarerDatosInspeccion['fecha_terminacion'];
                     $fecha_actualizacion = $extarerDatosInspeccion['fecha_actualizacion'];
                     
                     $consultatextoinforme = $mysqli->query("SELECT p_informe_completo($id_inspeccion) AS p_informe");
                     $extraerDatosInforme = $consultatextoinforme->fetch_array(MYSQLI_ASSOC);
                     $texto_informe = $extraerDatosInforme['p_informe']; 
                    ?>
                    <input  type="hidden" value="<?php echo $numero_inspeccion ?>" name="inspeccion">
                    <input  type="hidden" value="<?php echo $extarerDatosInspeccion['identificador'];  ?>" name="identificador">
                    <input  type="hidden" value="<?php echo $companiaseguros ?>" name="cia_texto">
                    <input  type="hidden" value="<?php echo $firmainspectora;  ?>" name="firmainspectora"> 
                    <input  type="hidden" value="<?php echo $numeroidentificacio;  ?>" name="identificacion">
                    <input  type="hidden" value="<?php echo $tipodocumentosolicitante;  ?>" name="tipodocumentosolicitante">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_solicitudB">
                    <input  type="hidden" value="<?php echo $contactofirma;  ?>" name="contactofirma">
                    <input  type="hidden" value="<?php echo $nombreasigna;  ?>" name="nombreasigna">
                    <input  type="hidden" value="<?php echo $pais_id;  ?>" name="pais">
                    <input  type="hidden" value="<?php echo $ciudad;  ?>" name="ciudad">
                    <input  type="hidden" value="<?php echo $direccion;  ?>" name="direccion">
                    <input  type="hidden" value="<?php echo $nombreedificacion;  ?>" name="nombreedificacion">
                    <input  type="hidden" value="<?php echo $npersonaatiende;  ?>" name="nombrepersonaatiende">
                    <input  type="hidden" value="<?php echo $cpersonaatiende;  ?>" name="contactopersonaatiende">
                    <input  type="hidden" value="<?php echo $inspectorasignadoF;  ?>" name="inspectorasignado">
                    <input  type="hidden" value="<?php echo $longitud;  ?>" name="longitud">
                    <input  type="hidden" value="<?php echo $latitud;  ?>" name="latitud">
                    <input  type="hidden" value="<?php echo $estrato?>" name="estrato">
                    <input  type="hidden" value="<?php echo $bloque_inspeccion?>" name="bloque_inspeccion">
                    <input  type="hidden" value="<?php echo $fecha_terminacion ?>" name="fecha_terminacion">
                    <input  type="hidden" value="<?php echo $fecha_actualizacion ?>" name="fecha_actualizacion">
                    <?php
                    if($origen == 'FI'){
                        $origen = '3';
                    }elseif($origen == 'CA'){
                        $origen = '1';
                    }else{
                        $origen = '2';
                    }
                    ?>
                    <input  type="hidden" value="<?php echo $origen ?>" name="origen">
                    
                    <textarea style="visibility:hidden" name="texto_informe"><?php echo $texto_informe?></textarea>
                    
                    <input  type="hidden" value="2" name="Dato">
                    <div class="inputs_r">
                        <button class="btn_azul" type="submit" name="capturaubicacionfree">Finalizar Inspección</button>
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
    window.onload = miUbicacion;

function miUbicacion(){
		//Si los servicios de geolocalización están disponibles
		if(navigator.geolocation){
		// Para obtener la ubicación actual llama getCurrentPosition.
		navigator.geolocation.getCurrentPosition( muestraMiUbicacion );
		}else{ //de lo contrario
		alert("Los servicios de geolocalizaci\363n  no est\341n disponibles");
		}
}
function muestraMiUbicacion(posicion){
		var latitud = posicion.coords.latitude
		var longitud = posicion.coords.longitude
		var output = document.getElementById("ubicacion");
		document.getElementById("longitud").value = longitud;
		document.getElementById("latitud").value = latitud;
		//output.innerHTML = "Latitud: "+latitud+"  Longitud: "+longitud;
}
</script>
  </div>
  <div class="cont_fin"></div>
  <?php include 'footer.php';?>
</body>
</html>