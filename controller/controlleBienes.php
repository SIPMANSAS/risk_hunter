<?php
///Controlador bienes
include '../conexions.php';

if(isset($_POST['registrarBienes'])){
    $tipoBien = $_POST['tipoBien'];
    '<br>';
    $biencontenedor = $_POST['biencontenedor'];
    '<br>';echo 
    $descripcion = $_POST['descripcion'];
    '<br>';
    $observaciones = $_POST['observaciones'];
    '<br>';
    echo $id_inspeccion = $_POST['id_inspeccion'];
    
     
    $insertabienes = $mysqli->query("INSERT INTO enc_inmuebles (tipo_bien,id_bien_principal,descripcion,observaciones,id_encuesta) VALUES('$biencontenedor','$tipoBien','$descripcion','$observaciones','$id_inspeccion')");
    echo '<script language="javascript">alert("Bien Registrado Correctamente.");
    window.location.href="../crearbienes.php?id_inspeccion='.$id_inspeccion.'"</script>';
    
}

if(isset($_POST['asignabien'])){
    $id_bloque = $_POST['id_bloque'];
    $biencontenedor = $_POST['biencontenedor'];
    
    $asignabienbloque = $mysqli->query("UPDATE enc_bloque_preguntas SET id_bien='$biencontenedor' WHERE identificador='$id_bloque'");
    echo "<script>
    let isBoss = confirm('Riesgo Asociado Correctamente');
    window.close();
    </script>";
    /*
    echo '<script language="javascript">alert("Riesgo Asociado Correctamente.");
    window.location.href="../listarpreguntasrh.php</script>';
    echo "<script>window.close();</script>"; 
    */
}

if(isset($_POST['DesactivaRiesgo'])){
    $id_bloque = $_POST['id_bloque'];
    
    $desactivabloque=$mysqli->query("UPDATE enc_bloque_preguntas SET estado='0' WHERE identificador='$id_bloque'");
       echo '<script language="javascript">alert("Bloque desactivado correctamente.");
    window.location.href="../listarpreguntasrh.php"</script>';
}

if(isset($_POST['ActivaRiesgo'])){
    $id_bloque = $_POST['id'];
    
    $desactivabloque=$mysqli->query("UPDATE enc_bloque_preguntas SET estado='1' WHERE identificador='$id_bloque'");
       echo '<script language="javascript">alert("Bloque desactivado correctamente.");
    window.location.href="../listarpreguntasrh.php"</script>';
}

if(isset($_POST['asignaprioridad'])){
    $id_bloque = $_POST['id_bloque'];
    $prioridad = $_POST['prioridad'];
    $asignaprioridad = $mysqli->query("UPDATE enc_bloque_preguntas SET prioridad='$prioridad' WHERE identificador='$id_bloque'");
    echo "<script>
    let isBoss = confirm('Nivel de prioridad asignado correctamente');
    window.close();
    </script>";
}

if(isset($_POST['guardarBien'])){
   
    $fabricante = $_POST['fabricante'];
    $identificacion = $_POST['identificacion'];
    $afabricacion = $_POST['afabricacion'];
    $presion = $_POST['presion'];
    $nivel = $_POST['nivel'];
    $valor = $_POST['valor'];
    $id_inspeccion = $_POST['id_inspeccion'];
    $bloque_inspeccion = $_POST['bloque_inspeccion'];
    $id_detalle_inspeccion = $_POST['id_detalle_inspeccion'];
    
    for($i=0;$i<=count($fabricante);$i++){
        $fabricante[$i];
        '<br>';
        $identificacion[$i];
        '<br>';
        $afabricacion[$i];
        '<br>';
        $presion[$i];
        '<br>';
        $nivel[$i];
        '<br>';
        $valor[$i];
        '<br>';
        $id_inspeccion[$i];
        '<br>';
        $bloque_inspeccion[$i];
        '<br>';
        $id_detalle_inspeccion[$i];
        
        $eliminacionprevia = $mysqli->query("DELETE FROM enc_lista_bienes WHERE texto1=''");
        $insertaDatos = $mysqli->query("INSERT INTO enc_lista_bienes(texto1,texto2,texto3,texto4,valor_numerico,texto6,id_inspeccion,id_bloque_inspeccion,id_detalle_inspeccion)VALUES('$fabricante[$i]','$identificacion[$i]','$afabricacion[$i]','$presion[$i]','$nivel[$i]','$valor[$i]','$id_inspeccion[$i]','$bloque_inspeccion[$i]','$id_detalle_inspeccion[$i]')");
        $eliminacionprevia = $mysqli->query("DELETE FROM enc_lista_bienes WHERE texto1=''"); 
           echo "<script>
            if (confirm('Detalles Asignados correctamente') == true) {
                  window.close();  
            } 
        </script>";
    }
        
}

if(isset($_POST['capturaubicacion'])){
    echo 'INS'.$id_inspeccion = $_POST['id_inspeccion'];
    echo 'LO'.$longitud = $_POST['longitud'];
    echo 'LA'.$latitud = $_POST['latitud'];
    echo 'ESTR'.$estrato = $_POST['estrato'];
    echo 'Espacio'.$espacioGeografico = $_POST['espacioGeografico'];
    //echo "UPDATE enc_inspeccion SET longitud='$longitud',latitud='$latitud',estrato='$estrato',espacio_geografico='$espacioGeografico' WHERE identificador='$id_inspeccion'";
    $añadeubicacionbienes = $mysqli->query("UPDATE enc_inspeccion SET longitud='$longitud',latitud='$latitud',estrato='$estrato',espacio_geografico='$espacioGeografico' WHERE identificador='$id_inspeccion'");
    
    echo "<script>
            if (confirm('Ubicacion Almacenada correctamente') == true) {
                  window.close();  
            } 
        </script>";
   
}

if(isset($_POST['capturaubicacionfree'])){
    'INS-->'.$id_inspeccion = $_POST['id_inspeccion'];
    '<br>';
    'LO-->'.$longitud = $_POST['longitudB'];
     '<br>';
    'LA-->'.$latitud = $_POST['latitudB'];
     '<br>';
     'ESTR-->'.$estrato = $_POST['estratoB'];
     '<br>';
     'Espacio-->'.$espacioGeografico = $_POST['espacioGeografico'];
     '<br>';
     $usuario_id = $_POST['usuario_id'];
     
     $consultausuario = $mysqli->query("SELECT email FROM sg_usuarios WHERE identificador='$usuario_id'");
     $extraerdatos = $consultausuario->fetch_array(MYSQLI_ASSOC);
     $correousuario = $extraerdatos['email'];
     
     $consultainfoinspeccion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE identificador ='$id_inspeccion'");
     $extraerinfoinspeccion = $consultainfoinspeccion->fetch_array(MYSQLI_ASSOC);
     $numeroInspeccion = $extraerinfoinspeccion['numero_inspeccion'];
     
     $destinatario = $correousuario;//"juanrinconaxl926@gmail.com"; 
            $asunto = "Inspeccion Finalizada"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Inspeccion "'.$numeroInspeccion.'" finalizada</title> 
            </head> 
            <body> 
            <h1>Señor(a) '.$datosUsuario.',</h1> 
            <p> 
            Le informamos que en este momento se encuentra disponible el Informe de la inspección número  <b>'.$numeroInspeccion.'</b> ,asi que ya puede ingresar al aplicativo Risk Hunter Plus y consultar el resultado.<br><br>Agradecemos la confianza depositada en IES Consultores Group S.A.S. para la inspección de los bienes,  esperamos que el resultado sea para ustedes muy útil. <br><br>Para ingresar a RH+ siga la siguiente ruta https://https://desarrollosysolucionesingenieriles.com.co/risk_hunter/log.php
            </p> 
            </body> 
            </html> 
            '; 
            
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
            
            //dirección del remitente 
            $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <adminrh@rh.com>\r\n"; 
            
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            
            mail($destinatario,$asunto,$cuerpo,$headers);
     
     $fecha_terminacion = date('Y-m-d');

    $añadeubicacionbienes = $mysqli->query("UPDATE enc_inspeccion SET longitud='$longitud',latitud='$latitud',estrato='$estrato',espacio_geografico='$espacioGeografico' WHERE identificador='$id_inspeccion'");
    
    $insertainfoimagenes = $mysqli->query("INSERT INTO enc_imagenes_inspeccion(archivo,id_inspeccion,pie_de_imagen)
                                            SELECT D.archivos,D.id_inspeccion, concat('imagen de la pregunta ',P.nombre)
                                            FROM enc_detalles_inspeccion D, enc_preguntas P
                                            WHERE D.id_inspeccion = '$id_inspeccion' 
                                            AND (D.archivos LIKE '%.jpg%' 
                                            OR D.archivos LIKE '%.png%' 
                                            OR D.archivos LIKE '%.jpeg%')
                                            AND P.identificador = D.id_pregunta
                                            AND D.estado_imagenes = 0")or die(mysqli_error);
                                            
                                            
                                            
                                            /*echo "INSERT INTO enc_imagenes_inspeccion(archivo,id_inspeccion,pie_de_imagen)
                                            SELECT D.archivos,D.id_inspeccion, concat('imagen de la pregunta ',P.nombre)
                                            FROM enc_detalles_inspeccion D, enc_preguntas P
                                            WHERE D.id_inspeccion = '$id_inspeccion' 
                                            AND (D.archivos LIKE '%.jpg%' 
                                            OR D.archivos LIKE '%.png%' 
                                            OR D.archivos LIKE '%.jpeg%')
                                            AND P.identificador = D.id_pregunta
                                            AND D.estado_imagenes = 0";
    */
    
    
    
    $actualizacampoestadoimagenes = $mysqli->query("UPDATE enc_detalles_inspeccion 
                                                    SET estado_imagenes = 1 
                                                    WHERE id_inspeccion = '$id_inspeccion' 
                                                    AND (archivos LIKE '%.jpg%' 
                                                    OR archivos LIKE '%.png%' 
                                                    OR archivos LIKE '%.jpeg%')
                                                    AND estado_imagenes = 0");
                                                    
                                                  
    $actualizafechaterminacion = $mysqli->query("UPDATE enc_inspeccion SET fecha_terminacion='$fecha_terminacion' WHERE identificador = '$id_inspeccion'");
    
    $consultadatosinspeccioparainforme = $mysqli->query("SELECT * FROM enc_inspeccion WHERE identificador = '$id_inspeccion'");
    $extraerDatos = $consultadatosinspeccioparainforme->fetch_array(MYSQLI_ASSOC);
    $numerodeinspeccio = $extraerDatos['numero_inspeccion'];
    $fecha_solicitud = $extraerDatos['fecha_solicitud'];
    $id_cia_seguros = $extraerDatos['id_cia_seguros'];
    $solicitante = $extraerDatos['nombre_solicita'];
    
    
    
    ?>
    <script> 
                 window.onload=function(){
               
                  document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../reportefree.php" method="POST" onsubmit="procesar(this.action);" target="_blank" >
                      <input  type="hidden" value="<?php echo $id_inspeccion;  ?>" name="id_inspeccion">
                      <input  type="hidden" value="<?php echo $numerodeinspeccio;  ?>" name="numero_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['cia_seguros'];  ?>" name="cia_seguros">
                      <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fechasolicitud">
                      <input  type="hidden" value="<?php echo $id_cia_seguros;  ?>" name="id_cia_seguros">
                      <input  type="hidden" value="<?php echo $solicitante;  ?>" name="solicitante">
                      <input  type="hidden" value="<?php echo $_POST['tipodocumento'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo $_POST['identificacion'];  ?>" name="identificacion">
                      <input  type="hidden" value="<?php echo $_POST['tomador'];  ?>" name="tomador">
                      <input  type="hidden" value="<?php echo $_POST['asegurado'];  ?>" name="asegurado">
                      <input  type="hidden" value="<?php echo $_POST['nombreedificacion'];  ?>" name="nombreedificacion">
                      <input  type="hidden" value="<?php echo $_POST['nombrepersonaatiende'];  ?>" name="nombrepersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['contactopersonaatiende'];  ?>" name="contactopersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['firmainspectora'];  ?>" name="firmainspectora">
                      <input  type="hidden" value="<?php echo $_POST['pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $_POST['departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $_POST['ciudad'];  ?>" name="ciudad_id">
                      <input  type="hidden" value="<?php echo $fecha_solicitud;  ?>" name="fecha_inspeccion">
                      <input  type="hidden" value="<?php echo $numerodeinspeccio;  ?>" name="numero_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['direccion'];  ?>" name="direccion">
                      <input  type="hidden" value="<?php echo $_POST['id_oficina_cia_seguros'];  ?>" name="id_oficina_cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['nombre_persona_atiende'];  ?>" name="nombrepersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['contacto_persona_atiende'];  ?>" name="contacto_persona_atiende">
                      <input  type="hidden" value="<?php echo $_POST['id_inspector'];  ?>" name="id_inspector">
                      <input  type="hidden" value="<?php echo $_POST['inspector'];  ?>" name="inspector">
                      <input  type="hidden" value="<?php echo $_POST['telefono'];  ?>" name="telefono">
                      <input  type="hidden" value="<?php echo $_POST['nombreasigna'];  ?>" name="nombreasigna">
                      <input  type="hidden" value="<?php echo $_POST['telefonoasigna'];  ?>" name="telefonoasigna">
                      <input  type="hidden" value="<?php echo $_POST['idasigna'];  ?>" name="idasigna">
                      <input  type="hidden" value="<?php echo $_POST['fecha_posible_inspeccion'];  ?>" name="fecha_posible_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['lista_bienes'];  ?>" name="lista_bienes">
                      <input  type="hidden" value="<?php echo $_POST['bien_inspeccionar'];  ?>" name="bien_inspeccionar">
                      <input  type="hidden" value="<?php echo $_POST['longitudB'];  ?>" name="longitud">
                      <input  type="hidden" value="<?php echo $_POST['latitudB'];  ?>" name="latitud">
                      <input  type="hidden" value="<?php echo $_POST['espacioGeografico'];  ?>" name="espacio">
                      <input  type="hidden" value="<?php echo $_POST['estratoB'];  ?>" name="estrato">
                      
            </form>
    <?php
    
    echo '<script>
            if (confirm("La inspección Freemium ha finalizado con éxito, el informe de inspección '.$numerodeinspeccio.' se descargará automáticamente.") == true) {
                 window.open("../menu.php");
                 setTimeout("window.close()",300);
                 
            } 
        </script>';

   
}


if(isset($_POST['registradetallesbienes'])){
    'PREGUNTA'.$id_pregunta = $_POST['id_pregunta'];
    '<br>';
    'INSPECCION'.$id_inspeccion = $_POST['identificador_inspeccion'];
    '<br>';
    'BLQOUE'.$id_bloque = $_POST['id_bloque'];
    '<br>';
    'RESPuestA'.$id_respuesta = $_POST['id_respuesta'];
    '<br>';
    'DETALLE INSPECCION'.$id_det_inspeccion = $_POST['id_det_inspeccion'];
    '<br>';
    'DATO 1'.$dato1 = $_POST['dato1'];
    '<br>';
    'DATO 2'.$dato2 = $_POST['dato2'];
    '<br>';
    'DATO 3'.$dato3 = $_POST['dato3'];
    '<br>';
    'DATO 4'.$dato4 = $_POST['dato4'];
    '<br>';
    'DATO 5'.$dato5 = $_POST['dato5'];
    '<br>';
    'DATO 5'.$dato6 = $_POST['dato6'];
    '<br>';
    
    if($dato1 !=NULL || $dato2 !=NULL || $dato3 !=NULL || $dato4 !=NULL || $dato5 !=NULL || $dato6 !=NULL){
        $registradetallesbienes = $mysqli->query("INSERT INTO enc_lista_bienes (id_valor_respuesta,valor_numerico,texto1,texto2,texto3,texto4,texto5,texto6,id_inspeccion,id_bloque_inspeccion,id_detalle_inspeccion)VALUES('$id_respuesta','$dato2','$dato1','$dato3','$dato4','$dato5','$dato6','$dato2','$id_inspeccion','$id_bloque','$id_det_inspeccion')");
        
        echo '<script language="javascript">alert("Detalles Asignados correctamente.");
        window.location.href="../detallebienes.php?id_pregunta='.$id_pregunta.'&id_inspecion='.$id_inspeccion.'&bloque_inspeccion='.$id_bloque.'&idres='.$id_respuesta.'&consecutivo='.$id_det_inspeccion.'"</script>';
    }
    
}


?>