<?php
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
        echo $campoTexto2 = $_POST[$campoTexto];//$_POST[$campoTexto]
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
    //$email = $_POST['email'];
    $estado = 1;
    $ultimo = $_POST['ultimo'];
    
    settype($ultimo);
    settype($contacto_firma_inspectora);
    
    $archivo = $_POST['archivo'];
    
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    
    $dir_subida = '../archivos';
    $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
        "El fichero es válido y se subió con éxito.\n";
    } else {
        "¡Posible ataque de subida de ficheros!\n";
    }
    
    //print_r($_FILES);
    
    //print "</pre>";
    $consultadatosfirmas = $mysqli->query("SELECT * FROM ter_terceros WHERE identificacion='$firma_inspectora'");
    $extraerDatos = $consultadatosfirmas->fetch_array(MYSQLI_ASSOC);
    $correoelectronico = $extraerDatos['correo_electronico'];
    
    if($firma_inspectora == NULL){
       $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,descripcion,numero_inspeccion,id_cia_seguros,id_oficina_cia_seguros,nombre_solicita,tid_solicita,nid_solicita,tomador,asegurado,id_pais,id_departamento,id_ciudad,direccion,nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,lista_bienes,fecha_posible_inspeccion,id_inspector,origen,consecutivo,contacto_firma)
                             VALUES('$usuario','$fechaSolicitud','$descripcion','$numeroInspeccion','$companiaSeguros','$oficina','$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$tomador','$asegurado','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion','$persona_atiende','$contacto_persona_atiende','$biene','$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion','$tipo','$origen','$ultimo','$contacto_firma_inspectora')");
        
    $destinatario = $correoelectronico;
    $asunto = $asunto;
    $datossaludo = "<html>
        <head>
   <title>Creacion de Usuario Inspector en RH+</title>
    </head>
    <body>
    <h1>Senor(a) ". $nombres." ".$apellidos."</h1><br>";
    $datosusuario = "<br><h2>Usuario Asignado: ". $usuario."</h2><br>";
    $mensajedelink = "<br> Ingrese a la plataforma por este link: ";
    $link = " http://rh.deshida.com.co/rh/regiones/log.php  <br>";
    $cuerpo = $datossaludo.$texto.$datosusuario.$mensajedelink.$link.$textof."</body></html>";
    
    //para el env�o en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    //direcci�n del remitente
    $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <". $remite.">\r\n";
    
    //direcci�n de respuesta, si queremos que sea distinta que la del remitente
    $headers .= "Reply-To: ".$remite."\r\n";
    
    //direcciones que recibi�n copia
    $headers .= "Cc: ".$cc."\r\n";
    
    mail($destinatario,$asunto,$cuerpo,$headers) ;   

    echo '<script>alert("Encabezado Compañia de Seguros Registrado Exitosamente")
    window.location.href="../crearencabezadocompaniaaseguradora.php"</script>';
    }else{
        $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,descripcion,numero_inspeccion,id_cia_seguros,id_oficina_cia_seguros,nombre_solicita,tid_solicita,nid_solicita,tomador,asegurado,id_pais,id_departamento,id_ciudad,direccion,nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,lista_bienes,fecha_posible_inspeccion,id_inspector,origen,consecutivo,contacto_firma)
                             VALUES('$usuario','$fechaSolicitud','$descripcion','$numeroInspeccion','$companiaSeguros','$oficina','$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$tomador','$asegurado','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion','$persona_atiende','$contacto_persona_atiende','$biene','$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion','$tipo','$origen','$ultimo','$contacto_firma_inspectora')");

    
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
    $numeroInspeccion = $_POST['numeroInspeccion'];
    $firma_inspectora=$_POST['firmainspectora'];
    $contacto_firma_inspectora = $_POST['contacto_firma_inspectora'];
    $oficina = $_POST['oficina'];
    $idquienasigna = $_POST['quienasigna'];
    $numeroasigna = $_POST['numeroasigna'];
    $nombreSolicitante = $_POST['nombreSolicitante'];
    $tipodocumento  = $_POST['tipoDoc'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    echo $paises_id = $_POST['paises_id'];
    echo $departamento_id = $_POST['departamento_id'];
    echo $ciudad_id = $_POST['ciudad_id'];
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
     echo '<br>';
    
    if($tipo == '775'){
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
           $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,  descripcion ,numero_inspeccion,   id_oficina_cia_seguros, nombre_solicita,      tid_solicita,   nid_solicita,           id_pais, id_departamento,   id_ciudad,   direccion,   nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,   id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,  lista_bienes,     fecha_posible_inspeccion, id_inspector,       consecutivo,    origen)
                                                              VALUES('$usuario','$fechaSolicitud','$estado'   ,'$numeroInspeccion', '$oficina',             '$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion',    '$persona_atiende',    '$contacto_persona_atiende','$biene',              '$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion',        '$inspectorasignado','$extraerUltomo','FI')");
           
           
           
           echo "INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,  descripcion ,numero_inspeccion,   id_oficina_cia_seguros, nombre_solicita,      tid_solicita,   nid_solicita,           id_pais, id_departamento,   id_ciudad,   direccion,   nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,   id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,  lista_bienes,     fecha_posible_inspeccion, id_inspector,       consecutivo,    origen)
                                    VALUES('$usuario','$fechaSolicitud','$estado'   ,'$numeroInspeccion', '$oficina',             '$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$edificacion',    '$persona_atiende',    '$contacto_persona_atiende','$biene',              '$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion',        '$inspectorasignado','$extraerUltomo','FI')";
           
           
           
           //echo '<script>alert("Encabezado Firma Inspectora Registrado Exitosamente")
           //window.location.href="../crearencabezadofirmainspectora.php"</script>';
   
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
            $texto = $firma_inspectora.'le ha asignado la inspección número'.$numeroInspeccion.' , por favor ingrese al aplicativo  Risk Hunter Plus y y continúe con el proceso de inspección, poniéndose en contacto con' .$contacto_persona_atiende. 'al numero'.$contacto_firma_inspectora.',para coordinar y  diligenciar la Fecha de inspección.<br>Le deseamos muchos éxitos con la inspección. 
            <br>Saludos cordiales, equipo RH+.';
            $cuerpo = $datossaludo.$texto.$mensajedelink.$saludo."</body></html>";
    
            //para el env�o en formato HTML
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
            //direcci�n del remitente
            
            mail($destinatario,$asunto,$cuerpo,$headers) ;
   
   
           //echo '<script>alert("La información ha sido guardada correctamente")
           //window.location.href="../crearencabezadofirmainspectora.php"</script>';
        }
        
        if($tipo == '776'){
        'Entra a 776';
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
        
            $insertaReg = $mysqli->query("INSERT INTO enc_inspeccion(id_usuario,fecha_solicitud,  descripcion ,numero_inspeccion,   id_oficina_cia_seguros, nombre_solicita,      tid_solicita,   nid_solicita,           id_pais, id_departamento,   id_ciudad,   direccion,   nombre_edificacion,nombre_persona_atiende,contacto_persona_atiende,   id_bienes_inspeccionar,id_firma_inspectora,fecha_inspeccion,  lista_bienes,     fecha_posible_inspeccion, id_inspector,       consecutivo,    origen)
                                                              VALUES('$usuario','$fechaSolicitud','$estado'   ,'$numeroInspeccion', '$oficina',             '$nombreSolicitante','$tipodocumento','$numeroIdentificacion','$pais','$departamento_id','$ciudad_id','$direccion','$edificacion',    '$persona_atiende',    '$contacto_persona_atiende','$biene',              '$firma_inspectora','$fechaInspeccion','$fichero_subido','$fechaInspeccion',        '$inspectorasignado','$extraerUltomo','IN')");
           //echo '<script>alert("Encabezado Firma Inspectora Registrado Exitosamente")
           //.location.href="../crearencabezadofirmainspectora.php"</script>';
            
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
            $texto = $firma_inspectora.'le ha asignado la inspección número'.$numeroInspeccion.' , por favor ingrese al aplicativo  Risk Hunter Plus y y continúe con el proceso de inspección, poniéndose en contacto con' .$contacto_persona_atiende. 'al numero'.$contacto_firma_inspectora.',para coordinar y  diligenciar la Fecha de inspección.<br>Le deseamos muchos éxitos con la inspección. 
            <br>Saludos cordiales, equipo RH+.';
            $cuerpo = $datossaludo.$texto.$mensajedelink.$saludo."</body></html>";
            
            //para el env�o en formato HTML
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            
            //direcci�n del remitente
            
            mail($destinatario,$asunto,$cuerpo,$headers) ;
   
   
           echo '<script>alert("La información ha sido guardada correctamente")
           window.location.href="../crearencabezadofirmainspectora.php"</script>';
   
        }
    }
//////////////////////////////////////////////////////////END REGISTRO ENCABEZADO FIRMAS //////////////////////////////////////////////////////

/////////////////////////////////////////////////////////INICIA EDITA ENCABEZADO COMPANIAS ///////////////////////////////////////////////////
if(isset($_POST['editaencabezadocompania'])){
    $emailusuario  = $_POST['email'];
    echo $identificador = $_POST['identificador'];
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
    echo $firma_inspectora=$_POST['firma'];
    echo $contacto_firma_inspectora = $_POST['telefonofirma'];
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
            $texto = $firma_inspectora.'le ha asignado la inspección número'.$numeroInspeccion.' , por favor ingrese al aplicativo  Risk Hunter Plus y y continúe con el proceso de inspección, poniéndose en contacto con' .$contacto_persona_atiende. 'al numero'.$contacto_firma_inspectora.',para coordinar y  diligenciar la Fecha de inspección.<br>Le deseamos muchos éxitos con la inspección. 
            <br>Saludos cordiales, equipo RH+.';
            $cuerpo = $datossaludo.$texto.$mensajedelink.$saludo."</body></html>";
            
            //para el env�o en formato HTML
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            
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
    echo $identificador = $_POST['identificador'];
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
    //$fechaInspeccion=$_POST['fechaInspeccion'];
    $archivo = $_POST['archivo'];
    $archivoNombre = $_FILES['archivo']['name'];
    $guardado = $_FILES['archivo']['tmp_name'];
    $tipo = $_POST['tipo'];
    ////Variables para asignar insp //////
    $inspector = $_POST['inspector'];
    $contactoinspector = $_POST['contactoinspector'];
    $fechaInspeccion = $_POST['fechaInspeccion'];
    
    /////END/////
    
    $dir_subida = '../archivos';
    $fichero_subido = $dir_subida.'/'. basename($_FILES['archivo']['name']);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
        "El fichero es válido y se subió con éxito.\n";
    } else {
        "¡Posible ataque de subida de ficheros!\n";
    }
    
   
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
    $identificador = $_POST['identificador'];
    $usuario = $_POST['usuario'];
    $numeroInspeccion = $_POST['numeroInspeccion'];
    $companiaSeguros = $_POST['companiaseguros'];
    $oficina = $_POST['oficina'];
    $quienasigna = $_POST['quienasigna'];
    $numeroasigna = $_POST['numeroasigna'];
    $pais = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $edificacion=$_POST['edificacion'];
    $persona_atiende=$_POST['persona_atiende'];
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
    
    
    $fechaInspeccion=$_POST['fechaInspeccion'];
    $archivo = $_POST['archivo'];

    $tipo = $_POST['tipo'];
    $estado = 3;
    
    $actualizaReg = $mysqli->query("UPDATE enc_inspeccion SET id_usuario='$usuario',nombre_solicita='$nombreSolicitante',tid_solicita='$tipodocumento',nid_solicita='$numeroIdentificacion',tomador='$tomador',asegurado='$asegurado',
    id_ciudad='$ciudad_id',direccion='$direccion',nombre_edificacion='$edificacion',nombre_persona_atiende='$persona_atiende',contacto_persona_atiende='$contacto_persona_atiende',descripcion='3',id_bienes_inspeccionar='$biene' WHERE identificador='$identificador'");
     echo '<script>alert("La información ha sido actualizada correctamente")
   window.location.href="../listarencabezadoinspector.php"</script>';
}
//////////////////////////////////////////////////////////END EDITA ENCABEZADO INSPECTOR ////////////////////////////////////////////////////
?>