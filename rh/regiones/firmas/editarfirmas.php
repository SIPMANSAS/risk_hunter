<?php
include '../sec_login.php'; 
include "conexion/Conexion2.php";
//include "consultasbd.php";



?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Firmas Inspectoras</title>
    <link rel="stylesheet" href="../css/regiones.css">
    <link rel="stylesheet" href="../css/totproyectos.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php include '../header-rh.php'; ?>
<div class="titulo_p"><i class="fa-solid fa-file-pen"></i> Editar Firmas Inspectoras</div>
<div class="link_int">
	<div class="titulo2"><a href="../firmas/listafirmasinspectoras.php">+Listar Firmas Inspectoras</a></div>
</div>
<div class="contenedor_titulos">
    <div class="titulo">Editar</div>
</div>
<div class="contenedor">
 <form class='registro' action="controller/controllerFirmas.php" method="POST">
        <?php
        
        require_once 'conexion/conexion.php';
        $idFir = $_POST['idFirma'];
        $ConsultaDatos = $mysqli->query("SELECT * FROM ter_terceros F JOIN rg_paises P ON F.pais = P.codigo JOIN rg_departamentos D ON F.departamento = D.codigo JOIN rg_ciudades C ON F.ciudad = C.codigo WHERE F.estado=1 AND F.tipoCliente=0 AND vdom_tipo_tercero='774' AND identificacion = '$idFir'");
        $extraerDataCliente = $ConsultaDatos->fetch_array(MYSQLI_ASSOC);
        $id = $extraerDataCliente['id'];
        $firma = $extraerDataCliente['nombres'];
        $tipoDocumento = $extraerDataCliente['vdom_tipo_identificacion'];
        $documento = $extraerDataCliente['numero_identificacion'];
        $direccion = $extraerDataCliente['direccion'];
        $numeroContacto = $extraerDataCliente['telefono'];
        $correoElectronico = $extraerDataCliente['correo_electronico'];
        $paisid = $extraerDataCliente['pais'];
        $departamentoid = $extraerDataCliente['departamento'];
        $ciudadid = $extraerDataCliente['ciudad'];
        $cliente = $extraerDataCliente['id_tercero'];
        
        
        
        $db =  connect();
        $acentos = $db->query("SET NAMES 'utf8'");
        $query = $db->query("select * from rg_paises");
        $countries = array();
        while ($r = $query->fetch_object()) {
          $countries[] = $r;
        }
        
        $querydep = $db->query("select * from rg_departamentos WHERE codigo_pais = $paisid");
        $departamento = array();
        while($d = $querydep->fetch_object()){
            $departamentos[] = $d;
        }
        
        
        
        $queryciud = $db->query("select * from rg_ciudades WHERE codigo_pais = $paisid AND codigo_departamento=$departamentoid");
        $ciudad = array();
        while($c = $queryciud->fetch_object()){
            $ciudades[] = $c;
        }
        
        ?>
        <input type='hidden' name='idFirma' value='<?php echo $idFir ?>' >
        
      <div class="inputs_r"><label>Nombre:</label>
        <input class="inp_med" type='text' name='nombreFirma' placeholder="Ingrese nombres" value='<?php echo $firma ?>' required>
      </div>   
      
    <div class="inputs_r"><label>Tipo de Documento:</label>
      <?php
      
      $tipDocu = $mysqli->query("SELECT id_alfanumerico,nombre,identificador FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND identificador = '$tipoDocumento'");
      $query = "SELECT identificador, id_alfanumerico, nombre FROM cg_valores_dominio cvd WHERE cvd.id_dominio = 18 AND identificador <> $tipoDocumento ";
      $resultado = $mysqli->query($query);
       ?>
       
       <select type="text"  id="contact" name="tipoDocumento" placeholder="Tipo Documento" required>
           <option value="">Seleccionar...</option>
           <?php
           $resultado = $mysqli->query($query);
           while ($columna = mysqli_fetch_array($resultado)) { 
           ?>
           <option value="<?php echo $columna['identificador']; ?>"><?php echo utf8_encode($columna['id_alfanumerico'] . ' -' . $columna['nombre']); ?> </option>
          <?php 
           } 
           while($columna = mysqli_fetch_array($tipDocu)){
               $selectDocu = "selected";
            ?> 
            <option value="<?php echo $columna['identificador']; ?> " <?php echo $selectDocu ?>><?php echo $columna['id_alfanumerico'].'-'.utf8_encode($columna['nombre']);?></option>
            <?php
           }
           ?>
       </select>
       </div>
      <div class="inputs_r">
        <label>Numero de Identificación</label>
        <input type="number" class="inp_med" name="numeroIdentificacion" value='<?php echo $documento ?>' placeholder="Ingrese Numero Identificacion" required>
      </div>
      <div class="inputs_r">
        <label>Dirección</label>
        <input type="text" class="inp_med" name="direccion" value='<?php echo $direccion ?>' placeholder="Ingrese Direccion" required>
      </div>
      <div class="inputs_r">
        <label>Numero telefonico de Contacto</label>
        <input class="inp_med" type="text" name="telefono" value='<?php echo $numeroContacto ?>' placeholder="Ingrese Telefono" required>    
      </div>
      <div class="inputs_r">
        <label>Correo Electronico de Contacto</label>
        <input class="inp_med" type='email' value='<?php echo $correoElectronico ?>' name="correoElectronico" placeholder="Ingrese correo electronico" required>
      </div>
      <div class="inputs_r">
      <label for="name1">Pais de Ubicación principal</label>
     
      <select id="paises_id" class="" name="paises_id">
        
<?php 
         foreach ($countries as $c) : 
              if($paisid == $c->codigo)
              {
                echo " <option value=\"$c->codigo\" selected> $c->nombre </option>";    
              }
              else 
              {
                echo "<option value=\"$c->codigo\" > $c->nombre </option>";
              }
        endforeach; 
?>
        </select>
    </div>
      <div class="inputs_r">
      <label for="name1">Departamento de Ubicación principal</label>
      <?php
      
            $consultaDepartamento = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$departamentoid' && codigo_pais = '$paisid'");
            $extraerDepartamento = $consultaDepartamento->fetch_array(MYSQLI_ASSOC);
            $departamento = $extraerDepartamento['nombre'];
            
        
          ?>
      <select id="departamento_id" name="departamento_id">
        
      
      
      
      <?php 
         foreach ($departamentos as $d) : 
              if($departamentoid == $d->codigo)
              {
                echo " <option value=\"$d->codigo\" selected> $d->nombre </option>";    
              }
              else 
              {
                echo "<option value=\"$d->codigo\" > $d->nombre </option>";
              }
        endforeach; 
?>
      </select>
    </div>
      <div class="inputs_r">
      <label for="name1">Ciudad de Ubicación principal</label>
      <?php
            $consultaCiudad = $mysqli->query("SELECT * FROM rg_ciudades WHERE codigo = '$ciudadid' AND codigo_departamento = '$departamentoid' AND codigo_pais='$paisid'");
            $extraerCiudad = $consultaCiudad->fetch_array(MYSQLI_ASSOC);
            $ciudad = $extraerCiudad['nombre'];
          ?>
      <select id="ciudad_id" class="" name="ciudad_id">
        <option value=""><?php echo utf8_encode($ciudad) ?></option>
        
        <?php 
         foreach ($ciudades as $c) : 
              if($ciudadid == $c->codigo)
              {
                echo " <option value=\"$c->codigo\" selected> $c->nombre </option>";    
              }
              else 
              {
                echo "<option value=\"$c->codigo\" > $c->nombre </option>";
              }
        endforeach; 
?>
        
        
        
      </select>
    </div>
    <?php
    
    /*
     <div class="inputs_r"><label>SELECCION CLIENTE:</label>
      <?php
      
      $tipoClie = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion = '$cliente' AND vdom_tipo_tercero = 772");
      
      $query = "SELECT * FROM ter_terceros WHERE identificacion <> '$cliente' AND vdom_tipo_tercero = 772 ";
      $resultado = $mysqli->query($query);
       ?>
       
       <select type="text"  id="contact" name="tipoCliente" required>
           <option value="">Seleccionar...</option>
           <?php
           $resultado = $mysqli->query($query);
           while ($columna = mysqli_fetch_array($resultado)) { 
           ?>
           <option value="<?php echo $columna['identificacion']; ?>"><?php echo $columna['numero_identificacion'].' - '.utf8_encode($columna['nombres']); ?> </option>
          <?php 
           } 
           while($columna = mysqli_fetch_array($tipoClie)){
               $selectDocu = "selected";
            ?> 
            <option value="<?php echo $columna['identificador']; ?> " <?php echo $selectDocu ?>><?php echo $columna['numero_identificacion'].' - '.utf8_encode($columna['nombres']);?></option>
            <?php
           }
           ?>
       </select>
       </div>
        */
?>
    <div class="inputs_r">
      <input type='submit' class="btn_azul" name="editarFirmas" value="Editar">
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
      /* Referencia a los atributos data de la opci贸n seleccionada */
      var mData = mOption.dataset;

      /* Referencia a los input */
      var elId = document.getElementById('id');
      var elNombre = document.getElementById('nombre');

      /* Asignamos cada dato a su input*/
      elId.value = this.value;
      elNombre.value = mOption.text; /*Se usar谩 el valor que se muestra*/
    };
  </script>

</div>
<div class="cont_fin"></div>	

<?php include 'footer.php'; ?>	
</body>
</html>