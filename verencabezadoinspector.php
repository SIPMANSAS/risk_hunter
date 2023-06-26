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
  <title>Editar Encabezado Inspector</title>
 <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/regiones.css">
  <link rel="stylesheet" href="css/totproyectos.css">
</head>

<body>
  <?php include 'header-rh.php';?>
  <?php $id_menu_p?>
  <div class="titulo_p"><i class="fa-solid fa-file-pen"></i> EDITAR ENCABEZADO INSPECTOR</div>
  <div class="link_int">
      <div class="titulo2">  <a href="listarencabezadoinspector.php">+Listar Encabezados</a></div>
    </div>
    <div class="contenedor_titulos">
      <div class="titulo"> Información sobre la inspección</div>
    </div>
  <div class="contenedor">
  <form class="registro" action="controller/controllerencabezado.php" method="POST" enctype="multipart/form-data">  
  <?php
  
        $id_cia_seguros = $_POST['id_cia_seguros'];
        $pais = $_POST['pais'];
        $departamento = $_POST['departamento'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        $nombreedificacion = $_POST['nombreedificacion'];
        $nombrepersonaatiende = $_POST['nombrepersonaatiende'];
        $contactopersonaatiende = $_POST['contactopersonaatiende'];
        $fecha_posible_inspeccion = $_POST['fecha_posible_inspeccion'];
        $fecha_inspeccion = $_POST['fecha_inspeccion'];
        $firmainspectora = $_POST['firmainspectora'];
        $id_inspector = $_POST['id_inspector'];
        $id_oficina_cia_seguros = $_POST['id_oficina_cia_seguros'];
        $identificador = $_POST['identificador'];
        $numero_inspeccion = $_POST['numero_inspeccion'];
        $cia_seguros = $_POST['cia_seguros'];
        $inspector = $_POST['inspector'];
        $telefono = $_POST['telefono'];
        $nombreasigna = $_POST['nombreasigna'];
        $telefonoasigna = $_POST['telefonoasigna'];
        $idasigna = $_POST['idasigna'];
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
            <input class="ver" name='fechaSolicitud' value="<?php echo $fecha ?>" min="<?php echo $fecha ?>">
            <input  type="" class="ver" value="<?php echo $identificador;  ?>" name="identificador">
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
            <input class="inp_med" type="text" value="<?php echo $numero_inspeccion ?>" disabled>
            <input class="ver" type="text" name="numeroInspeccion" placeholder="Ingrese Numero Inspección" value="<?php echo $numero_inspeccion ?>" required>
        </div>
         <div class="inputs_r">
            <label>Firma Inspectora:</label>
            <?php
                $filtrofirma = $firmainspectora;
                $datafirma = $bloques->buscafirmasinspectoras($filtrofirma);
                $traefirma = $bloques->obtener_fila($datafirma);
                
                $firmaT = $traefirma['numero_identificacion'].'-'.$traefirma['nombres'];
                $idfirma = $traefirma['identificacion'];
                
                $selectfirma = $bloques->consultafirmasactivasselect();
            ?>
            <select type="text" id="contact" name="firmainspectora" onkeyup="PasarValor();" disabled>
                <option value="">Seleccionar....</option>
                <?php 
                
                while ($columna = $bloques->obtener_fila($selectfirma)) { ?>
                    <option value="<?php echo $columna['identificacion']; ?>"><?php echo $columna['numero_identificacion'] . ' -' . $columna['nombres']; ?> </option>
                <?php } 
                    $selectFirmaI = "selected";
                ?>
                <option value="<?php echo $idfirma; ?> " <?php echo ($selectFirmaI) ?>><?php echo utf8_encode($firmaT);?></option>
            </select>
        </div>
        
        <div class="inputs_r">
            <?php
            include 'conexion/conexion.php';
            $consulta = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion='$firmainspectora'");
            $extraerdatos = $consulta->fetch_array(MYSQLI_ASSOC);
            $telefonofirma = $extraerdatos['telefono'];
            ?>
            <label> Número de contacto de la firma inspectora:</label>
            <input class="inp_med" type="text" name="contacto_firma_inspectora" value="<?php echo $telefonofirma?>" placeholder="Ingrese Contacto Persona que Atiende" disabled>
            
        </div>
        <div class="inputs_r">
            <label>Oficina:</label>
             <input class="inp_med" type="" name="oficina" value="<?php echo $id_oficina_cia_seguros?>" disabled>
        </div>
        
        <div class="inputs_r">
            <label>Nombre de quien asigna la inspección:</label>
            <input type="hidden" name="quienasigna" value="<?php echo $idasigna?>">
            <input class="inp_med" name="nombreasigna" value="<?php echo $nombreasigna?>" disabled>
        </div>
        <?php
        /*
        <div class="inputs_r">
            <label>Compañia de Seguros:</label>
            <input class="inp_med" type="" name="companiaseguros" value="<?php echo $cia_seguros?>" disabled>
        </div>
        */
        ?>
        
        <div class="inputs_r">
            <label>Número Contacto de quien asigna la inspección:</label>
            <input type="hidden" name="numeroasigna" value="<?php echo $telefonoasigna?>">
            <input class="inp_med" type='text' value="<?php echo $telefonoasigna ?>" placeholder="Ingrese numero contacto asignador"  disabled>
        </div>
        <div class="inputs_r">
             <label for="name1">Pais donde se realizará la inspección</label>
            <?php 
            $datapais = $bloques->buscapaises();
            echo '<select id="paises_id" class="" name="paises_id" disabled> ';
            while ($c = $bloques->obtener_fila($datapais)) {
 //         foreach ($countries as $c) : 
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
        <label for="name1">Departamento donde se realizará la inspección</label>
      <?php
      /*
            $consultaDepartamento = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$departamentoid' && codigo_pais = '$paisid'");
            $extraerDepartamento = $consultaDepartamento->fetch_array(MYSQLI_ASSOC);
            $departamento = $extraerDepartamento['nombre'];
*/
     
      $datadep = $bloques->buscadepartamentos($pais);
      echo ' <select id="departamento_id" name="departamento_id" disabled>';
        
     
        // foreach ($departamentos as $d) : 
         while($d = $bloques->obtener_fila($datadep)){
             
              if($departamento == $d['codigo'])
              {
                echo " <option value=\"".$d['codigo']. "\" selected> ". utf8_encode($d['nombre']) ."</option>";    
              }
              else 
              {
                echo "<option value=\"". $d['codigo'] . "\" > ". utf8_encode($d['nombre']) . "</option>";
              }
         }
       // endforeach; 
?>
      </select>
    </div>
        <div class="inputs_r">
      <label for="name1">Ciudad donde se realizará la inspección</label>
      <?php
      /*
            $consultaCiudad = $mysqli->query("SELECT * FROM rg_ciudades WHERE codigo = '$ciudadid' AND codigo_departamento = '$departamentoid' AND codigo_pais='$paisid'");
            $extraerCiudad = $consultaCiudad->fetch_array(MYSQLI_ASSOC);
            $ciudad = $extraerCiudad['nombre'];
            */
          $queryciud = $bloques->buscaciudades($pais, $departamento);
          echo '<select id="ciudad_id" class="" name="ciudad_id">';
         
          
      //   foreach ($ciudades as $c) : 
         while($c = $bloques->obtener_fila($queryciud)){
             
              if($ciudad == $c['codigo'])
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
            <label>Dirección del Bien a inspecciónar:</label>
            <input class="inp_med" type="text" name="direccion" value="<?php echo $direccion ?>" placeholder="Ingrese Direccion" required>
        </div>
        <div class="inputs_r">
            <label>Nombre Edificación (Propiedad Horizontal):</label>
            <input class="inp_med" type="text" name="edificacion" placeholder="Ingrese Nombre Edificación" value="<?php echo $nombreedificacion?>" required>
        </div>
        <div class="inputs_r">
            <label>Nombre de la persona Quien Atenderá la inspección:</label>
            <input class="inp_med" type="text" name="persona_atiende" placeholder="Ingrese Persona que Atiende" value="<?php echo $nombrepersonaatiende ?>"<required>
        </div>
        <div class="inputs_r">
            <label> Número de contacto de quien atenderá la inspección:</label>
            <input class="inp_med" type="text" name="contacto_persona_atiende" placeholder="Ingrese Contacto Firma Inspectora" value="<?php echo $contactopersonaatiende ?>" required>
        </div>
       
        
        <div class="inputs_r">
            <label>Lista de Bienes A Inspeccionar:</label>
            <div class="campos_f">
                    <?php
                    echo $ruta = $extraerDatos['lista_bienes'];
                    ?>
                  <a class="btn_verde"  href="<?php echo 'regiones/'.utf8_encode($ruta)?>" target="_blank" onClick="javascript:document["ver-form"].submit();"><i class="fa fa-download"></i></a>
                </div>
            <select type="text" id="contact" name="biene" onkeyup="PasarValor();" disabled>
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
            <input class="inp_med" type='date' name='fechaposibleInspeccion' max="" min="<?php echo $fechaFinal;?>" value="<?php echo $fecha_inspeccion?>" disabled>
        </div>
        <div class="inputs_r">
            <label>Nombre del inspector asignado:</label>
            <?php
            /*
                $filtroinsp=$id_inspector;
                $datainspector = $bloques->inspectorasignado($filtroinsp);
                $traeinsp = $bloques->obtener_fila($datainspector);
                
                echo $inspectorT = '-'.$traeinsp['nombres'].'-'.$traeinsp['apellidos'];
                echo $idinspector = $traeinsp['identificador'];
            ?>
            <?php
                $consultausuarioxrolinspectores = $bloques->consultausuarioxrolinspectores();
            ?>
            <select type="text" id="contact" name="inspectorasignado" onkeyup="PasarValor();">
                <option value="">Seleccionar....</option>
                <?php
                while($columnai = $bloques->obtener_fila($consultausuarioxrolinspectores)){
                ?>
            <option value="<?php echo $columnai['identificador'];?>"><?php echo $columnai['num_identificacion'].' - '.$columnai['nombres'].' '.$columnai['apellidos'];?></option>
            <?php
            }
            $selectInspector = "selected";
            ?>
            <option value="<?php echo $idinspector; ?> " <?php echo ($selectInspector) ?>><?php echo utf8_encode($inspectorT);?></option>
            </select>
            <?php
            */
            ?>
            <input class="inp_med" type="text" name="inspector" value="<?php echo $inspector?>" placeholder="Ingrese Contacto Inspector" disabled>
        </div>
        <div class="inputs_r">
            <label> Número de contacto del Inspector:</label>
            <input class="inp_med" type="text" name="contacto_inspector" placeholder="Ingrese Contacto Inspector" value="<?php echo $telefono?>" disabled>
        </div>
        <div class="inputs_r">
       <label>Fecha Inspección:</label>
            <input class="inp_med" type='date' name='fechaInspeccion' max="" min="<?php echo $fechaFinal;?>"   required>
        </div>
        <div class="inputs_r">
      <input class="btn_azul" type='submit' name="editarencabezadoinspector" value="Guardar">
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