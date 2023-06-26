    <?php include 'sec_login.php'; ?>
    <!DOCTYPE html>
    <?php
        include  "clases/bloques.class.php";
    ?>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Firmas Inspectoras</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    </head>
    <body>
        <?php
        /*
            include "conexion/Conexion2.php";
            include_once  "clases/Json.class.php";
            $db =  connect();
            $query = $db->query("select * from rg_paises");
            $countries = array();
            while ($r = $query->fetch_object()) {
              $countries[] = $r;
            }*/
        ?>
       
        <?php include 'header-rh.php'; ?>
   
        <div class="titulo_p">
            <center><i class="fa-solid fa-user"></i> FIRMAS INSPECTORAS DESACTIVADAS</center>
        </div>
        
        <div class="link_int"><div class="titulo2"><i class="fa-solid fa-list"></i><a href="listafirmasinspectoras.php"> Listar Firmas Inspectoras Activas</a></div>
        <div class="titulo3"><i class="fa-solid fa-plus"></i><a href="registrofirmasinspectoras.php"> Crear Firma Inspectora</a></div></div>
    
          <div class="contenedor_titulos">
            <div class=" titulo">ID</div>
            <div class=" titulo"><b>Nombre Firma</b></div>
            <div class= "titulo"><b>NIT / CC</b></div>
            <div class=" titulo"><b>Numero de Contacto</b></div>
            <div class=" titulo"><b>E-mail</b></div>
             <div class=" titulo"><b>Dirección</b></div>
            <?php //<div class=" titulo"><b>Ubicación Principal</b></div>?>
            <div class=" titulo"><b>Acciones</b></div>
          </div>
    
          <?php
          
            $bloques    = new bloques;
            $consulta = $bloques->iniciarVariables();
            $consultafirmas = $bloques->consultafirmasinactivas();
          
            while ($extraerDatos =  $bloques->obtener_fila($consultafirmas)){
          ?>
            <div class="contenedor">
                <div class="campos_f">
                  <form action="verfirmasinspectoradesactivada.php" id="form" method="POST">
                      <input  type="hidden" value="<?php echo $extraerDatos['nombres'];  ?>" name="nombrefirma">
                      <input  type="hidden" value="<?php echo $extraerDatos['id_alfanumerico'];?>" name="tipdocletra"?>
                      <input  type="hidden" value="<?php echo $extraerDatos['vdom_tipo_identificacion'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo $extraerDatos['direccion'];  ?>" name="direccion">
                      <input  type="hidden" value="<?php echo $extraerDatos['telefono'];  ?>" name="telefono">
                      <input  type="hidden" value="<?php echo $extraerDatos['correo_electronico'];  ?>" name="correo_electronico">
                      <input  type="hidden" value="<?php echo $extraerDatos['numero_identificacion'];  ?>" name="numeroidentificacion">
                      <input  type="hidden" value="<?php echo $extraerDatos['pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $extraerDatos['departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $extraerDatos['ciudad'];  ?>" name="ciudad">
                      <div class="campos_list_u"><input type="submit"  class="btn_sel" name="ident" id="identificau" value="<?php echo $extraerDatos['identificacion'] ?>" ></div>
                      <input type="hidden" name="id" id="ident" value="<?php echo $extraerDatos['identificacion'] ?>">
                  </form>
                </div>
                <div class="campos_f">
                  <?php echo $extraerDatos['nombres']; ?>
                </div>
                <div class="campos_f">
                     <?php echo $extraerDatos['id_alfanumerico'].'-'.$extraerDatos['numero_identificacion']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['telefono']; ?>
                </div>
                <div class="campos_f">
                    <?php echo $extraerDatos['correo_electronico']; ?></div>

              <div class="campos_f">
                  <?php
                  //echo $extraerDatos['pais'].'-'.$extraerDatos['departamento'].'-'.$extraerDatos['ciudad'];
                  echo $extraerDatos['direccion'];
                  ?>
              </div>
                <div class="campos_f">
                  <form action="controller/controllerFirmas.php" method="POST">
                      <input type="hidden" value="<?php echo $extraerDatos['identificacion'];  ?>" name="id">
                      <button class="btn_verde" type="submit" name="activarfirmas">Activar</button>
                  </form>
               </div>
              </div>
            </div> 
              
            <?php

            }
              /*
              $ciudad = $extraerDatosFirmas['ciudad'];
              
              $departamentoid=$extraerDatosFirmas['departamento'];
              
              $pais=$extraerDatosFirmas['pais'];
              $consultaPais = $mysqli->query("SELECT * FROM rg_paises WHERE codigo = '$pais'");
              $paisEx = $consultaPais->fetch_array(MYSQLI_ASSOC);
              $paisid = $paisEx['nombre'];
              
              
              $consultaDep = $mysqli->query("SELECT * FROM rg_departamentos WHERE codigo = '$departamentoid' AND codigo_pais = '$pais'");
              $depEx = $consultaDep->fetch_array(MYSQLI_ASSOC);
              
              $consultaCiu = $mysqli->query("SELECT * FROM rg_ciudades WHERE codigo='$ciudad' AND codigo_pais='$pais'");
              $ciuEx = $consultaCiu->fetch_array(MYSQLI_ASSOC);
              
              echo '  <input type="hidden" id="identifu" name="identifu" value="d" >';
              echo '  <input type="hidden" id="idusuario" name="idusuario" >';

              ?>
                
            </div>   
          <?php
          }*/
          ?>
            </div>
            <div class="cont_fin"></div>
    <?php include 'footer.php'; ?>
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
    </script>
    </body>
    
    </html>