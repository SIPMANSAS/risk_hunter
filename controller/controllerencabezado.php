<?php
///controller desde local a servidor prueba B
include '../conexion/conexion.php';

if(isset($_POST['registraencabezado'])){
    
    for($i=4; $i <= 19;$i++){
        $idpregunta = $_POST['idpregunta'];
        count($idpregunta);
        $id_inspeccion = $i;
        $consecutivo = $i;
        $campoTexto = "campoTexto".$i ;//$_POST['campoTexto-']
         echo '<br>';
        //$idpregunta++;
     //   'Campo Texto'.$campoTexto = "campotexto-".$idpregunta.$i;
        $campoTexto2 = $_POST[$campoTexto];//$_POST[$campoTexto]
        $idrespuesta = $_POST[''];
        $tipofecha = $_POST['tipofecha'];
        $tiposelect = $_POST['repuesta_texto'];
        $tipocheck = $_POST['tipocheck'];
        $codigo = $_POST['select'];
      //  "campotexto-".$i;
        //$_POST['campoTexto-1'];
        
        //$insertaregistro = $mysqli->query("INSERT INTO enc_detalles_inspeccion(id_inspeccion,consecutivo,id_pregunta,id_respuesta,respuesta_texto,id_respuesta_concat)VALUES('$id_inspeccion','$consecutivo','$idpregunta','$codigo','$campoTexto2','0')");
        //echo '<script>alert("Encabezado Registrado Exitosamente")
        //window.location.href="../crearencabezado.php"</script>';
    }
}

/////////////////////////////////////////////////////////INICIA REGISTRO ENCABEZADO COMPANIAS //////////////////////////////////////////////////
if(isset($_POST['registraencabezadocompania'])){
    $usuario = $_POST['usuario'];
    $fechaSolicitud = $_POST['fechaSolicitud'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    $origen  = 'CA';
    $companiaSeguros = $_POST['companiaseguros'];
    $oficina = $_POST['oficina'];
    $quienasigna = $_POST['quienasigna'];
    $numeroasigna = $_POST['numeroasigna'];
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDoc'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tomador = $_POST['tomador'];
    $asegurado = $_POST['asegurado'];
    $paises_id = $_POST['pais'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $edificacion=$_POST['edificacion'];
    $persona_atiende=$_POST['persona_atiende'];
    $contacto_persona_atiende=$_POST['contacto_persona_atiende'];
    $firma_inspectora=$_POST['firma'];
    $contacto_firma_inspectora = $_POST['telefonofirma'];
    $biene = $_POST['biene'];
    $fechaInspeccion=$_POST['fechaInspeccion'];
    //$tipo = $_POST['tipo'];
    $email = $_POST['email'];
    $estado = 1;
    $ultimo = $_POST['ultimo'];
    $nusuario = $_POST['nusuario'];
    $companiasegurosn = $_POST['companiasegurosn'];
    
    settype($ultimo);
    settype($contacto_firma_inspectora);
    
    $archivo = $_POST['archivo'];
    
    'ORIGINAL '.$archivoNombre = ($_FILES['archivo']['name']);
    '<br>';
    'SIN ESPACIOS '.$nuevacadena = str_replace(' ', '', $archivoNombre);
    $guardado = trim($_FILES['archivo']['tmp_name'],'');
    
    $dir_subida = '../archivos';
    $fichero_subido = $dir_subida.'/'.basename($nuevacadena);
    
    move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);

    
    //print "</pre>";
    $consultadatosfirmas = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion='$firma_inspectora'");
    $extraerDatos = $consultadatosfirmas->fetch_array(MYSQLI_ASSOC);
    $correoelectronico = $extraerDatos['correo_electronico'];
    
    /*for ($i=0;$i<=count($bien);$i++){
         $bien[$i];
        '<br>';
    }*/
    if($firma_inspectora == NULL){
        //echo 'Entra A';
            $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,descripcion,numero_inspeccion,id_cia_seguros,id_oficina_cia_seguros,nombre_solicita,tid_solicita,nid_solicita,tomador,asegurado,id_pais,id_departamento,id_ciudad,direccion,nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,lista_bienes,fecha_posible_inspeccion,id_inspector,origen,consecutivo,contacto_firma)
                          VALUES('$usuario','$fechaSolicitud','$descripcion','$numeroInspeccion','$companiaSeguros','$oficina','$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$tomador','$asegurado','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion','$persona_atiende','$contacto_persona_atiende','$biene','$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion','$tipo','$origen','$ultimo','$contacto_firma_inspectora')");
        
            $destinatario = $email;//"juanrinconaxl926@gmail.com"; 
            $asunto = "Falta informacion de la inspección.$numeroInspeccion"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Falta informacion de la inspeccion "'.$numeroInspeccion.'"</title> 
            </head> 
            <body> 
            <h1>Señor(a) '.$nusuario.',</h1> 
            <p> 
            A la inspección número <b>'.$numeroInspeccion.'</b> le hacen falta datos para que pueda ser realizada, por favor ingrese al aplicativo Risk Hunter Plus y diligencie la información correspondiente.<br><br>Saludos cordiales, equipo RH+.<br><br>Para ingresar a RH+ siga la siguiente ruta https://rh1.capitalhorus.com/log.php
            </p> 
            </body> 
            </html> 
            '; 
            
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            
            
            //dirección del remitente 
            $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <adminrh@rh.com>\r\n"; 
            
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            
            mail($destinatario,$asunto,$cuerpo,$headers);
        
            echo '<script>alert("Encabezado Compañia de Seguros Registrado Exitosamente")
            window.location.href="../crearencabezadocompaniaaseguradora.php"</script>';
            }else{
                $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,numero_inspeccion,id_cia_seguros,id_oficina_cia_seguros,nombre_solicita,tid_solicita,nid_solicita,tomador,asegurado,id_pais,id_departamento,id_ciudad,direccion,nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,lista_bienes,fecha_posible_inspeccion,id_inspector,origen,consecutivo,contacto_firma)
                                            VALUES('$usuario','$fechaSolicitud','$numeroInspeccion','$companiaSeguros','$oficina','$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$tomador','$asegurado','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion','$persona_atiende','$contacto_persona_atiende','$biene','$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion','$tipo','$origen','$ultimo','$contacto_firma_inspectora')");
                
            $consultanombreF = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion='$firma_inspectora'");
            $extraernombre = $consultanombreF->fetch_array(MYSQLI_ASSOC);
            $nombreF = $extraernombre['nombres'];
                  
            $destinatario = /*$email;*/"juanrinconaxl926@gmail.com"; 
            $asunto = "Asignación inspección .$numeroInspeccion"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Asignación inspección  "'.$numeroInspeccion.'"</title> 
            </head> 
            <body> 
            <h1>Señores '.$nombreF.',</h1> 
            <p> 
            '.$companiasegurosn.' le ha asignado la inspección número  <b>'.$numeroInspeccion.'</b> por favor ingrese al aplicativo Risk Hunter Plus y continúe con el proceso, asignando un inspector de su firma y, si es posible, poniendose en contacto con &bnsp;' .$quienasigna. '  al numero '.$contacto_persona_atiende.', para coordinar la Fecha de inspección. .<br><br>Saludos cordiales, equipo RH+.<br><br>Para ingresar a RH+ siga la siguiente ruta https://rh1.capitalhorus.com/log.php
            </p> 
            </body> 
            </html> 
            '; 
            
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            
            //dirección del remitente 
            $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <adminrh@rh.com>\r\n"; 
            
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            
            mail($destinatario,$asunto,$cuerpo,$headers);
                
                
            echo '<script>alert("La información ha sido guardada correctamente")
            window.location.href="../crearencabezadocompaniaaseguradora.php"</script>';
            
        }
    }

//////////////////////////////////////////////////////////END REGISTRO ENCABEZADO COMPANIAS ///////////////////////////////////////////////////

//////////////////////////////////////////////////////////INICIA REGISTRO ENCABEZADO FIRMAS ////////////////////////////////////////////////////
if(isset($_POST['registraencabezadofirma'])){
    $tipo = $_POST['tipo'];
    $emailusuario  = $_POST['email'];
    $usuario = $_POST['usuario'];
    $fechaSolicitud = $_POST['fechaSolicitud'];
    $firma_inspectora=$_POST['firmainspectora'];
    $contacto_firma_inspectora = $_POST['contacto_firma_inspectora'];
    $oficina = $_POST['id_oficina'];
    $idquienasigna = $_POST['quienasigna'];
    $numeroasigna = $_POST['numeroasigna'];
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDoc'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    'PA'.$paises_id = $_POST['paises_id'];
    'DEP'.$departamento_id = $_POST['departamento_id'];
     'CIUD'.$ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $edificacion=$_POST['edificacion'];
    $persona_atiende=$_POST['persona_atiende'];
    $contacto_persona_atiende=$_POST['contacto_persona_atiende'];
    $biene = $_POST['biene'];
    $archivo = $_POST['archivo'];
    $inspectorasignado = $_POST['inspectorasignado'];
    $contacto_inspector = $_POST['contacto_inspector'];
    $fechaInspeccion=$_POST['fechaInspeccion'];
    $estado = 2;
    $numeroConsecutivo = $_POST['numeroConsecutivo'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    '<br>';
    
    if($tipo == '775'){
        //echo 'ENTRA 775';
        $consulta = $mysqli->query("SELECT IFNULL (MAX(consecutivo),0)+1 AS Ultimo FROM enc_inspeccion WHERE origen='FI' AND YEAR(fecha_solicitud)=YEAR(NOW())");
        $extraerUltomoB = $consulta->fetch_array(MYSQLI_ASSOC);
        $extraerUltomo = $extraerUltomoB['Ultimo'];
        $date=date("Y");
        $consecutoFinal = 'FI'.'-'.$date.'-'.$extraerUltomo;
        
        $archivoNombre = $_FILES['archivo']['name'];
        $guardado = utf8_encode($_FILES['archivo']['tmp_name']);
    
        $dir_subida = '../archivos';
        $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
            "El fichero es válido y se subió con éxito.\n";
        } else {
            "¡Posible ataque de subida de ficheros!\n";
        }
           $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,  descripcion ,numero_inspeccion,  nombre_solicita,      tid_solicita,   nid_solicita,           id_pais, id_departamento,   id_ciudad,   direccion,   nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,   id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,  lista_bienes,     fecha_posible_inspeccion, id_inspector,       consecutivo,    origen,id_oficina_cia_seguros,contacto_firma)VALUES('$usuario','$fechaSolicitud','$estado'   ,'$numeroInspeccion',             '$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion',    '$persona_atiende',    '$contacto_persona_atiende','$biene','$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion',        '$inspectorasignado','$extraerUltomo','FI','$oficina','$contacto_inspector')");
           

           $consultnombresinspector = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador = '$inspectorasignado'");
           $extraerDatos = $consultnombresinspector->fetch_array(MYSQLI_ASSOC);
           $nombreDatosUsuarioInspector = $extraerDatos['nombre'].' '.$extraerDatos['apellidos'];
           
           $consultafirmainspectora = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion = '$firma_inspectora'");
           $extraerDatosFirmaInspectora = $consultafirmainspectora->fetch_array(MYSQLI_ASSOC);
           $nombreFirmaInspectora = $extraerDatosFirmaInspectora['nombres'];

            //echo '<script>alert("La información ha sido guardada correctamente")
                  //window.location.href="../crearencabezadofirmainspectora.php"</script>';
   
            $destinatario = $emailusuario;
            $from = 'Administracion de Gestion de Riesgos Risk Hunter';
            $asunto = 'Asignación inspección '.$numeroInspeccion;
            $datossaludo = "<html>
            <head>
            <title>Asignación inspección  '.$numeroInspeccion</title>
            </head>
            <body>
            <h1>Señor(a) ". $nombreDatosUsuarioInspector."</h1><br>";
            $mensajedelink = "<br> Ingrese a la plataforma por este link: https://desarrollosysolucionesingenieriles.com.co/risk_hunter/log.php";
            $saludo = "Saludos Cordiales  <br>";
            $texto = $nombreFirmaInspectora.' le ha asignado la inspección número '.$numeroInspeccion.' , por favor ingrese al aplicativo  Risk Hunter Plus y y continúe con el proceso de inspección, poniéndose en contacto con &bnsp ' .$persona_atiende. ' al numero '.$contacto_persona_atiende .',para coordinar y  diligenciar la Fecha de inspección.<br>Le deseamos muchos éxitos con la inspección.<br> 
            <br>Saludos cordiales, equipo RH+.';
            $cuerpo = $datossaludo.$texto.$mensajedelink.'<br>'.$saludo."</body></html>";
    
            //para el env�o en formato HTML
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            
    
            //direcci�n del remitente
            
            mail($destinatario,$asunto,$cuerpo,$headers) ;
   
   
        echo '<script>alert("La información ha sido guardada correctamente")
              window.location.href="../crearencabezadofirmainspectora.php"</script>';
        }
        
        if($tipo == '776'){
        echo 'Entra a 776';
        $consulta = $mysqli->query("SELECT IFNULL (MAX(consecutivo),0)+1 AS Ultimo FROM enc_inspeccion WHERE origen='IN' AND YEAR(fecha_solicitud)=YEAR(NOW())");
        $extraerDato = $consulta->fetch_array(MYSQLI_ASSOC);
        $extraerUltomo = $extraerDato['Ultimo'];
        $date=date("Y");
        $consecutoFinal = 'IN'.'-'.$date.'-'.$extraerUltomo;
        
        $archivoNombre = $_FILES['archivo']['name'];
        $guardado = utf8_encode($_FILES['archivo']['tmp_name']);
    
        $dir_subida = '../archivos';
        $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
            "El fichero es válido y se subió con éxito.\n";
        }else{
            "¡Posible ataque de subida de ficheros!\n";
        }
        
            $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,  descripcion ,numero_inspeccion,   id_oficina_cia_seguros, nombre_solicita,      tid_solicita,   nid_solicita,           id_pais, id_departamento,   id_ciudad,   direccion,   nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,   id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,  lista_bienes,     fecha_posible_inspeccion, id_inspector, contacto_firma,      consecutivo,    origen)
                                                              VALUES('$usuario','$fechaSolicitud','$estado'   ,'$numeroInspeccion', '$oficina',             '$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion',    '$persona_atiende',    '$contacto_persona_atiende','$biene',              '$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion',        '$inspectorasignado','$contacto_inspector','$extraerUltomo','IN')");
            echo '<script>alert("Encabezado Firma Inspectora Registrado Exitosamente")
            window.location.href="../crearencabezadofirmainspectora.php"</script>';
            
            $destinatario = $email;
                $asunto = 'Asignación inspección '.$numeroInspeccion;
                $datossaludo = "<html>
                <head>
            <title>Asignación inspección  '.$numeroInspeccion</title>
            </head>
            <body>
            <h1>Senor(a) ". $inspectorasignado."</h1><br>";
            $mensajedelink = "<br> Ingrese a la plataforma por este link: ";
            $saludo = "Saludos Cordiales  <br>";
            $texto = $firma_inspectora.'le ha asignado la inspección número'.$numeroInspeccion.' , por favor ingrese al aplicativo  Risk Hunter Plus y y continúe con el proceso de inspección, poniéndose en contacto con &bnsp' .$contacto_persona_atiende. 'al numero'.$contacto_firma_inspectora.',para coordinar y  diligenciar la Fecha de inspección.<br>Le deseamos muchos éxitos con la inspección. 
            <br>Saludos cordiales, equipo RH+.';
            $cuerpo = $datossaludo.$texto.$mensajedelink.$saludo."</body></html>";
            
            //para el env�o en formato HTML
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            
            //direcci�n del remitente
            
            mail($destinatario,$asunto,$cuerpo,$headers) ;
   
   
          echo '<script>alert("La información ha sido guardada correctamente")
              window.location.href="../crearencabezadocompaniaaseguradora.php"</script>';
   
        }
    }
//////////////////////////////////////////////////////////END REGISTRO ENCABEZADO FIRMAS //////////////////////////////////////////////////////

/////////////////////////////////////////////////////////INICIA EDITA ENCABEZADO COMPANIAS ///////////////////////////////////////////////////
if(isset($_POST['editaencabezadocompania'])){
    $emailusuario  = $_POST['email'];
    $identificador = $_POST['identificador'];
    $usuario = $_POST['usuario'];
    $fechaSolicitud = $_POST['fechaSolicitud'];
    $oficina = $_POST['oficina'];
    $descripcion = $_POST['descripcion'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    $companiaSeguros = $_POST['companiaseguros'];
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tomador = $_POST['tomador'];
    $asegurado = $_POST['asegurado'];
    $pais = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $edificacion=$_POST['edificacion'];
    $persona_atiende=$_POST['persona_atiende'];
    $contacto_persona_atiende=$_POST['contacto_persona_atiende'];
    $firma_inspectora=$_POST['firma'];
    $contacto_firma_inspectora = $_POST['telefonofirma'];
    //$fechaInspeccion=$_POST['fechaInspeccion'];
    $archivo = $_POST['archivo'];
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    $tipo = $_POST['tipo'];
    
    $dir_subida = '../archivos';
    $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
        "El fichero es válido y se subió con éxito.\n";
    } else {
        "¡Posible ataque de subida de ficheros!\n";
    }
    
    $destinatario = $emailusuario;
                $asunto = 'Asignación inspección '.$numeroInspeccion;
                $datossaludo = "<html>
                <head>
            <title>Asignación inspección  '.$numeroInspeccion</title>
            </head>
            <body>
            <h1>Senor(a) ". $inspectorasignado."</h1><br>";
            $mensajedelink = "<br> Ingrese a la plataforma por este link: ";
            $saludo = "Saludos Cordiales  <br>";
            $texto = $firma_inspectora.'le ha asignado la inspección número'.$numeroInspeccion.' , por favor ingrese al aplicativo  Risk Hunter Plus y y continúe con el proceso de inspección, poniéndose en contacto con &bnsp' .$contacto_persona_atiende. 'al numero'.$contacto_firma_inspectora.',para coordinar y  diligenciar la Fecha de inspección.<br>Le deseamos muchos éxitos con la inspección. 
            <br>Saludos cordiales, equipo RH+.';
            $cuerpo = $datossaludo.$texto.$mensajedelink.$saludo."</body></html>";
            
            //para el env�o en formato HTML
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            
            
            //direcci�n del remitente
            
            mail($destinatario,$asunto,$cuerpo,$headers) ;
   
   
    $actualizaReg = $mysqli->query("UPDATE enc_inspeccion SET id_usuario='$usuario',fecha_solicitud='$fechaSolicitud',descripcion='$descripcion',
    nombre_solicita='$nombreSolicitante',tid_solicita='$tipodocumento',nid_solicita='$numeroIdentificacion',tomador='$tomador',asegurado='$asegurado',
    id_pais='$pais',id_departamento='$departamento_id',id_ciudad='$ciudad_id',direccion='$direccion',nombre_edificacion='$edificacion',nombre_persona_atiende='$persona_atiende',
    contacto_persona_atiende='$contacto_persona_atiende',id_firma_inspectora='$firma_inspectora',contacto_firma='$contacto_firma_inspectora',lista_bienes='$fichero_subido' ,descripcion='1' WHERE identificador='$identificador'");
     echo '<script>alert("La información ha sido actualizada correctamente")
   window.location.href="../listarencabezadocompaniaseguros.php"</script>';
   
}
//////////////////////////////////////////////////////////END EDITA ENCABEZADO COMPANIAS ////////////////////////////////////////////////////

/////////////////////////////////////////////////////////INICIA EDITA ENCABEZADO FIRMAS //////////////////////////////////////////////////
if(isset($_POST['editaencabezadofirmas'])){
    $identificador = $_POST['identificador'];
    $usuario = $_POST['usuario'];
    $fechaSolicitud = $_POST['fechaSolicitud'];
    $oficina = $_POST['oficina'];
    $descripcion = $_POST['descripcion'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    'CIA'.$companiaSeguros = $_POST['companiaseguros'];
    echo '<br>';
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tomador = $_POST['tomador'];
    $asegurado = $_POST['asegurado'];
    $pais = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $edificacion=$_POST['edificacion'];
    $persona_atiende=$_POST['persona_atiende'];
    $contacto_persona_atiende=$_POST['contacto_persona_atiende'];
    'F'.$firma_inspectora=$_POST['idfirma'];
    '<bR>';
    //$fechaInspeccion=$_POST['fechaInspeccion'];
    $archivo = $_POST['archivo'];
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    $tipo = $_POST['tipo'];
    ////Variables para asignar insp //////
    $inspector = $_POST['inspector'];
    $contactoinspector = $_POST['contactoinspector'];
    $fechaInspeccion = $_POST['fechaInspeccion'];
    $inspeccionSerial = $_POST['inspeccionSerial'];
    
    /////END/////
    
    $dir_subida = '../archivos';
    $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
        "El fichero es válido y se subió con éxito.\n";
    } else {
        "¡Posible ataque de subida de ficheros!\n";
    }
    
    $consultaparacorreo = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador ='$inspector'");
    $extraerDatos = $consultaparacorreo->fetch_array(MYSQLI_ASSOC);
    $correinspector = $extraerDatos['email'];
    $datos_inspecctor = $extraerDatos['nombre'];
    $consultadatosfirma = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion = '$firma_inspectora'");
    $extarerDatosFirmas = $consultadatosfirma->fetch_array(MYSQLI_ASSOC);
    $firmainspectoraname = $extarerDatosFirmas['nombres'];
    $destinatario = $correinspector;//"juanrinconaxl926@gmail.com"; 
            $asunto = "Asignacion Inspección.$inspeccionSerial"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Asignacion Inspeccion "'.$inspeccionSerial.'"</title> 
            </head> 
            <body> 
            <h1>Señor(a) '.$datos_inspecctor.',</h1> 
            <p> 
           <b>'.$firmainspectoraname.'</b> le ha asignado la inspección '.$inspeccionSerial.' , por favor ingrese al aplicativo Risk Hunter Plus y continúe con el proceso de inspección, poniéndose en contacto con &bnsp'.$nombreSolicitante.' al numero '.$contactoinspector.' para coordinar y diligenciar la fecha de inspeccion <br><br>Saludos cordiales, equipo RH+.<br><br>Para ingresar a RH+ siga la siguiente ruta https://desarrollosysolucionesingenieriles.com.co/risk_hunter/log.php
            </p> 
            </body> 
            </html> 
            '; 
            
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            
            
            //dirección del remitente 
            $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <adminrh@rh.com>\r\n"; 
            
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            
            mail($destinatario,$asunto,$cuerpo,$headers);
        
            $actualizaReg = $mysqli->query("UPDATE enc_inspeccion SET id_usuario='$usuario',descripcion='$descripcion',tomador='$tomador',asegurado='$asegurado',
            id_ciudad='$ciudad_id',direccion='$direccion',nombre_edificacion='$edificacion',nombre_persona_atiende='$persona_atiende',
           lista_bienes='$fichero_subido' ,estado=3,descripcion='2',id_inspector='$inspector',fecha_inspeccion='$fechaInspeccion' WHERE identificador='$identificador'");
             echo '<script>alert("La información ha sido actualizada correctamente")
           window.location.href="../listarencabezadofirmas.php"</script>';
   //id_firma_inspectora='$firma_inspectora',
   
   
   
}
//////////////////////////////////////////////////////////END EDITA ENCABEZADO FIRMAS ////////////////////////////////////////////////////

//////////////////////////////////////////////////////////INICIA REGISTRO ENCABEZADO INSPECTOR ///////////////////////////////////////////////////
if(isset($_POST['registraencabezadoinspcetor'])){
    $identificador = $_POST['identificador'];
    $usuario = $_POST['usuario'];
    $fechaSolicitud = $_POST['fechaSolicitud'];
    $oficina = $_POST['oficina'];
    $descripcion = $_POST['descripcion'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    $companiaSeguros = $_POST['companiaseguros'];
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tomador = $_POST['tomador'];
    $asegurado = $_POST['asegurado'];
    $pais = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $edificacion=$_POST['edificacion'];
    $persona_atiende=$_POST['persona_atiende'];
    $contacto_persona_atiende=$_POST['contacto_persona_atiende'];
    $firma_inspectora=$_POST['firmainspectora'];
    $fechaInspeccion=$_POST['fechaInspeccion'];
    $archivo = $_POST['archivo'];
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    $tipo = $_POST['tipo'];
    $estado = 3;
    
    $dir_subida = '../archivos';
    $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
        "El fichero es válido y se subió con éxito.\n";
    } else {
        "¡Posible ataque de subida de ficheros!\n";
    }
    
   
    $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,descripcion,numero_inspeccion,id_cia_seguros,id_oficina_cia_seguros,nombre_solicita,tid_solicita,nid_solicita,tomador,asegurado,id_pais,id_departamento,id_ciudad,direccion,nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,lista_bienes,fecha_posible_inspeccion,id_inspector)
                                VALUES('$usuario','$fechaSolicitud','$estado','$numeroInspeccion','$companiaSeguros','$oficina','$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$tomador','$asegurado','$pais','$departamento_id','$ciudad_id','$direccion','$edificacion','$persona_atiende','$contacto_persona_atiende','$biene','$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion','$inspectorasignado')");
   echo '<script>alert("La información ha sido guardada correctamente")
   window.location.href="../crearencabezadoinspector.php"</script>';
   
}
//////////////////////////////////////////////////////////END REGISTRO ENCABEZADO INSPECTOR ////////////////////////////////////////////////////

//////////////////////////////////////////////////////////INICIA EDITAR ENCABEZADO INSPECTOR ///////////////////////////////////////////////////
if(isset($_POST['editarencabezadoinspector'])){
    $fechaSolicitud = $_POST['fechaSolicitud'];
    echo $identificador = $_POST['identificador'];
    $usuario = $_POST['usuario'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    $companiaSeguros = $_POST['companiaseguros'];
    $oficina = $_POST['oficina'];
    $quienasigna = $_POST['quienasigna'];
    $numeroasigna = $_POST['numeroasigna'];
    $pais = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    echo $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $edificacion=$_POST['nombreedificacion'];
    $persona_atiende=$_POST['nombrepersonaatiende'];
    $contacto_persona_atiende=$_POST['contacto_persona_atiende'];
    $firma_inspectora=$_POST['firmainspectora'];
    $contacto_firma_inspectora = $_POST['contacto_firma_inspectora'];
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    $fechaposibleInspeccion = $_POST['fechaposibleInspeccion'];
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tomador = $_POST['tomador'];
    $asegurado = $_POST['asegurado'];
    $biene =$_POST['biene'];
    
    
    echo $fechaInspeccion=$_POST['fechaInspeccion'];
    $archivo = $_POST['archivo'];

    $tipo = $_POST['tipo'];
    $estado = 3;
    
    $actualizaReg = $mysqli->query("UPDATE enc_inspeccion SET id_usuario='$usuario',nombre_solicita='$nombreSolicitante',tid_solicita='$tipodocumento',nid_solicita='$numeroIdentificacion',tomador='$tomador',asegurado='$asegurado',
    id_ciudad='$ciudad_id',direccion='$direccion',nombre_edificacion='$edificacion',nombre_persona_atiende='$persona_atiende',contacto_persona_atiende='$contacto_persona_atiende',descripcion='3',id_bienes_inspeccionar='$biene',fecha_inspeccion='$fechaInspeccion' WHERE identificador='$identificador'");
    
    

    
     echo '<script>alert("La información ha sido actualizada correctamente")</script>';
     ?>
            <script> 
                 window.onload=function(){
               
                   document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../editarencabezadoinspector" method="POST" onsubmit="procesar(this.action);" >
                 <input  type="hidden" value="<?php echo $_POST['identificador'];  ?>" name="identificador">
                      <input  type="hidden" value="<?php echo $_POST['numero_inspeccion'];  ?>" name="numero_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['cia_seguros'];  ?>" name="cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['fechasolicitud'];  ?>" name="fechasolicitud">
                      <input  type="hidden" value="<?php echo $_POST['id_cia_seguros'];  ?>" name="id_cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['solicitante'];  ?>" name="solicitante">
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
                      <input  type="hidden" value="<?php echo $_POST['fecha_inspeccion'];  ?>" name="fecha_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['numero_inspeccion'];  ?>" name="numero_inspeccion">
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
            </form>
        <?php
}
//window.location.href="../editarencabezadoinspector.php"</script>';
//////////////////////////////////////////////////////////END EDITA ENCABEZADO INSPECTOR ////////////////////////////////////////////////////

if(isset($_POST['encuestaregistra'])){
    'INSPECCION '.$id_inspeccion = $_POST['id_inspeccion']; echo '<br>';
    'BLOQUE INSPECCION '.$bloque_inspeccion = $_POST['bloque_inspeccion']; echo '<br>';
    $id_pregunta = $_POST['id_pregunta'];
    $pregB = $_POST['pregB'];
    $respuesta = $_POST['respuesta'];
    $archivo = $_FILES['archivo']['name'];
    $ruta = '../'.$archivo;
    $respuestaM = $_POST['respuestaM'];
    $arreglo = $_POST['id_arreglo'];
    $id_respuesta = $_POST['id_respuesta'];
    $consecutivo = 1;
    for($i=0,$j=0;$i<=count($id_pregunta),$j<=count($respuesta);$i++,$j++){ 
       
        $sumaconscutivo = $consecutivo++;
        $insertaDatos = $mysqli->query("INSERT INTO enc_detalles_inspeccion(id_inspeccion,consecutivo,bloque_inspeccion,id_pregunta,id_respuesta,respuesta_texto,archivos)VALUES('$id_inspeccion','$sumaconscutivo','$bloque_inspeccion','$id_pregunta[$i]','$id_respuesta[$j]','$respuesta[$j]','$archivo[$j]')");
        
       echo "<script>
                let isBoss = confirm('Inspeccion Registrada Correctamente');
                window.close();
                </script>";
        
        //echo "INSERT INTO enc_detalles_inspeccion(id_inspeccion,consecutivo,bloque_inspeccion,id_pregunta,id_respuesta,respuesta_texto,archivos,consecutivo)VALUES('$id_inspeccion','$sumaconscutivo','$bloque_inspeccion','$id_pregunta[$i]','$id_respuesta[$j]','$respuesta[$j]','$ruta[$j]','$sumaconscutivo');";
        //echo '<br>';

        
   }
    
}

if(isset($_POST['guardarmultiselect'])){
    $id_pregunta = $_POST['id_pregunta'];
    $id_inspeccion = $_POST['id_inspeccion'];
    $id_bloque = $_POST['id_bloque'];
    $id_respuesta = $_POST['id_respuesta'];
    $valor = $_POST['valor'];
    
     for($i=0; $i <= count($valor);$i++){
         $valor[$i];
         '<br>';
         $id_inspeccion[$i];
         $consecutivo = $i+1;
         if($id_inspeccion[$i] > 0 || $id_bloque[$i] > 0 || $id_pregunta[$i] > 0 || $id_respuesta[$i] > 0 || $valor[$i] > 0 || $i >0){
             $insertamultiselect = $mysqli->query("INSERT INTO enc_detalles_inspeccion(id_inspeccion,consecutivo,bloque_inspeccion,id_pregunta,id_respuesta,id_valor_respuesta)VALUES('$id_inspeccion','$consecutivo','$id_bloque','$id_pregunta','$id_respuesta','$valor[$i]')");
             
             echo "<script>
                let isBoss = confirm('Detalles Asociados Correctamente');
                window.close();
                </script>";
             
             echo "INSERT INTO enc_detalles_inspeccion(id_inspeccion,consecutivo,bloque_inspeccion,id_pregunta,id_respuesta,id_valor_respuesta)VALUES('$id_inspeccion','$consecutivo','$id_bloque','$id_pregunta','$id_respuesta','$valor[$i]";
         }
     }
}

if(isset($_POST['nuevainspeccionfreemium'])){
    'CREANDO INSPECCION FREEMIUM';
    $fecha_solicitud =  date('Y-m-d');
    $año = date('Y');
    $id_usuario_ins = $_POST['id_usuario_ins'];
    $consultaprevia = $mysqli->query("SELECT *,MAX(consecutivo) maximo_fr FROM enc_inspeccion WHERE origen LIKE '%FR';");
    $extraermaximo = $consultaprevia->fetch_array(MYSQLI_ASSOC);
    $maximofremiumB = $extraermaximo['maximo_fr'];
    $maximofremium = $extraermaximo['maximo_fr']+1;
    $maximoidentificador = $extraermaximo['identificador'];
    $numero_inspeccion = 'FR-'.$año.'-'.$maximofremium;
    $consultasolicita = $mysqli->query("SELECT * FROM sg_usuarios WHERE identificador = '$id_usuario_ins'");
    $extraerdatosusuario = $consultasolicita->fetch_array(MYSQLI_ASSOC);
    $nombre_usuario = $extraerdatosusuario['nombre'].' '.$extraerdatosusuario['apellidos'];
    
    //echo "INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,numero_inspeccion,nombre_solicita,nombre_edificacion,origen,consecutivo)VALUES('$id_usuario_ins','$fecha_solicitud','$numero_inspeccion','$nombre_usuario','Edificacion Freemium','FR','$maximofremium')";

    
    $consultaestadoterminado = $mysqli->query("SELECT COUNT(*) AS existe_fecha FROM enc_inspeccion WHERE id_usuario = '$id_usuario_ins' AND fecha_terminacion IS NOT NULL AND origen LIKE '%FR%'")or die(mysqli_error);
    $extraerdatosestado = $consultaestadoterminado->fetch_array(MYSQLI_ASSOC);
    $datosfechaexistencia = $extraerdatosestado['existe_fecha'];
    
    if($datosfechaexistencia == NULL || $datosfechaexistencia == 0){
        $insertanuevainspeccion = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,numero_inspeccion,nombre_solicita,nombre_edificacion,origen,consecutivo)VALUES('$id_usuario_ins','$fecha_solicitud','$numero_inspeccion','$nombre_usuario','Edificacion Freemium','FR','$maximofremium')");
    ?>
            <script> 
                 window.onload=function(){
               
                   document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../PruebaTextDevp" method="POST" onsubmit="procesar(this.action);" >
                <input  type="hidden" value="<?php echo $maximofremium ;  ?>" name="id_encuesta">
                <input  type="hidden" value="1" name="id_bloque">
                <input  type="hidden" value="1" name="id_pregunta">
                 <input  type="hidden" value="<?php echo $extraermaximo['identificador'];  ?>" name="identificador">
                      <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['cia_seguros'];  ?>" name="cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['fechasolicitud'];  ?>" name="fechasolicitud">
                      <input  type="hidden" value="<?php echo $_POST['id_cia_seguros'];  ?>" name="id_cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['solicitante'];  ?>" name="solicitante">
                      <input  type="hidden" value="<?php echo $_POST['tipodocumento'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo $extraermaximo['identificador'];  ?>" name="identificacion">
                      <input  type="hidden" value="<?php echo $_POST['tomador'];  ?>" name="tomador">
                      <input  type="hidden" value="<?php echo $_POST['asegurado'];  ?>" name="asegurado">
                      <input  type="hidden" value="<?php echo $_POST['nombreedificacion'];  ?>" name="nombreedificacion">
                      <input  type="hidden" value="<?php echo $_POST['nombrepersonaatiende'];  ?>" name="nombrepersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['contactopersonaatiende'];  ?>" name="contactopersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['firmainspectora'];  ?>" name="firmainspectora">
                      <input  type="hidden" value="<?php echo $_POST['pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $_POST['departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $_POST['ciudad'];  ?>" name="ciudad_id">
                      <input  type="hidden" value="<?php echo $_POST['fecha_inspeccion'];  ?>" name="fecha_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['numero_inspeccion'];  ?>" name="numero_inspeccion">
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
            </form>
    <?php
    }else{
    ?> 
     <script> 
                 window.onload=function(){
               
                   document.forms["miformulario"].submit();
                 }
            </script>
     <form name="miformulario" action="../PruebaTextDevp" method="POST" onsubmit="procesar(this.action);" >
                <input  type="hidden" value="<?php echo  $maximofremiumB ;  ?>" name="id_encuesta">
                <input  type="hidden" value="1" name="id_bloque">
                <input  type="hidden" value="1" name="id_pregunta">
                 <input  type="hidden" value="<?php echo $extraermaximo['identificador'];  ?>" name="identificador">
                      <input  type="hidden" value="<?php echo $numero_inspeccion;  ?>" name="numero_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['cia_seguros'];  ?>" name="cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['fechasolicitud'];  ?>" name="fechasolicitud">
                      <input  type="hidden" value="<?php echo $_POST['id_cia_seguros'];  ?>" name="id_cia_seguros">
                      <input  type="hidden" value="<?php echo $_POST['solicitante'];  ?>" name="solicitante">
                      <input  type="hidden" value="<?php echo $_POST['tipodocumento'];  ?>" name="tipodocumento">
                      <input  type="hidden" value="<?php echo $extraermaximo['identificador'];  ?>" name="identificacion">
                      <input  type="hidden" value="<?php echo $_POST['tomador'];  ?>" name="tomador">
                      <input  type="hidden" value="<?php echo $_POST['asegurado'];  ?>" name="asegurado">
                      <input  type="hidden" value="<?php echo $_POST['nombreedificacion'];  ?>" name="nombreedificacion">
                      <input  type="hidden" value="<?php echo $_POST['nombrepersonaatiende'];  ?>" name="nombrepersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['contactopersonaatiende'];  ?>" name="contactopersonaatiende">
                      <input  type="hidden" value="<?php echo $_POST['firmainspectora'];  ?>" name="firmainspectora">
                      <input  type="hidden" value="<?php echo $_POST['pais'];  ?>" name="pais">
                      <input  type="hidden" value="<?php echo $_POST['departamento'];  ?>" name="departamento">
                      <input  type="hidden" value="<?php echo $_POST['ciudad'];  ?>" name="ciudad_id">
                      <input  type="hidden" value="<?php echo $_POST['fecha_inspeccion'];  ?>" name="fecha_inspeccion">
                      <input  type="hidden" value="<?php echo $_POST['numero_inspeccion'];  ?>" name="numero_inspeccion">
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
            </form>
    <?php        
       
    }
    
}


?>