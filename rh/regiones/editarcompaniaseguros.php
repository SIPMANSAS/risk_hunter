<?php
include 'sec_login.php'; 
include  "clases/otrobloques.class.php";
//include "consultasbd.php";

$bloques = new otrobloques;
$bloques->iniciarVariables();

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compañia de Seguros</title>
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/totproyectos.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php include 'header-rh.php'; ?>
<div class="titulo_p"><i class="fa-solid fa-file-pen"></i> Editar Compañias de Seguros</div>
<div class="link_int">
	<div class="titulo2"><a href="listacompaniaseguros.php">+Listar Compañias de Seguros</a></div>
</div>
<div class="contenedor_titulos">
    <div class="titulo">Editar</div>
</div>
<div class="contenedor">
 <form class='registro' action="controller/controllerFirmas.php" method="POST">
        <?php
        
        $idFir = $_POST['idFirma'];
        $firma = $_POST['nombrefirma'];
        //Tipo
        $documento = $_POST['numeroidentificacion'];
        $direccion = $_POST['direccion'];
        $numeroContacto = $_POST['telefono'];
        $correoElectronico = $_POST['correo_electronico'];
        $departamentoid = $_POST['departamento'];
        $ciudadid = $_POST['ciudad'];
        $tipoDocumento = $_POST['tipodocumento']; 
        $paisid = $_POST['pais'];
     /* $datapais = $bloques->buscapaises();
      
        $countries = array();
        while ($r = $bloques->obtener_fila($datapais)) {
          $countries[] = $r;
        }
       */
        
        //$querydep = $db->query("select * from rg_departamentos WHERE codigo_pais = $paisid");
        
 /*       $datadep = $bloques->buscadepartamentos($paisid);       
        $departamentos = array();
        while($d = $bloques->obtener_fila($datadep)){
            $departamentos[] = $d;
        } */
        
        
        $queryciud = $bloques->buscaciudades($paisid, $departamentoid);
        $ciudades = array();
        while($c = $bloques->obtener_fila($queryciud)){
            $ciudades[] = $c;
        }
        
        ?>
        <input type='hidden' name='idFirma' value='<?php echo $idFir ?>' >
        
      <div class="inputs_r"><label>Nombre:</label>
        <input class="inp_med" type='text' name='nombreFirma' placeholder="Ingrese nombres" value='<?php echo $firma ?>' required>
      </div>   
      
    <div class="inputs_r"><label>Tipo de Documento:</label>
    <?php
    
      $filtrodoc = $tipoDocumento;
      $datadoc = $bloques->buscadoctipo($filtrodoc);
      $traedoc = $bloques->obtener_fila($datadoc);

      $documentoT = $traedoc['nombre'].'-'.$traedoc['id_alfanumerico'];
      $iddoc = $traedoc['identificador'];
      
      $selectdoc = $bloques->tipodocuselect($filtrodoc);
       ?>
       
       <select type="text"  id="contact" name="tipoDocumento" placeholder="Tipo Documento" required>
           <option value="">Seleccionar...</option>
           <?php

           while ($columna = $bloques->obtener_fila($selectdoc)) { 
           ?>
           <option value="<?php echo $columna['identificador']; ?>"><?php echo utf8_encode($columna['id_alfanumerico'] . ' -' . $columna['nombre']); ?> </option>
          <?php 
           } 
            $selectDocu = "selected";
            ?> 
            <option value="<?php echo $iddoc; ?> " <?php echo ($selectDocu) ?>><?php echo utf8_encode($documentoT);?></option>
            <?php
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
     
         
<?php 
       $datapais = $bloques->buscapaises();

       echo '<select id="paises_id" class="" name="paises_id">';
       
        while ($c = $bloques->obtener_fila($datapais)) {
    
 //        foreach ($countries as $c) : 
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
      <label for="name1">Departamento de Ubicación principal</label>
      <?php
      /*
            $consultaDepartamento = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$departamentoid' && codigo_pais = '$paisid'");
            $extraerDepartamento = $consultaDepartamento->fetch_array(MYSQLI_ASSOC);
            $departamento = $extraerDepartamento['nombre'];
*/
     
      $datadep = $bloques->buscadepartamentos($paisid);
      echo ' <select id="departamento_id" name="departamento_id"> ';
        
     
        // foreach ($departamentos as $d) : 
         while($d = $bloques->obtener_fila($datadep)){
             
              if($departamentoid == $d['codigo'])
              {
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
      <label for="name1">Ciudad de Ubicación principal</label>
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
      <input type='submit' class="btn_azul" name="editarcompaniaseguros" value="Editar">
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