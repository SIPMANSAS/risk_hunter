<?php

/*********** INCLUIR LA CONEXION *************/
include '../conexions.php';
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
    $inspector = $_POST['inspector'];
    $tipoinspector = $_POST['tipoinspector'];
    
   /*
   
   - Firma Act => Estado=1 Tipo Cliente=0
   - Firma Des => Estado=0 Tipo Cliente=0
   
   */
    $validacionFirmaexistente = $mysqli->query("SELECT * FROM ter_terceros WHERE numero_identificacion ='$numeroIdentificacion'");
    $repiteFirma = mysqli_num_rows($validacionFirmaexistente);
   
    if($repiteFirma>0){
        echo '<script language="javascript">alert("La firma inspectora que desea ingresar ya existe,por favor modifique la información.");
        window.location.href="../registrofirmasinspectoras.php"</script>';
    }else{
        $insertaRegistroFirma = $mysqli->query("INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente,id_tercero)
        VALUES('$tipoDoc','$firmaInspectora','$tipoTercer','$tipoEstado','1','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$correoElectronico','$numeroContacto','$tipoinspector','$inspector')");
   
        $destinatario = $correoElectronico;
        $asunto = 'Creacion Firma Inspectora';
        $datossaludo = "<html>
        <head>
        <title>Creacion de Firma Inspectora en RH+</title>
        </head>
        <body>
        <h1>Senores ".$firmaInspectora."</h1><br>";
        $datosusuario = "<br><h2>Ha sido registrado como firma inspectora</h2><br>";
        $cuerpo = $datossaludo.$texto.$datosusuario."</body></html>";
    
        //para el env�o en formato HTML
       $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            
    
        //direcci�n del remitente
        $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <". $remite.">\r\n";
    
        mail($destinatario,$asunto,$cuerpo,$headers) ;
    
        echo '<script language="javascript">alert("Se ha registrado la firma ' . strtoupper($firmaInspectora) . ' correctamente.");
        window.location.href="../registrofirmasinspectoras.php"</script>';
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
    $tipoinspector = $_POST['tipoinspector'];
    

    $editarFirma = $mysqli->query("UPDATE ter_terceros SET nombres = '$firmaInspectora',vdom_tipo_identificacion = '$tipoDocumento',tipo_estado='$tipoEstado',numero_identificacion='$numeroIdentificacion',pais = '$paises_id',departamento='$departamento_id',ciudad='$ciudad_id',direccion='$direccion',correo_electronico='$correoElectronico',telefono='$numeroContacto' ,estado='1',tipoCliente='$tipoinspector' WHERE identificacion = '$idFirma'");
    echo '<script language="javascript">alert("La firma inspectora ' . strtoupper($firmaInspectora) . ' ha sido actualizada.");
    window.location.href="../listafirmasinspectoras.php"</script>';
}

if(isset($_POST['desactivarFirma'])){
    
    $idFirma = $_POST['id'];
    
    $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='0' WHERE identificacion='$idFirma'");
    echo '<script language="javascript">alert("Firma Inspectora Desactivada");
    window.location.href="../listafirmasinspectoras.php"</script>';
}

if(isset($_POST['activarfirmas'])){
    
    $idFirma = $_POST['id'];
    
    $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='1' WHERE identificacion='$idFirma'");
    echo '<script language="javascript">alert("Firma Inspectora Activada");
    window.location.href="../listafirmasinspectoras.php"</script>';
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
    
    $desactivaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='0' WHERE identificacion='$idFirma'");
    echo '<script language="javascript">alert("Compañia de Seguros Desactivada");
    window.location.href="../listacompaniaseguros.php"</script>';
}

if(isset($_POST['activarCompaniaSeguros'])){
    
    $idFirma = $_POST['id'];
    $tipoTercer = 772;
    
    $activaFirmas= $mysqli->query("UPDATE ter_terceros SET estado='1' WHERE identificacion='$idFirma' AND vdom_tipo_tercero='772' ");
    echo '<script language="javascript">alert("Compañia de Seguros Activada");
    window.location.href="../listacompaniaseguros.php"</script>';
}

if(isset($_POST['asignarfirma'])){
    
    $fechaInicial = $_POST['fechaInicial'];
    $fechaFinal = $_POST['fechaFinal'];
    $idfirma = $_POST['idfirma'];
    $tercero = $_POST['tercero'];
    
    $eliminaanteriores = $mysqli->query("DELETE FROM ter_cruce_terceros WHERE id_tercero_principal = $idfirma");
    $i = 0;
    $terceros = "";
    
    foreach($_POST['tercero'] as $t){
        $terceros[$i]=$t;
        $terceros = ("".$terceros[$i]."");
        if($fechaFinal || $fechaInicial == NULL){
            echo 'Vacios';
        }else{
            $insertaTerceros = $mysqli->query("INSERT INTO ter_cruce_terceros (	id_tercero_principal,id_tercero_secundario,fecha_inicial,fecha_vigencia)VALUES('$idfirma','$terceros','$fechaInicial','$fechaFinal')");
            echo '<script language="javascript">alert("Firmas Asignadas con exito");
            window.location.href="../listacompaniaseguros.php"</script>';
        }
    }
}

if(isset($_POST['desasignarfirma'])){
    
    $tercero = $_POST['tercero'];
    $id = $_POST['id'];
    
    $desasignarfirma = $mysqli->query("UPDATE ter_cruce_terceros SET estado = '2' WHERE id_tercero_principal = '$id' AND id_tercero_secundario='$tercero' AND estado=1");
    echo '<script language="javascript">alert("Firma Inspectora Desasignada");
    window.location.href="../listacompaniaseguros.php"</script>';
}


if(isset($_POST['desasignarinspector'])){
    
    'Firma '.$idFirma = $_POST['idFirma'];
    'Usuario '.$id = $_POST['id'];
    
    $desasignasInspector = $mysqli->query("DELETE FROM sg_usuarios_x_cliente WHERE id_cliente='$idFirma' AND id_usuario='$id'");
    //$desasignarfirma = $mysqli->query("UPDATE ter_cruce_terceros SET estado = '2' WHERE id_tercero_principal = '$id' AND id_tercero_secundario='$tercero' AND estado=1");
    echo '<script language="javascript">alert("Inspector Desasignado");
    window.location.href="../listafirmasinspectoras.php"</script>';
}

if(isset($_POST['registrarinspectorindependiente'])){
    
    $inspector = $_POST['nombreInspector'];
    $apellidos = $_POST['apellidoInspector'];
    $direccion = $_POST['direccion'];
    $numeroContacto = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $tipoDocumento = $_POST['tipoDoc'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tipoestado = 28;
    $rol = 11;
    $prapellidos = explode(" ", $apellidos);
    $nombreorig = explode(" ", $inspector);
    $dosdigitos = substr($numeroIdentificacion, -3);
    $user = $prapellidos[0]."_".$nombreorig[0].$dosdigitos;

    $registrainspectorind = $mysqli->query("INSERT INTO sg_usuarios(email,nombre,apellidos,tipo_estado,estado,vdom_tipo_identificacion,numero_telefono,id_pais,id_departamento,id_ciudad,direccion,numidentificacion,usuario,password)VALUES('$correoElectronico','$inspector','$apellidos','$tipoestado','1','$tipoDocumento','$numeroContacto','$paises_id','$departamento_id','$ciudad_id','$direccion','$numeroIdentificacion','$user','$user')");
    echo '<script language="javascript">alert("Se ha registrado el inspector ' . strtoupper($inspector) . ' correctamente.");
    window.location.href="../registroinspectoresindependientes.php"</script>';
}

if(isset($_POST['editarinspectorindependiente'])){
    
    $idInspector = $_POST['idInspector'];
    $firmaInspectora = $_POST['nombreInspector'];
    $apellidos = $_POST['apellidoInspector'];
    $direccion = $_POST['direccion'];
    $numeroContacto = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tipoEstado = 28;
    '<br>';
    
    $editarInspector = $mysqli->query("UPDATE sg_usuarios SET nombre = '$firmaInspectora',apellidos='$apellidos',vdom_tipo_identificacion='$tipoDocumento',tipo_estado='$tipoEstado',numidentificacion='$numeroIdentificacion',id_pais='$paises_id',id_departamento='$departamento_id',id_ciudad='$ciudad_id',direccion='$direccion',email='$correoElectronico',numero_telefono='$numeroContacto' ,estado='1' WHERE identificador='$idInspector'");
    echo '<script language="javascript">alert("El inspector ' . strtoupper($firmaInspectora) . ' ha sido actualizado.");
    window.location.href="../listainspectoresindependientes.php"</script>';
}

if(isset($_POST['desactivarinspectorindependiente'])){
    
    $idInspector = $_POST['id'];
    $tipoEstado = 28;
    
    $editarInspector = $mysqli->query("UPDATE sg_usuarios SET estado='0' WHERE identificador='$idInspector' AND $tipoEstado='$tipoEstado'");
    echo '<script language="javascript">alert("El inspector ' . strtoupper($firmaInspectora) . ' ha sido desactivado.");
    window.location.href="../listainspectoresdesactivados.php"</script>';
}

if(isset($_POST['activarinspectorindependiente'])){
    
    $idInspector = $_POST['id'];
    $tipoEstado = 28;
    
    $editarInspector = $mysqli->query("UPDATE sg_usuarios SET estado='1' WHERE identificador='$idInspector' AND $tipoEstado='$tipoEstado'");
    echo '<script language="javascript">alert("El inspector ' . strtoupper($firmaInspectora) . ' ha sido activado.");
    window.location.href="../listainspectoresindependientes.php"</script>';
}

if(isset($_POST['registrarinspectorfirmainspectora'])){
    echo 'entra';
    $inspector = $_POST['nombreInspector'];
    $apellidos = $_POST['apellidoInspector'];
    $direccion = $_POST['direccion'];
    $numeroContacto = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $tipoDocumento = $_POST['tipoDoc'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tipoestado = 27;
    $prapellidos = explode(" ", $apellidos);
    $nombreorig = explode(" ", $inspector);
    $dosdigitos = substr($numeroIdentificacion, -3);
    $user = $prapellidos[0]."_".$nombreorig[0].$dosdigitos;
    
    $registrainspectorind = $mysqli->query("INSERT INTO sg_usuarios(email,nombre,apellidos,tipo_estado,estado,vdom_tipo_identificacion,numero_telefono,id_pais,id_departamento,id_ciudad,direccion,numidentificacion,usuario,password)VALUES('$correoElectronico','$inspector','$apellidos','$tipoestado','1','$tipoDocumento','$numeroContacto','$paises_id','$departamento_id','$ciudad_id','$direccion','$numeroIdentificacion','$user','$user')");
    echo '<script language="javascript">alert("Se ha registrado el inspector de firma inspectora ' . strtoupper($inspector) . ' correctamente.");
    window.location.href="../crearinspectorfirmainspectora.php"</script>';
}

if(isset($_POST['editarinspectorfirma'])){
    
    $idInspector = $_POST['idInspector'];
    $firmaInspectora = $_POST['nombreInspector'];
    $apellidos = $_POST['apellidoInspector'];
    $direccion = $_POST['direccion'];
    $numeroContacto = $_POST['telefono'];
    $correoElectronico = $_POST['correoElectronico'];
    $paises_id = $_POST['paises_id'];
    $departamento_id = $_POST['departamento_id'];
    $ciudad_id = $_POST['ciudad_id'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroIdentificacion = $_POST['numeroIdentificacion'];
    $tipoEstado = 27;
    '<br>';
    
    $editarInspector = $mysqli->query("UPDATE sg_usuarios SET nombre = '$firmaInspectora',apellidos='$apellidos',vdom_tipo_identificacion='$tipoDocumento',tipo_estado='$tipoEstado',numidentificacion='$numeroIdentificacion',id_pais='$paises_id',id_departamento='$departamento_id',id_ciudad='$ciudad_id',direccion='$direccion',email='$correoElectronico',numero_telefono='$numeroContacto' ,estado='1' WHERE identificador='$idInspector'");
    echo '<script language="javascript">alert("El inspector ' . strtoupper($firmaInspectora) . ' ha sido actualizado.");
    window.location.href="../listainspectoresfirmas.php"</script>';
}

if(isset($_POST['activarinspectorfirmainspectora'])){
    
    $idInspector = $_POST['id'];
    $tipoEstado = 27;
    
    $editarInspector = $mysqli->query("UPDATE sg_usuarios SET estado='1' WHERE identificador='$idInspector' AND $tipoEstado='$tipoEstado'");
    echo '<script language="javascript">alert("El inspector ' . strtoupper($firmaInspectora) . ' ha sido activado.");
    window.location.href="../listainspectoresfirmas.php"</script>';
}

if(isset($_POST['desactivarinspectorfirmainspectora'])){
    
    $idInspector = $_POST['id'];
    $tipoEstado = 27;
    
    $editarInspector = $mysqli->query("UPDATE sg_usuarios SET estado='0' WHERE identificador='$idInspector' AND $tipoEstado='$tipoEstado'");
    echo '<script language="javascript">alert("El inspector ' . strtoupper($firmaInspectora) . ' ha sido activado.");
    window.location.href="../listainspectoresfirmasdesactivados.php"</script>';
    
}



?>