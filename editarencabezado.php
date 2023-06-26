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
  <title>Edición Encabezado Compañia Aseguradora</title>
 <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php include 'header-rh.php';?>
  <div class="titulo_p"><i class="fa-solid fa-user"></i> &nbsp;&nbsp;ASIGNACION INSPECTOR FIRMA INSPECTORA</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listarencabezadofirmas.php">+Listar Encabezados</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo">Encabezado Firma Inspectora</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerencabezado.php" method="POST" enctype="multipart/form-data">  
        <div class="inputs_r">
            <?php
            $identificador = $_POST['identificador'];
            $fechasolicitud = $_POST['fechasolicitud'];
            $descripcion = $_POST['descripcion'];
            $id_cia_seguros = $_POST['id_cia_seguros'];
            $solicitante = $_POST['solicitante'];
            $tipodocumento = $_POST['tipodocumento'];
            $identificacion = $_POST['identificacion'];
            $tomador = $_POST['tomador'];
            $asegurado = $_POST['asegurado'];
            $nombreedificacion = $_POST['nombreedificacion'];
            $nombrepersonaatiende = $_POST['nombrepersonaatiende'];
            $contactopersonaatiende = $_POST['contactopersonaatiende'];
            $firmainspectora = $_POST['firmainspectora'];
            $fecha_inspeccion = $_POST['fecha_inspeccion'];
            $fecha_inspeccion_conv = strtotime($fecha_inspeccion);
            $fecha_inspe_fin = date("Y/m/d",$fecha_inspeccion_conv);
            $departamentoid = $_POST['departamento'];
            $ciudadid = $_POST['ciudad'];
            $paisid = $_POST['pais'];
            $direccion = $_POST['direccion'];
            $numero_inspeccion = $_POST['numero_inspeccion'];
            $nombreedificacion = $_POST['nombreedificacion'];
            $oficina = $_POST['id_oficina_cia_seguros'];
            $quienatiende = $_POST['nombre_persona_atiende'];
            $contacto_persona_atiende = $_POST['contacto_persona_atiende'];
            $idbienes = $_POST['id_bienes'];
            $lista_biene = $_POST['bienes'];
            $ref_inspeccion = $_POST['ref_inspeccion'];

            ?>
            <input class="ver" type='text' name='usuario' value="<?php echo $id_menu_p?>" required>
            <input class="ver" name='identificador' value="<?php echo $identificador?>" required>
            <label>Fecha Solicitud de Inspección:</label>
            <input class="inp_med"  value="<?php echo $fecha ?>" min="<?php echo $fecha ?>" disabled>
            <input class="ver" type='' name='fechaSolicitud' value="<?php echo $fecha ?>" min="<?php echo $fecha ?>" readonly>
        </div>
        <div class="inputs_r">
            <label>Número de Inspección:</label>
            <?php
            if($ref_inspeccion == NULL){
                $xsecuencia = $bloques->ultimoregistro();
                $ultimocodigo = $bloques->obtener_fila($xsecuencia);
                if(!isset($ultimocodigo['Ultimo'])){
                    $ultimoreg=1;
                }else{
                    $ultimoreg=$ultimocodigo['Ultimo'];
                }
                $date=date("Y");
                '<b>'.$numeroinspeccion = 'CA'.'-'.$date.'-'.$identificador;
            }else{
                $numeroinspeccion = $ref_inspeccion;
            }    
            ?>
            <input class="inp_med" type="text" value="<?php echo $numeroinspeccion ?>" disabled>
            <input class="ver" type="text" name="numeroInspeccion" placeholder="Ingrese Numero Inspección" value="<?php echo $ultimoreg ?>">
            <input class="ver" type="text" name="inspeccionSerial" value="<?php echo $numeroinspeccion?>">
        </div>
       <div class="inputs_r">
            <label>Firma Inspectora:</label>
            <?php
                $filtrofirmainspectora = $firmainspectora;
                $datafirma = $bloques->buscafirmasinspectoras($filtrofirmainspectora);
                $traefirma = $bloques->obtener_fila($datafirma);
                $firmaT = $traefirma['nombres'];
                $idfirma = $traedoc['identificacion'];
                $selectfirma = $bloques->consultafirmasdif($filtrofirmainspectora);
            ?>
            <input type="hidden" name="idfirma" value="<?php echo $firmainspectora ?>">
            <select type="text"  id="contact" name="firmainspectora" placeholder="Firma Inspectora" disabled>
                <option value="">Seleccionar...</option>
                <?php
                while ($columna = $bloques->obtener_fila($selectfirma)) { 
                ?>
                    <option value="<?php echo $columna['identificacion']; ?>"><?php echo $columna['nombres']; ?> </option>
                <?php 
                } 
                $selectFirma = "selected";
                ?> 
                <option value="<?php echo $idfirma; ?> " <?php echo $selectFirma ?>><?php echo utf8_encode($firmaT);?></option>
            </select>
        </div>
        <div class="inputs_r">
           <label> Número de contacto de la firma inspectora:</label>
           <?php
          
           $filtrotel = $firmainspectora;
           $datatel = $bloques->consultadatosfirma($filtrotel);
           $extraerDatos = $bloques->obtener_fila($datatel);
           $telefonoB = $extraerDatos['telefono'];
          
           ?>
            <input class="inp_med" type="text" name="contacto_persona_atiende" value="<?php echo $telefonoB ?>" placeholder="Ingrese Contacto Firma Inspectora" disabled>
        </div>
        <div class="inputs_r">
            <label>Oficina:</label>
            <?php
            include 'conexion/conexion.php';
            $consultaoficina = $mysqli->query("SELECT * FROM ter_oficinas WHERE id_tercero = '$id_cia_seguros'");
            $extraerDatosO = $consultaoficina->fetch_array(MYSQLI_ASSOC);
            $oficinaB = $extraerDatosO['nombre'];
            $idoficinaB = $extraerDatosO['identificador'];
            ?>
            <input class="ver" type="" name="oficina" value="<?php echo $oficinaB ?>" disabled>
            <input class="inp_med" type="" value="<?php echo $oficinaB ?>" disabled>
        </div>
        <div class="inputs_r">
            <label>Personal que asigna:</label>
            <input type="hidden" name="quienasigna" value="<?php echo $id_menu_p?>">
            <?php 
            $consultadatosuser = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador = '$id_menu_p'");
            $extraerDatosU = $consultadatosuser->fetch_array(MYSQLI_ASSOC);
            $nombre_usuario = $extraerDatosU['nombre'].''.$extraerDatosU['apellidos']; 
            ?>
            <input class="inp_med" name="nombreasigna" value="<?php echo $nombre_usuario?>" disabled>
        </div>
        <div class="inputs_r">
            <label>Número Contacto Asignador:</label>
            <input type="hidden" name="numeroasigna" value="<?php echo $numerocontacto?>">
            <input class="inp_med" type='text' value="<?php echo $numerocontacto ?>" placeholder="Ingrese numero contacto asignador"  disabled>
        </div>
        <div class="inputs_r">
            <label>Nombre Solicitante:</label>
            <input class="inp_med" type="text" name="" value="<?php echo ($solicitante) ?>" placeholder="Ingrese Solicitante" disabled>
            <input class="ver" type="text" name="nombreSolicitante" value="<?php echo ($solicitante) ?>" placeholder="Ingrese Solicitante">
        </div>
        <div class="inputs_r">
            <label>Tipo de Identificación Solicitante:</label>
            <?php
                $filtrodoc = $tipodocumento;
                $datadoc = $bloques->buscadoctipo($filtrodoc);
                $traedoc = $bloques->obtener_fila($datadoc);
                $documentoT = $traedoc['nombre'].'-'.$traedoc['id_alfanumerico'];
                $iddoc = $traedoc['identificador'];
                $selectdoc = $bloques->tipodocuselect($filtrodoc);
            ?>
       
            <select type="text"  id="contact" name="tipoDocumento" placeholder="Tipo Documento" disabled>
                <option value="">Seleccionar...</option>
                <?php
                while ($columna = $bloques->obtener_fila($selectdoc)) { 
                ?>
                    <option value="<?php echo $columna['identificador']; ?>"><?php echo ($columna['id_alfanumerico'] . ' -' . $columna['nombre']); ?> </option>
                <?php 
                } 
                $selectDocu = "selected";
                ?> 
                <option value="<?php echo $iddoc; ?> " <?php echo $selectDocu ?>><?php echo ($documentoT);?></option>
            </select>
        </div>
        <div class="inputs_r">
            <label>Número de Identificación Solicitante:</label>
            <input class="inp_med" type="text" value="<?php echo $identificacion?>" placeholder="Ingrese Numero Identificacion" disabled>
            <input class="ver" type="text" name="numeroIdentificacion" value="<?php echo $identificacion?>" placeholder="Ingrese Numero Identificacion" disabled>
        </div>
       
        <div class="inputs_r">
        <label for="name1">Pais de Ubicación principal:</label>
        <?php 
            $datapais = $bloques->buscapaises();
            echo '<select id="paises_id" class="" name="paises_id" disabled>';
            while ($c = $bloques->obtener_fila($datapais)) {
            //foreach ($countries as $c) : 
                if($paisid == $c['codigo'])
                {
                    echo " <option value=\"". $c['codigo'] ." \" selected>". $c['nombre'] ."</option>";    
                }
                else 
                {
                    echo "<option value=\"". $c['codigo']."\" > ".$c['nombre'] ."</option>";
                }
            }
//        endforeach; 
        ?>
            </select>
    </div>
        <div class="inputs_r">
      <label for="name1">Departamento de Ubicación principal:</label>
      <?php
        /*
        $consultaDepartamento = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$departamentoid' && codigo_pais = '$paisid'");
        $extraerDepartamento = $consultaDepartamento->fetch_array(MYSQLI_ASSOC);
        $departamento = $extraerDepartamento['nombre'];
        */
        $datadep = $bloques->buscadepartamentos($paisid);
        echo ' <select id="departamento_id" name="departamento_id" disabled> ';
        // foreach ($departamentos as $d) : 
        while($d = $bloques->obtener_fila($datadep)){
            if($departamentoid == $d['codigo']){
                echo " <option value=\"".$d['codigo']. "\" selected> ". $d['nombre'] ."</option>";    
            }
            else 
            {
                echo "<option value=\"". $d['codigo'] . "\" > ". $d['nombre'] . "</option>";
            }
        }
       // endforeach; 
    ?>
      </select>
    </div>
        <div class="inputs_r">
      <label for="name1">Ciudad de Ubicación principal:</label>
      <?php
      /*
            $consultaCiudad = $mysqli->query("SELECT * FROM rg_ciudades WHERE codigo = '$ciudadid' AND codigo_departamento = '$departamentoid' AND codigo_pais='$paisid'");
            $extraerCiudad = $consultaCiudad->fetch_array(MYSQLI_ASSOC);
            $ciudad = $extraerCiudad['nombre'];
            */
          $queryciud = $bloques->buscaciudades($paisid, $departamentoid);
          echo '<select id="ciudad_id" class="" name="ciudad_id">';
         
          
      //   foreach ($ciudades as $c) : 
         while($c = $bloques->obtener_fila($queryciud)){
             
              if($ciudadid == $c['codigo'])
              {
                echo " <option value=\"". $c['codigo'] ."\" selected> ". $c['nombre'] ." </option>";    
              }
              else 
              {
                echo "<option value=\"". $c['codigo'] ."\" > ". $c['nombre'] . "</option>";
              }
         }
   //     endforeach; 
?>

      </select>
    </div>
        <div class="inputs_r">
            <label>Dirección del Bien a Inspeccionar:</label>
            <input class="inp_med" type="text" name="direccion" placeholder="Ingrese Direccion" value="<?php echo $direccion ?>" required>
        </div>
        <div class="inputs_r">
            <label>Nombre Edificación:</label>
            <input class="inp_med" type="text" name="edificacion" placeholder="Ingrese Nombre Edificación" value="<?php echo $nombreedificacion?>"required>
        </div>
        <div class="inputs_r">
            <label>Nombre de la persona Quien Atiende la inspección:</label>
            <input class="inp_med" type="text" name="persona_atiende" value="<?php echo ($quienatiende) ?>" placeholder="Ingrese Persona que Atiende" required>
        </div>
        <div class="inputs_r">
            <label> Número de contacto de quien atenderá la inspección:</label>
            <input class="inp_med" type="text" name="contacto_persona_atiende" value="<?php echo $contacto_persona_atiende?>" placeholder="Ingrese Contacto Persona que Atiende" required>
        </div>
        
        <input class="ver" id="idCom" name="companiaSeguros" type="">
        <div class="inputs_r">
            <label>Lista De Bienes A Inspeccionar<?php  $lista_biene; ?>:</label>
            
            <?php
                
                $filtrobienes = $idbienes;
                $databien = $bloques->buscabienes($filtrobienes);
                $traebien = $bloques->obtener_fila($databien);
                $bienT = $traebien['nombre'];
                $idbien = $traebien['identificador'];
                $selectbien = $bloques->consultabiendif($filtrobienes);
                
            ?>
            <a class="btn_verde"  href="<?php echo 'regiones/'.utf8_encode($lista_biene)?>" target="_blank" onClick="javascript:document["ver-form"].submit();"><i class="fa fa-download"></i></a>
            <input type="text" class="inp_med" value="<?php echo $bienT ?>" disabled> 
            
            <?php
                    echo $ruta = $extraerDatos['lista_bienes'];
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
            <label>Posible Fecha Inspección: </label>
            <input class="inp_med" type='text'  value="<?php echo $fecha_inspe_fin ?> " max=""  disabled>
           
        </div>
        <div class="inputs_r">
            <label>Nombre del inspector:</label>
          <?php
          $id_menu_p;
          //$consultaB = $bloques->consultainspectorenc($firmainspectora);
          $consulta = $mysqli->query("SELECT * FROM sg_usuarios_x_cliente U ,sg_roles_x_usuario R,sg_usuarios C WHERE U.id_cliente='$firmainspectora' AND R.id_usuario = U.id_usuario AND R.id_rol IN (11,9) AND U.id_usuario = C.identificador");
          ?>
            <select type="text" id="contact" name="inspector" onkeyup="PasarValor();">
              <option value="">Seleccionar Inspector....</option>
              
                <?php 
                //while($extraerDatosB = $bloques->obtener_fila($consultaB)){
                while ($extraerDatosB = $consulta->fetch_array()) { ?>
                  <option value="<?php echo $extraerDatosB['identificador']; ?>"><?php echo utf8_encode($extraerDatosB['nombre'] . ' ' . $extraerDatosB['apellidos']); ?> </option>
            <?php } ?>
    
            <!-- <option value="0">No aplica</option>-->
    
          </select>
        </div>
        <div class="inputs_r">
          <label>Número Contacto Inspector: </label>
          <input class="inp_med" type='text' placeholder="Ingrese Número Contacto Inspector" name="contactoinspector" >
        </div>
        <div class="inputs_r">
            <label>Fecha Inspección:</label>
            <input class="inp_med" type='date' name='fechaInspeccion' value="<?php echo $fecha_inspe_fin ?> " max="" min="<?php echo $fechaFinal;?>" >
           
        </div>
        <div class="inputs_r">
            <button type="submit" class="btn_azul" value="Actualizar" name="editaencabezadofirmas">Actualizar</button>
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