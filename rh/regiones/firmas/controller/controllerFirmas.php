<?php

/*********** INCLUIR LA CONEXION *************/
$mysqli = new mysqli('localhost','risk_hunter','Kaliman01*','sipman_risk_hunter');
/*********** DECLARACION DE VARIABLES *************/

if (isset($_POST['registrarFirmas'])) {
 
     $firmaInspectora = $_POST['nombreFirma'];
     $direccion = $_POST['direccion'];
     $numeroIdentificacion = $_POST['numeroIdentificacion'];
     $numeroContacto = $_POST['telefono'];
     $correoElectronico = $_POST['correoElectronico'];
     $paises_id = $_POST['paises_id'];
     $departamento_id = $_POST['departamento_id'];
     $ciudad_id = $_POST['ciudad_id'];
     $tipoDoc = $_POST['tipoDoc'];
     $tipoEstado = 20;
     $tipoTercer = 774;
     $idtercero = $_POST['idtercero'];
    
   /*
   
   - Firma Act => Estado=1 Tipo Cliente=0
   - Firma Des => Estado=0 Tipo Cliente=0
   
   */
   $validacionFirmaexistente = $mysqli->query("SELECT * FROM ter_terceros WHERE numero_identificacion ='$numeroIdentificacion'");
   $repiteFirma = mysqli_num_rows($validacionFirmaexistente);
   if($repiteFirma>0){
      echo '<script language="javascript">alert("La firma inspectora que desea ingresar ya existe,por favor modifique la información.");
    window.location.href="../registroFirmasInspectoras.php"</script>';
   }else{
   $insertaRegistroFirma = $mysqli->query("INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente)
   VALUES('$tipoDoc','$firmaInspectora','$tipoTercer','$tipoEstado','1','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$correoElectronico','$numeroContacto','0')");
   
    $destinatario = $correoElectronico;
    $destinatario = $correoElectronico;
    $asunto = $asunto;
    $datossaludo = "<html>
    <head>
    <title>Creacion de Firma Inspectora en RH+</title>
    </head>
    <body>
    <h1>Senores ".$firmaInspectora."</h1><br>";
    $datosusuario = "<br><h2>Ha sido registrado como firma inspectora</h2><br>";
    $cuerpo = $datossaludo.$texto.$datosusuario.$textof."</body></html>";
    
    //para el env�o en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    //direcci�n del remitente
    $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <". $remite.">\r\n";
    
    
    mail($destinatario,$asunto,$cuerpo,$headers) ;
    
    echo '<script language="javascript">alert("Se ha registrado la firma ' . strtoupper($firmaInspectora) . ' correctamente.");
    window.location.href="../registroFirmasInspectoras.php"</script>';
    }
}
if (isset($_POST['editarFirmas'])) {
    

    $idFirma = $_POST['idFirma'];
    $firmaInspectora = $_POST['nombreFirma'];
    $direccion = $_POST['direccion'];
    $numeroContacto = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $idtercero = $_POST['tipoCliente'];
    $tipoEstado = 20;
    $tipoTercer = 774;
    
    
    
     $editarFirma = $mysqli->query("UPDATE ter_terceros SET nombres = '$firmaInspectora',vdom_tipo_identificacion = '$tipoDocumento',tipo_estado='$tipoEstado',numero_identificacion='$numeroIdentificacion',pais = '$paises_id',departamento='$departamento_id',ciudad='$ciudad_id',direccion='$direccion',correo_electronico='$correoElectronico',telefono='$numeroContacto' ,estado='1',tipoCliente='0' WHERE identificacion = '$idFirma'");
 echo '<script language="javascript">alert("La firma inspectora ' . strtoupper($firmaInspectora) . ' ha sido actualizada.");
        window.location.href="../listaFirmasInspectoras.php"</script>';
}

if(isset($_POST['desactivarFirma'])){
     $idFirma = $_POST['id'];
    
     $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='0' WHERE identificacion='$idFirma'");
    echo '<script language="javascript">alert("Firma Inspectora Desactivada");
        window.location.href="../listaFirmasInspectoras.php"</script>';
       
}


if(isset($_POST['activarFirma'])){
     $idFirma = $_POST['id'];
    
     $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='1' WHERE identificacion='$idFirma'");
    echo '<script language="javascript">alert("Firma Inspectora Activada");
        window.location.href="../listaFirmasInspectoras.php"</script>';
       
}

if(isset($_POST['registrarCompaniaSeguros'])){
     $firmaInspectora = $_POST['nombreFirma'];
     $direccion = $_POST['direccion'];
     $numeroIdentificacion = $_POST['numeroIdentificacion'];
     $numeroContacto = $_POST['telefono'];
     $correoElectronico = $_POST['correoElectronico'];
     $paises_id = $_POST['paises_id'];
     $departamento_id = $_POST['departamento_id'];
     $ciudad_id = $_POST['ciudad_id'];
     $tipoDoc = $_POST['tipoDoc'];
     $tipoEstadoC = 20;
     $tipoTercer = 772;
    
    /*
   
   - Compañia Act => Estado=1 Tipo Cliente=0
   - Compañia Des => Estado=0 Tipo Cliente=0
   
   */
    $validacionCompañiaExistente = $mysqli->query("SELECT * FROM ter_terceros WHERE numero_identificacion ='$numeroIdentificacion'");
    $repiteCompañia = mysqli_num_rows($validacionCompañiaExistente);
    
   if($repiteCompañia>0){
      echo '<script language="javascript">alert("La compañia de seguros que desea ingresar ya existe,por favor modifique la información.");
    window.location.href="../listacompaniaseguros.php"</script>';
   }else{
    $insertaRegistroCompaniaSeguros = $mysqli->query("INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente)
   VALUES('$tipoDoc','$firmaInspectora','$tipoTercer','$tipoEstadoC','1','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$correoElectronico','$numeroContacto','0')");
   
    echo '<script language="javascript">alert("Se ha registrado la compañia de seguros ' . strtoupper($firmaInspectora) . ' correctamente.");
        window.location.href="../crearcompaniaseguros.php"</script>';
    }
}

if (isset($_POST['editarcompaniaseguros'])) {
    

    $idFirma = $_POST['idFirma'];
    $firmaInspectora = $_POST['nombreFirma'];
    $direccion = $_POST['direccion'];
    $numeroContacto = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tipoEstado = 20;
    $tipoTercer = 772;
    
    
    
     $editarFirma = $mysqli->query("UPDATE ter_terceros SET nombres = '$firmaInspectora',vdom_tipo_identificacion = '$tipoDocumento',tipo_estado='$tipoEstadoC',numero_identificacion='$numeroIdentificacion',pais = '$paises_id',departamento='$departamento_id',ciudad='$ciudad_id',direccion='$direccion',correo_electronico='$correoElectronico',telefono='$numeroContacto' ,estado='1',tipoCliente='0' WHERE identificacion = '$idFirma'");
 echo '<script language="javascript">alert("La compañia ' . strtoupper($firmaInspectora) . ' ha sido actualizada.");
        window.location.href="../crearcompaniaseguros.php"</script>';
}

if(isset($_POST['desactivarCompaniaSeguros'])){
     $idFirma = $_POST['id'];
    
     $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='0' WHERE identificacion='$idFirma' AND vdom_tipo_tercero = '772'");
    echo '<script language="javascript">alert("Compañia de Seguros Desactivada");
        window.location.href="../listacompaniaseguros.php"</script>';
       
}


if(isset($_POST['activarCompaniaSeguros'])){
     $idFirma = $_POST['id'];
     $tipoTercer = 772;
     $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='1' WHERE identificacion='$idFirma' AND vdom_tipo_tercero='772' ");
    echo '<script language="javascript">alert("Compañia de Seguros Activada");
        window.location.href="../listacompaniaseguros.php"</script>';
       
}


if(isset($_POST['asignarfirma'])){
    echo $fechaInicial = $_POST['fechaInicial'];
    echo $fechaFinal = $_POST['fechaFinal'];
    echo $idfirma = $_POST['idfirma'];
    echo $tercero = $_POST['tercero'];
    
    $eliminaanteriores = $mysqli->query("DELETE FROM ter_cruce_terceros WHERE id_tercero_principal = $idfirma");
    $i = 0;
    $terceros = "";
    
    foreach($_POST['tercero'] as $t){
        $terceros[$i]=$t;
        $terceros = ("".$terceros[$i]."");
        
        $insertaTerceros = $mysqli->query("INSERT INTO ter_cruce_terceros (	id_tercero_principal,id_tercero_secundario,fecha_inicial,fecha_vigencia)VALUES('$idfirma','$terceros','$fechaInicial','$fechaFinal')");
        echo '<script language="javascript">alert("Firmas Asignadas con exito");
        window.location.href="../listacompaniaseguros.php"</script>';
        
    }
    
    
    //window.location.href="../listarplanes.php"</script>'; 
    
}



?>