<?php include "sec_login.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
      <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
   <?php include'header-rh.php';?>
   <div class="titulo_p">Menu Principal</div>
   <?php
   if($version_usuario == 1){
        //echo $texto_version = "Version Premium";
    }else{
        //echo $texto_version = "Version Free";
    ?>
    <div class="link_int">
        <div>
            <form action="PruebaTextDevp" method="POST">
                <?php
                
                $año = date('Y');
                
                $consultamaximofreemium = $mysqli->query("SELECT IFNULL(MAX(consecutivo),0) AS Ultimo FROM enc_inspeccion WHERE id_usuario='$id_usuario_ext'");
                $extraerDatos = $consultamaximofreemium->fetch_array(MYSQLI_ASSOC);
                $ultimomaximofreemium = $extraerDatos['Ultimo']+1;
                $consecutivocodigofreemium = 'FR-'.$año.'-'.$ultimomaximofreemium;
                
                
                $consultamaximo = $mysqli->query("SELECT IFNULL(MAX(identificador),0) AS Ultimo FROM enc_inspeccion");
                $extraerDatos = $consultamaximo->fetch_array(MYSQLI_ASSOC);
                $ultimomaximo= $extraerDatos['Ultimo']+1;
                
                $consecutivocodigofreemium = 'FR-'.$año.'-'.$ultimomaximofreemium;

                $consultaexistencia = $mysqli->query("SELECT COUNT(1) AS existe FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ext' AND origen LIKE '%FR%' ");
                $extraerexistencia = $consultaexistencia->fetch_array(MYSQLI_ASSOC);
                $existedatos = $extraerexistencia['existe'];
                
                $consultaexistenciafechaterminacion = $mysqli->query("SELECT COUNT(*) AS existe_fecha FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ext' AND fecha_terminacion IS NOT NULL AND origen LIKE '%FR%'");
                
                $extraerexistenciafecha = $consultaexistenciafechaterminacion->fetch_array(MYSQLI_ASSOC);
                $existefecha = $extraerexistenciafecha['existe_fecha'];
                
                
                if($existedatos == 0 || $existefecha == 1){
                    //$insertaencabezadofreemium = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,estado,nombre_edificacion,origen,numero_inspeccion,nombre_solicita)VALUES('$id_usuario_ext','$fecha_solicitud','1','Edificacion Freemium','FR','$consecutivocodigofreemium','$usaurionombresolicitante')");
                }else{
                   //echo "NO INSERTA";
                }
                ?>
                
                    <form action="PruebaTextDevp" method="POST">
                        <input type="hidden" name="id_encuesta" value="<?php echo $ultimomaximo-1?>">
                        <input type="hidden" name="id_bloque" value="1">
                        <input type="hidden" name="id_pregunta" value="1">
                        <input type="hidden" name="usuario_id" value=<?php echo $id_usuario_ext?>>
                        <input type="hidden" name="tipo_proceso" value="FR">
                        <!---<button type="submit"><i class="fa-solid fa-search"></i>&nbsp;Encuesta Freemium</button>-->
                    </form>
            </form>
        </div>
        <!--<div class="titulo3">
            <form action="capturarubicacionB.php" method="POST">
                <input type="hidden" name="id_encuesta" value="<?php echo $ultimomaximo?>">
                <input type="hidden" name="id_bloque" value="1">
                <input type="hidden" name="id_pregunta" value="1">
                <input type="hidden" name="usuario_id" value=<?php echo $id_usuario_ext?>>
                <input type="hidden" name="tipo_proceso" value="FR">
                <button type="submit" name="generarinformeFR"><i class="fa-solid fa-download"></i>&nbsp;Generar Informe</button>
            </form>
        </div>-->
    </div>
    <?php
    }
   ?>
   <div class="contenedor_titulos">
       <div class="titulo">Funciones del Aplicativo</div>
   </div>
   
   <div class="contenedor_front">
    <div class="front">
        <div><img src="img/logorh.png" alt=""></div>
        <div>
            <p>Ah ingresado al aplicativo web Risk Hunter Plus (RH+), una metodologia simple de evaluación por puntos, que identifica riesgos y los valora con base en el contexto de una persona,organización o empresa <br> <br> En este aplicativo podrá cargar fotografías, archivos, que le ayuden a soportar los informes descargables,sus respuestas,sus conclusiones, así como valorar los riesgos identificados, de manera automática y en tiempo real.</p>
        </div>
    </div>
    
    <div class="menu_secundario" style="display:none;">        
            
    </div>
   </div>
   <div class="cont_fin"></div>
    <?php include'footer.php';    ?>
</body>
</html>   