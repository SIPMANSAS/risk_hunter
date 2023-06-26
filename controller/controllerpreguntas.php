<link href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>

<?php

include '../conexion/conexion.php';

if(isset($_POST['registrapregunta'])){
    $id_pregunta_padre = $_POST['id_pregunta_padre'];
    $id_bloque = $_POST['id_bloque'];
    $codigo = $_POST['codigo'];
    $fecha_efectiva = $_POST['fecha_efectiva'];
    $nombrebloque = $_POST['nombrebloque'];
    $tipo_res = $_POST['tipo_res'];
    $resp_cierre = $_POST['resp_cierre'];
    $resp_act_riesgo = $_POST['resp_act_riesgo'];
    $tipo_respuesta = $_POST['tipo_respuesta'];
    $textoresp = $_POST['textoresp'];
    $texto_ayuda = $_POST['textoayuda'];
    
    $consultaultimo = $mysqli->query("SELECT MAX(identificador)+1 AS Maximo FROM enc_preguntas");
    $extraerUltimo = $consultaultimo->fetch_array(MYSQLI_ASSOC);
    $ultimo = $extraerUltimo['Maximo'];
    
    $codigoF = $codigo.'.'.$ultimo;
    $nombrebloqueB = $codigoF.' '.$nombrebloque;
    
    $insertaregistros = $mysqli->query("INSERT INTO enc_preguntas(identificador,nombre,tipo_estado,estado,fecha_efectiva,id_pregunta_padre,id_valor_res_cierre,id_bloque_preguntas,id_valor_resp_activa_riesgo,id_respuesta,codigo,id_tipo_informe,texto_informe,ayuda)VALUES('$ultimo','$nombrebloqueB','17','1','$fecha_efectiva','$id_pregunta_padre','$resp_cierre','$id_bloque','$resp_act_riesgo','$tipo_res','$codigoF','$tipo_respuesta','$textoresp','$texto_ayuda')");
    
    echo "<script>
            if (confirm('Pregunta almacenada correctamente') == true) {
                  window.close();  
            } 
        </script>";
}

if(isset($_POST['editarpregunta'])){
    $nombrebloque = $_POST['nombrebloque'];
    $tipo_res = $_POST['tipo_res'];
    $resp_cierre = $_POST['resp_cierre'];
    $resp_act_riesgo = $_POST['resp_act_riesgo'];
    $tipo_respuesta = $_POST['tipo_respuesta'];
    $textoresp = $_POST['textoresp'];
    $estadopregunta = $_POST['estadopregunta'];
    $id_pregunta_padre = $_POST['id_pregunta_padre'];
    $textoayuda = $_POST['textoayuda'];
    
    $actualizapregunta = $mysqli->query("UPDATE enc_preguntas SET nombre='$nombrebloque',id_respuesta='$tipo_res',id_valor_res_cierre='$resp_cierre',id_valor_resp_activa_riesgo='$resp_act_riesgo',id_tipo_informe='$tipo_respuesta',texto_informe='$textoresp',estado='$estadopregunta',ayuda='$textoayuda' WHERE identificador='$id_pregunta_padre'");
    
    "UPDATE enc_preguntas SET nombre='$nombrebloque',id_respuesta='$tipo_res',id_valor_res_cierre='$resp_cierre',id_valor_resp_activa_riesgo='$resp_act_riesgo',id_tipo_informe='$tipo_respuesta',texto_informe='$textoresp',estado='$estadopregunta' WHERE identificador='$id_pregunta_padre'";
    
     echo "<script>
            if (confirm('Pregunta actualizada correctamente') == true) {
                  window.close();  
            } 
        </script>";
    
}

if(isset($_POST['guardarriesgos'])){
    $id_pregunta = $_POST['id_pregunta'];
    $estado = $_POST['estado'];
    $texto = $_POST['texto'];
    $riesgo = $_POST['riesgo'];
    $fecha = $_POST['fecha'];
    
    for($i=0;$i<=count($id_pregunta);$i++){
        $id_pregunta[$i];
        '<br>';
        $estado[$i];
        echo '<br>';
        $texto[$i];
        '<br>';
        $riesgo[$i];
        echo '<br>';
        $fecha[$i];
        
        $insertaDatos = $mysqli->query("INSERT INTO enc_riesgo_a_activar(id_riesgo,id_pregunta,texto_informe,fecha_activa)VALUES('$riesgo[$i]','$id_pregunta[$i]','$texto[$i]','$fecha[$i]')");
        $eliminabasura = $mysqli->query("DELETE FROM enc_riesgo_a_activar WHERE id_riesgo = 0");
        echo '<script language="javascript">alert("Detalle Asignados correctamente.");window.location.href="../asignarriesgos.php?id_pregunta='.$id_pregunta[$i].'"</script>';
    }
    
}

if(isset($_POST['guardarregistrofotos'])){
    $inspeccion = $_POST['inspeccion'];
    //$file_pie_pagina = $_FILES['file']['file_pie_pagina'];
    $texto_pie = $_POST['texto_pie'];
    //$file_pie_pagina = $_POST['file_pie_pagina'];
    //$conteo = count($_FILES["file"]["name"]);
    //$directorio = 'archivos/';
    
    
   
    
    
   //for($i=0;$i<$conteo;$i++){	
    for ($i = 0; $i<count($_FILES["foto"]["name"]);$i++){
        if(!empty($_FILES)){

    	    //Validamos que el archivo exista
    		if($_FILES["foto"]["name"]) {
    		    
    		    $filename = $_FILES["foto"]["name"][$i]; //Obtenemos el nombre original del archivo
    			$source = $_FILES["foto"]["tmp_name"][$i]; //Obtenemos un nombre temporal del archivo
    			
    			$directorio = '../archivos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
    			
    			//Validamos si la ruta de destino existe, en caso de no existir la creamos
    			if(!file_exists($directorio)){
    				mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
    			}
    			$filename = str_replace(' ', '',$filename);
    			$dir=opendir($directorio); //Abrimos el directorio de destino
    			$target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
    			
    			//Movemos y validamos que el archivo se haya cargado correctamente
    			//El primer campo es el origen y el segundo el destino
    			if(move_uploaded_file($source, $target_path)) {	
    				
    				$ruta = "../archivos/"."$filename"; 
    				//$ruta =$filename; 
    			    
    			}
    		}
        }
       
       //"INSERT INTO enc_imagenes_inspeccion(id_inspeccion,pie_de_pagina,archivo)VALUES('$inspeccion[$i]','$texto_pie[$i]','$fileTmpPath[$i]')";
       $inspeccion[$i];
       $texto_pie[$i];
       
       $insertapie = $mysqli->query("INSERT INTO enc_imagenes_inspeccion(id_inspeccion,pie_de_imagen,archivo)VALUES('$inspeccion[$i]','$texto_pie[$i]','$ruta')");
        echo "<script>
            if (confirm('Riesgo actualizado correctamente') == true) {
                  window.close();  
            } 
        </script>";
   }
}

if(isset($_POST['actualizarriesgo'])){

    $id_riesgo = $_POST['id_riesgo'];
    $estado = $_POST['estado'];
    $texo_riesgo = $_POST['texo_riesgo'];
    $id_pregunta = $_POST['id_pregunta'];
    
    $actualizariesgo = $mysqli->query("UPDATE enc_riesgo_a_activar SET estado='$estado',texto_informe='$texo_riesgo' WHERE id_riesgo='$id_riesgo' AND id_pregunta='$id_pregunta'");
    echo "<script>
            if (confirm('Riesgo actualizado correctamente') == true) {
                  window.close();  
            } 
        </script>";
}

if(isset($_POST['agregarcolumnas'])){
    'Id pregunta'.$identificador_pregunta = $_POST['identificador_pregunta'];
    'Texto Col'.$nombreColumna = $_POST['nombreColumna'];
    
    $consultaId = $mysqli->query("SELECT MAX(identificador) AS Maximo FROM enc_columnas_bienes");
    $extaerData= $consultaId->fetch_array(MYSQLI_ASSOC);
    $idextraido = $extaerData['Maximo'];
    $nuevoid = $idextraido+1;
    $insertacolumnas = $mysqli->query("INSERT INTO enc_columnas_bienes (identificador,nombre,id_pregunta)VALUES('$nuevoid','$nombreColumna','$identificador_pregunta')");
    
    echo "<script>
            if (confirm('Columna registrada correctamente') == true) {
                  window.close();  
            } 
        </script>";
}

if(isset($_POST['terminar'])){
    $id_inspeccion = $_POST['id_inspeccion'] or $_GET['id_inspeccion'] ;
    '<br>';
    $bloque_inspeccion = $_POST['bloque_inspeccion'];
    '<br>';
    

    
    $consultaprevia = $mysqli->query("SELECT * FROM enc_inspeccion WHERE identificador = '$id_inspeccion'");
    $extraerDatosE = $consultaprevia->fetch_array(MYSQLI_ASSOC);
    $fechaextrae = $extraerDatosE['fecha_terminacion'];
    $numeroInspeccion = $extraerDatosE['numero_inspeccion'];
    $id_usuario = $_POST['id_usuario'];
    $consultausuario = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador = '$id_usuario'");
    $extraerDatos = $consultausuario->fetch_array(MYSQLI_ASSOC);
    $correo_usuario = $extraerDatos['email'];
    $datosUsuario = $extraerDatos['nombre'].' '.$extraerDatos['apellidos'];
    $solicitante = $extraerDatosE['nombre_solicita'];
    $identificacion_solicita = $extraerDatosE['nid_solicita'];
    
    if($fechaextrae == NULL){
        date_default_timezone_set('America/Bogota');
        'FECHA INS';
        $fecha_actual = date('Y-m-d H:i:s');
        $actualizafecha = $mysqli->query("UPDATE enc_inspeccion SET usuario_actualizacion='$id_usuario',fecha_terminacion = '$fecha_actual' WHERE identificador = '$id_inspeccion'");
        
            $destinatario = $correo_usuario;//"juanrinconaxl926@gmail.com"; 
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
        
        /*echo "<script>
            if (confirm('Inspección Finalizada') == true) {
                   
                   window.open('../capturarubicacionB?<?php  ?>.php');
                   window.close();
            } 
        </script>";*/
        ?>
        <script> 
            window.onload=function(){
                alert("Por último, para Generar el Informe, compártenos el Estrato y el Espacio geográfico del inmueble que estás inspeccionando");
                window.close();
                document.forms["miformulario"].submit();
            }
        </script>
             
            <form name="miformulario" action="../capturarubicacionB.php" method="POST" onsubmit="procesar(this.action);" target="_blank" >
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
        
    }else{
        date_default_timezone_set('America/Bogota');
        'FECHA ACT';
        $fecha_actual = date('Y-m-d H:i:s');
        $actualizafecha = $mysqli->query("UPDATE enc_inspeccion SET usuario_actualizacion='$id_usuario',fecha_actualizacion = '$fecha_actual' WHERE identificador = '$id_inspeccion'");
        
            $destinatario = $correo_usuario;//"juanrinconaxl926@gmail.com"; 
            $asunto = "Inspeccion Finalizada"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Inspeccion "'.$numeroInspeccion.'" finalizada</title> 
            </head> 
            <body> 
            <h1>Señor(a) '.$datosUsuario.',</h1> 
            <p> 
            Le informamos que en este momento se encuentra disponible el Informe de la inspección número  <b>'.$numeroInspeccion.'</b>,asi que ya puede ingresar al aplicativo Risk Hunter Plus y consultar el resultado.<br><br>Agradecemos la confianza depositada en IES Consultores Group S.A.S. para la inspección de los bienes,  esperamos que el resultado sea para ustedes muy útil. <br><br>Para ingresar a RH+ siga la siguiente ruta https://https://desarrollosysolucionesingenieriles.com.co/risk_hunter/log.php
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
         echo "<script>
            if (confirm('Inspección Actualizada') == true) {
                  window.open('../capturarubicacionB.php');
            } 
        </script>";
        ?>
        <script> 
            window.onload=function(){
                window.close();
                document.forms["miformulario"].submit();
            }
        </script>
             
            <form name="miformulario" action="../menu.php" method="POST" onsubmit="procesar(this.action);" target="_blank" >
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
    }
    
}


?>